<?php

/**
 * модель Event
 * Работы с концертами
 */

class Event {

    /**
    * Метод для получения данных о концерте
    * @param integer itemId - id концетра
    * @return array - данные о концерте
    */
    public static function getEventItemById($itemId) {
        $id = intval($itemId);
        if ($id) {
            $db = Db::getConnection();
            $result = $db->query('SELECT id, title, poster, date, time, room_id, announce  FROM event WHERE id = ' . $id);
            //оставляем в массиве только буквенные индексы в массиве
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $eventItem = $result->fetch();
            return $eventItem;
        }
    }

    /**
    * Метод для получения заголовка концерта
    * @param integer eventId - id концетра
    * @return string - заголовок концерта
    */
    public static function getEventTitle ($eventId) {
        $db = Db::getConnection();
        $eventTitle = '';
        //считываем данные о концерте
        $sql = 'SELECT title FROM event WHERE id = :eventId';

        $result = $db->prepare($sql);
        $result->bindParam(':eventId', $eventId, PDO::PARAM_STR);
        $result->execute();
        $row = $result->fetch();
        $eventTitle = $row["title"];
        return $eventTitle;
    }

    /**
    * Метод для получения списка концертов
    * @param integer limit
    * @return array - массив данных о концертах
    */
    public static function getEventList($limit) {
        if(empty($limit)){
           $limit = 100;
        }
        $db = Db::getConnection();
        $eventList = array();

        //считываем данные о концерте
        $result = $db->query('SELECT id, title, poster, date, time, room_id, announce  FROM event ORDER BY date ASC LIMIT ' . $limit);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0; //индекс строки
        while ($row = $result->fetch()) {
            $eventList[$i]['id'] = $row['id'];
            $eventList[$i]['title'] = $row['title'];
            $eventList[$i]['poster'] = $row['poster'];
            $eventList[$i]['date'] = $row['date'];
            $eventList[$i]['time'] = $row['time'];
            $eventList[$i]['announce'] = $row['announce'];
            $eventList[$i]['roomId'] = $row['room_id'];
            $i++;
        }
        $event_count = $i;//количество записей в массиве eventList

        //считываем цены для каждого концерта
        for ($i = 0; $i < $event_count; $i++){
            $priceArray = Array();//массив данных о ценах
            $priceArray = Price::getPricesByEventId($eventList[$i]["id"]);
            //добавляем массив цен в массив концертов
            $eventList[$i]['prices'] = $priceArray;
        }

        return $eventList;
    }

    /**
    * Метод для получения списка концертов по идентификатору зала
    * @param integer roomId - id зала
    * @return array - массив данных о концертах
    */
    public static function getEventListByRoomId($roomId) {
        $db = Db::getConnection();
        $eventList = array();
        //считываем данные о концерте
        $result = $db->query('SELECT id, title, poster, date, time, room_id, announce  FROM event WHERE room_id = ' . $roomId);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0; //индекс строки
        while ($row = $result->fetch()) {
            $eventList[$i]['id'] = $row['id'];
            $eventList[$i]['title'] = $row['title'];
            $eventList[$i]['poster'] = $row['poster'];
            $eventList[$i]['date'] = $row['date'];
            $eventList[$i]['time'] = $row['time'];
            $eventList[$i]['announce'] = $row['announce'];
            $eventList[$i]['roomId'] = $row['room_id'];
            $i++;
        }
        $event_count = $i;//количество записей в массиве eventList

        //считываем цены для каждого концерта
        for ($i = 0; $i < $event_count; $i++){
            $priceArray = Array();//массив данных о ценах
            $priceArray = Price::getPricesByEventId($eventList[$i]["id"]);
            //добавляем массив цен в массив концертов
            $eventList[$i]['prices'] = $priceArray;
        }

        return $eventList;
    }

    /**
    * Метод для изменения концерта
    * @param integer id - id концерта
    * @param string title - заголовок
    * @param string poster - афиша (имя файла постера)
    * @param string date - дата
    * @param string time - время
    * @param text announce - описание
    * @param integer roomId - id зала
    * @return array - массив данных о концертах
    */
    public static function edit($id, $title, $poster, $date, $time, $announce, $roomId)
    {
        $db = Db::getConnection();

        $sql = "UPDATE event
            SET
            title = :title,
            poster = :poster,
            date = :date,
            time = :time,
            room_id = :room_id,
            announce = :announce
            WHERE id = :id";

        $result = $db->prepare($sql);

        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':poster', $poster, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':time', $time, PDO::PARAM_STR);
        $result->bindParam(':room_id', $roomId, PDO::PARAM_INT);
        $result->bindParam(':announce', $announce, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Метод для создания концерта
     * @param string title - заголовок
     * @param string poster - афиша (имя файла постера)
     * @param string date - дата
     * @param string time - время
     * @param text announce - описание
     * @param integer roomId - id зала
     * @return integer - id концерта при успешном добавлении
     */
    public static function create($title, $poster, $date, $time, $announce, $roomId)
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO event (title, poster, date, time, announce, room_id)
            VALUES (:title, :poster, :date, :time, :announce, :roomId)";

        $result = $db->prepare($sql);

        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':poster', $poster, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':time', $time, PDO::PARAM_STR);
        $result->bindParam(':announce', $announce, PDO::PARAM_STR);
        $result->bindParam(':roomId', $roomId, PDO::PARAM_INT);

        if($result->execute()){
            //определяем индекс только что добавленного заказа
            $eventId = $db->lastInsertId();
            return $eventId;
        }
        return false;
    }

    /**
     * Метод для даления концерта
     * @param integer eventId - id концерта
     * @return boolean
     */
    public static function deleteEventById($eventId)
    {
        // Соединение с БД
        $db = Db::getConnection();
        //удаляем данные о концерте из таблицы event
        // Текст запроса к БД
        $sql = 'DELETE FROM event WHERE id = :eventId';
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':eventId', $eventId, PDO::PARAM_INT);

        //удадяем ценовые зоны
        Price::deleteEventPriceByEventId($eventId);

        return $result->execute();
    }

}
