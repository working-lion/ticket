<?php

/**
 * Модель для работы с ценовыми зонами
 */

class Price {

    /**
     * Метод для получения цен по id концерта
     * @param integer eventId - id концетра
     * @return mixed: array or boolean - массив цен или false
     */
    public static function getPricesByEventId($eventId) {
        if(!empty($eventId)){
            $db = Db::getConnection();
            $sql = 'SELECT id, row_start, row_end, price FROM price WHERE event_id = :eventId ORDER BY price DESC';
            $result = $db->prepare($sql);
            $result->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $result->execute();

            $priceList = array();
            //$result = $db->query('SELECT id, row_start, row_end, price FROM price_zone WHERE event_id = '.$eventId.' ORDER BY price ASC');
            //$result->setFetchMode(PDO::FETCH_ASSOC);
            $i = 0; //индекс строки
            while ($row = $result->fetch()) {
                $priceList[$i]['id'] = $row['id'];
                $priceList[$i]['rowStart'] = $row['row_start'];
                $priceList[$i]['rowEnd'] = $row['row_end'];
                $priceList[$i]['price'] = $row['price'];
                $i++;
            }
            
            return $priceList;
        }
        return false;
    }

    /**
     * Метод для получения цен по id концерта
     * @param integer priceZoneId - id ценовой зоны
     * @param integer rowStart - номер ряда (начала ценовой зоны)
     * @param integer rowEnd - номер рада (конца ценовой зоны)
     * @param integer price - цена
     * @param integer eventId - id концетра
     * @return mixed: array or boolean - массив цен или false
     */
    public static function editPriceZone($priceZoneId, $rowStart, $rowEnd, $price, $eventId){

        $db = Db::getConnection();

        $sql = "UPDATE price
            SET
            row_start = :rowStart,
            row_end = :rowEnd,
            price = :price,
            event_id = :eventId
            WHERE id = :priceZoneId";

        $result = $db->prepare($sql);

        $result->bindParam(':rowStart', $rowStart, PDO::PARAM_INT);
        $result->bindParam(':rowEnd', $rowEnd, PDO::PARAM_INT);
        $result->bindParam(':price', $price, PDO::PARAM_INT);
        $result->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $result->bindParam(':priceZoneId', $priceZoneId, PDO::PARAM_INT);

        return $result->execute();

    }


    /**
     * Метод для обновления ценовой зоны
     * @param integeh eventId - id концерта
     * @param array priceList - массив данных о ценовой зоне
     */
    public static function updateEventPriceZones($eventId, $priceList){
        $i = 0;
        foreach ($priceList as $price){
            self::editPriceZone($price["id"], $price["rowStart"], $price["rowEnd"], $price["price"], $eventId);
            $i++;
        }
    }

