<?php

/**
 * Модель для работы с заказами
 */

class Order
{
    /**
    * Метод для получения данных о заказе
    * @param integer id - id заказа
    * @return array - массив данных о заказе
    */
    public static function getOrderItemByID($id)
    {
        $id = intval($id);
        if ($id) {
            $db = Db::getConnection();
            $result = $db->query('SELECT * FROM user_order WHERE id=' . $id);
            /*$result->setFetchMode(PDO::FETCH_NUM);*/
            //оставляем в массиве только буквенные индексы
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $orderItem = $result->fetch();
            return $orderItem;
        }
    }

    /**
    * Метод для получения списка заказов
    * @return array - массив данных о заказах
    */
    public static function getOrderList() {
        $db = Db::getConnection();
        $orderList = array();
        $sql = 'SELECT id, user_email, event_id, date, status FROM user_order ORDER BY date ASC';
        $result = $db->prepare($sql);
        $result->execute();
        $i = 0;//индекс строки
        while($row = $result->fetch()) {
            $orderList[$i]['id'] = $row['id'];
            $orderList[$i]['userEmail'] = $row['user_email'];
            $orderList[$i]['eventId'] = $row['event_id'];
            $orderList[$i]['date'] = $row['date'];
            $orderList[$i]['status'] = $row['status'];
            $i++;
        }
        return $orderList;
    }

    /**
    * Метод для получения данных о неоплаченных заказах
    * @param integer status - статус заказа (0/1)
    * @return array - массив данных о заказах
    */
    public static function getOrderListForCheck($status) {
        $db = Db::getConnection();
        $orderList = array();
        $sql = 'SELECT id, user_email, event_id, date, status FROM'
                . ' user_order WHERE status = :status ORDER BY date ASC';
        $result = $db->prepare($sql);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->execute();
        $i = 0;//индекс строки
        while($row = $result->fetch()) {
            $orderList[$i]['id'] = $row['id'];
            $orderList[$i]['userEmail'] = $row['user_email'];
            $orderList[$i]['eventId'] = $row['event_id'];
            $orderList[$i]['date'] = $row['date'];
            $orderList[$i]['status'] = $row['status'];
            $i++;
        }
        return $orderList;
    }

    /**
    * Метод для получения списка заказов по адресу электронки
    * @param string userEmail - email пользователя
    * @return array - массив данных о заказах данного пользователя
    */
    public static function getOrderListByUserEmail($userEmail) {
        $db = Db::getConnection();
        $orderList = array();
        $sql = 'SELECT id, user_email, event_id, date, status '
                . 'FROM user_order WHERE user_email = :userEmail ORDER BY date ASC';

        $result = $db->prepare($sql);
        $result->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
        $result->execute();

        $i = 0;//индекс строки
        while($row = $result->fetch()) {
            $orderList[$i]['id'] = $row['id'];
            $orderList[$i]['userEmail'] = $row['user_email'];
            $orderList[$i]['eventId'] = $row['event_id'];
            $orderList[$i]['date'] = $row['date'];
            $orderList[$i]['status'] = $row['status'];
            $i++;
        }
        return $orderList;
    }

    /**
    * Метод для получения списка заказов по id концерта
    * @param integer eventId - id концерта
    * @return array - массив данных о заказах данного пользователя
    */
    public static function getOrderListByEventId($eventId) {
        $db = Db::getConnection();
        $orderList = array();
        $sql = 'SELECT id, user_email, event_id, date, status '
                . 'FROM user_order WHERE event_id = :eventId ORDER BY date ASC';

        $result = $db->prepare($sql);
        $result->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $result->execute();

        $i = 0;//индекс строки
        while($row = $result->fetch()) {
            $orderList[$i]['id'] = $row['id'];
            $orderList[$i]['userEmail'] = $row['user_email'];
            $orderList[$i]['eventId'] = $row['event_id'];
            $orderList[$i]['date'] = $row['date'];
            $orderList[$i]['status'] = $row['status'];
            $i++;
        }
        return $orderList;
    }

    /**
     * Метод для создания заказа
     * @param string userEmail - email пользователя
     * @param integer eventId - id концерта
     * @return mixed: integet orderId or boolean
     */
    public static function create($userEmail, $eventId)
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO user_order (user_email, event_id)
            VALUES (:userEmail, :eventId)";

        $result = $db->prepare($sql);

        $result->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
        $result->bindParam(':eventId', $eventId, PDO::PARAM_INT);

        if($result->execute()){
            //определяем индекс только что добавленного заказа
            $orderId = $db->lastInsertId();
            return $orderId;
        }
        return false;
    }


    /**
     * Метод для обновления статуса заказа
     * @param integer orderId - id заказа
     * @param integer status - статус заказа
     * @return boolean
     */
    public static function update($orderId, $status)
    {
        $db = Db::getConnection();

        $sql = "UPDATE user_order
            SET
            status = :status
            WHERE id = :orderId";

        $result = $db->prepare($sql);

        $result->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);

        if($result->execute()){
            return true;
        }
        return false;
    }

    /**
     * Метод для удаления заказа
     * @param integer orderId - id заказа
     * @return boolean
     */
    public static function deleteOrderById($orderId)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'DELETE FROM user_order WHERE id = :orderId';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
      * Метод для проверки заказыв со статусом "в обработке" и
      * если со времени заказа прошло более часа, то удаляет этот заказ
      * @return boolean
      */
    public static function checkOrderList (){
        //список заказов
        $status = 0; // "в обработке"
        $orderList = self::getOrderListForCheck($status);

        //текущее время
        $currentDateTime = new DateTime('now');

        $diffDateTime = new DateTime();

        foreach ($orderList as $order){
            $orderDateTimeObj = new DateTime($order["date"]);
            //смотрим назцицу
            $diffDateTime = $orderDateTimeObj->diff($currentDateTime);
            //если заказ не оплачен в течение часа, удаляем его
            if($diffDateTime->y >= 1 || $diffDateTime->m >= 1 ||
                    $diffDateTime->d >= 1 || $diffDateTime->h >= 1){

                self::deleteOrderById($order['id']);

                //удаляем билеты из этого заказа
                Ticket::deleteTicketsByOrderId($order['id']);
                //echo '<p>Удаляем заказ № '.$order['id'].' </p>';
            }
        }
        return true;
    }
}
