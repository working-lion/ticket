<?php

/**
 * Контроллер AdminOrderController
 * Управление заказами в админпанели
 */

class AdminOrderController extends AdminBase
{

    /**
     * Action для страницы "Управление заказами"
     * @return boolean
     */

    public function actionIndex()
    {
        // Проверка доступа
        self::checkAdmin();

        // Получаем список заказов
        $orderList = Order::getOrderList();

        // Подключаем вид
        require_once(ROOT . '/views/admin_order/index.php');
        return true;
    }

    /**
     * Action для страницы "Редактирование заказа"
     * @param integer orderId - id заказа
     * @return boolean
     */
    ublic function actionUpdate($orderId)
    {
        // Проверка доступа
        self::checkAdmin();

        // Получаем данные о конкретном заказе
        $order = Order::getOrderItemByID($orderId);

        $userEmail = $order['user_email'];
        $eventId = $order['event_id'];
        $date = $order['date'];
        $status = $order['status'];

        $result = false;
        $errors = false;

        // Обработка формы
        if (isset($_POST['update_order'])) {

            $status = $_POST['status'];
            // Сохраняем изменения
            $result = Order::update($orderId, $status);

            if($result){
                //перенаправление на страницу сообщения об успешном добавлении заказа
                header("Location: /admin/order/view/$orderId");
            }
            else {
                echo 'заказ не был изменён.';
            }

        }
        // Подключаем вид
        require_once(ROOT . '/views/admin_order/update.php');
        return true;
    }

    /**
     * Action для страницы "Просмотр заказа"
     * @param integer orderId - id заказа
     * @return boolean
     */
    public function actionViewUpdatedOrder($orderId)
    {
        // Проверка доступа
        self::checkAdmin();

        // Получаем данные о конкретном заказе
        $order = Order::getOrderItemByID($orderId);

        $orderId = $order["id"];

        // Подключаем вид
        require_once(ROOT . '/views/admin_order/order_updated.php');
        return true;
    }

    /**
     * Action для страницы "Удалить заказ"
     * @param integer orderId - id заказа
     * @return boolean
     */
    public function actionDelete($orderId)
    {
        // Проверка доступа
        self::checkAdmin();

        // Если форма отправлена
        if (isset($_POST['order_delete'])) {
            // Удаляем заказ
            Order::deleteOrderById($orderId);

            //удаляем билеты из этого заказа

            Ticket::deleteTicketsByOrderId($orderId);

            // Перенаправляем пользователя на страницу управлениями товарами
            header("Location: /admin/order");
        }
        // Подключаем вид
        require_once(ROOT . '/views/admin_order/delete.php');
        return true;
    }

}