    /**
     * Метод для добавления ценовой зоны на концерт
     * @param integer rowStart - номер ряда (начала ценовой зоны)
     * @param integer rowEnd - номер рада (конца ценовой зоны)
     * @param integer price - цена
     * @param integer eventId - id концетра
     * @param boolean
     */
    public static function createPriceZone($rowStart, $rowEnd, $price, $eventId) {
        //создаём в таблице price запись с принятыми параметрами
        $db = Db::getConnection();

        $sql = "INSERT INTO price (row_start, row_end, price, event_id)
            VALUES (:rowStart, :rowEnd, :price, :eventId)";

        $result = $db->prepare($sql);

        $result->bindParam(':rowStart', $rowStart, PDO::PARAM_INT);
        $result->bindParam(':rowEnd', $rowEnd, PDO::PARAM_INT);
        $result->bindParam(':price', $price, PDO::PARAM_INT);
        $result->bindParam(':eventId', $eventId, PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Метод для добавления ценовых зон на концерт
     * @param integer eventId - id концетра
     * @param array priceList - массив данных о ценовых зонах
     * @return boolean
     */
    public static function createEventPriceZones($eventId, $priceList) {
        if(!empty($priceList)){
            foreach ($priceList as $price){
                self::createPriceZone($price["rowStart"], $price["rowEnd"], $price["price"], $eventId);
            }
            return true;
        }
        return false;
    }

    /**
     * Метод для удаления ценовых зон по id концерта
     * @param integer eventId - id концетра
     * @return boolean
     */

    public static function deleteEventPriceByEventId($eventId) {
        if(!empty($eventId)){
            //проверяем есть ли заказы на этот концерт
            if(empty(Order::getOrderListByEventId($eventId))){
                //удаляем цены
                // Соединение с БД
                $db = Db::getConnection();

                // Текст запроса к БД
                $sql = 'DELETE FROM price WHERE event_id = :eventId';

                // Получение и возврат результатов. Используется подготовленный запрос
                $result = $db->prepare($sql);
                $result->bindParam(':eventId', $eventId, PDO::PARAM_INT);

                return $result->execute();
            }
        }
        return false;
    }

    /**
     * Возвращает интервал доступных цен для концерта
     * принимает id концерта
     * возвращает строку: интервал доступных цен на концерт
     */
    public static function getPriceIntervalByEventId($eventId) {
        if(!empty($eventId)){
            /**
             * 1. считываем в массив цены по iventId
             * 2. считываем билеты на концерт
             * 3. исходя из доступных мест формируем интервал доступных цен
             */
            //удаляем все записи в таб. price, в кот. есть $eventId
            return true;
        }
        return false;
    }

    /**
     * Возвращает сумму цен заказанных билетов
     * принимает массив билетов
     */
    public static function calculatePriceSumm($ticketList){
        $summ = 0;
        $i = 0;
        foreach ($ticketList as $ticket){
            $summ += $ticket["price"];
            $i++;
        }
        return $summ;
    }
    /**
     * Возвращает массив с минимальной и максимальной ценой на концерт
     * с учётом купленных билетов
     * @param type $eventId
     */
    public static function getAvailableMinMaxPrice($eventId){
        //получаем данные о концерте
        $eventItem = Event::getEventItemById($eventId);

        //получаем цены на концерт
        $priceList = self::getPricesByEventId($eventId);

        //получаем купленные билеты
        $ticketList = Ticket::getTicketList($eventId);

        //получаем размеры зала

        $roomSize = Room::getRoomSize($eventItem["room_id"]);

        //для каждой цены проверяем, остались ли билеты
        $minPrice = false;
        $maxPrice = false;

        //формируем вспомагательный массив, в который:
        //записываем 1, если место куплено
        //замысываем 0, если место свободно

        $availablePlaces = array();
        foreach ($ticketList as $ticket){
            $availablePlaces[$ticket["row"]][$ticket["place"]] = 1;
        }

        $empty = false;
        //для каждой цены перебираем места
        foreach ($priceList as $price){
            for($i = $price["rowStart"]; $i < $price["rowEnd"]; $i++){
                for ($j = 1; $j < $roomSize["place_count"]; $j++) {
                    //если нет билета с такими рядом и местом
                    if(empty($availablePlaces[$i][$j])){
                        if(!$minPrice){
                            $minPrice = $price["price"];
                        }
                        if(!$maxPrice){
                            $maxPrice = $price["price"];
                        }
                        if($price["price"] < $minPrice){
                            $minPrice = $price["price"];
                        }
                        if($price["price"] > $maxPrice){
                            $maxPrice = $price["price"];
                        }
                        $empty = true;
                        break;
                    }
                    if($empty) break;
                }
            if($empty) break;
            }
            $empty = false;
        }

        if($minPrice == $maxPrice){
            return $minPrice;
        }
        else {
            $minMaxPriceArray = array();
            $minMaxPriceArray["minPrice"] = $minPrice;
            $minMaxPriceArray["maxPrice"] = $maxPrice;
            return $minMaxPriceArray;
        }
    }



}
