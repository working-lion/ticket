<?php

/**
 * Контроллер EventController
 * Управление заказами
 */

class OrderController
{
    /**
    * Action для страницы подтверждения заказа
    * @return boolean
    */
    public function actionMakeOrder(){
        $errors = array();
        //смотрим, залогинен ли пользователь
        $email = '';

        if(!User::isGuest()){
            $email = User::getUserEmailById($_SESSION["user"]);
        }

        if(!empty($_POST["email"])){
            $email = $_POST["email"];
            //проверяем email
            if(!Helper::checkEmail($email)){
                $errors[] = 'Проверьте правильность введённого адреса электронной почты!';
            }
        }

        //принимаем данные o концерте
        $eventId = $_SESSION["eventId"];
        $eventItem = $_SESSION["eventItem"];

        //достаём массив с местами заказанных билетов
        $checkedTicketList = $_SESSION["checkedTicketList"];

        //формируем массив билетов
        $ticketList = Ticket::getSplitedTicketList($checkedTicketList);

        //добавляем цены
        $ticketList = Ticket::addTicketPrice($ticketList, $eventId);

        //получаем сумму заказа
        $summ_order = Price::calculatePriceSumm($ticketList);

        //усли заказ подтверждён и нет ошибок
        if(empty($errors) && !empty($_POST["make_order"])){
            //добавляем заказ
            $orderId = null;
            if($orderId = Order::create($email, $eventId)) {
                //записываем билеты
                Ticket::writeTicketArray($ticketList, $eventId, $orderId);
                header('Location: ../order/order_add/'.$orderId);
            }
            else {
                echo 'Заказ не добавлен!';
            }
        }

        //выводим форму заказа
        require_once(ROOT . '/views/order/make_order.php');
        return true;
    }

    /**
    * Action для страницы сообщения об удачном добавлении заказа
    * @return boolean
    */
    public function actionAddOrder($orderId){
        $order = Order::getOrderItemByID($orderId);
        //подключаем вид
        require_once(ROOT . '/views/order/order_added.php');
        return true;
    }
}
