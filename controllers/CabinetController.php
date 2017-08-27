<?php

/**
 * Контроллер CabinetController
 * Работа с данными пользователя
 */

class CabinetController
{
    /**
    * Action для домашней страницы кабинета пользователя
    * @return boolean
    */
    public function actionIndex()
    {
        // Получаем идентификатор пользователя из сессии
        $userId = Helper::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }

    /**
    * Action для  изменения данных пользователя
    * @return boolean
    */
    public function actionEdit()
    {
        // Получаем идентификатор пользователя из сессии
        $userId = Helper::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        $name = $user['name'];
        $password = $user['password'];
        $email = $user['email'];

        $result = false;

        if (isset($_POST['user_edit'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];
            $email =  $_POST['email'];

            $errors = false;

            if (!Helper::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов.';
            }

            if (!Helper::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов.';
            }

            //добавить проверку почты
            if (!Helper::checkEmail($email)) {
                $errors[] = 'Введите правильный адрес электронной почты.';
            }

            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
            }

        }

        require_once(ROOT . '/views/cabinet/edit.php');
        return true;
    }

    /**
    * Action для страницы списка заказов пользователя
    * @return boolean
    */
    public static function actionOrderList() {
        // Получаем идентификатор пользователя из сессии
        $userId = Helper::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);
        $userEmail = $user["email"];

        //формируем список заказов
        $orderList = Order::getOrderListByUserEmail($userEmail);

        //если заказы были
        if(!empty($orderList)){
            //сумма по всем заказам
            $totalSumm = 0;

            //формируем список концертов и суммы заказов
            $eventList = null;
            $i = 0;
            foreach ($orderList as $order){
                //концерты
                $eventId = $order["eventId"];
                $eventList[] = Event::getEventItemById($eventId);

                //формируем список билетов в заказе
                $ticketList = Ticket::getTicketList($eventId);

                //вычисляем сумму заказов
                $orderSumm = Price::calculatePriceSumm($ticketList);

                //формируем сумму по всем заказам
                $totalSumm += $orderSumm;

                //записываем сумму заказа в массив
                $orderList[$i]["summ"] = $orderSumm;
                $i++;
            }
        }

        //подключаем вид
        require_once(ROOT . '/views/cabinet/order_list.php');
        return true;
    }

}
