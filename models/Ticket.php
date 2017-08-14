<?php

class Ticket {
    /**
     * Возвращает список билетов по id концерка
     */
    public static function getTicketList($eventId) {
        $db = Db::getConnection();
        
        $ticketList = array();
        //считываем данные о билетах
        $sql = 'SELECT id, price_id, row, place FROM ticket WHERE event_id = :eventId';
        
        $result = $db->prepare($sql);
        $result->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $result->execute();
        
        $i = 0; //индекс строки
        while ($row = $result->fetch()) {
            $ticketList[$i]['id'] = $row['id'];
            $ticketList[$i]['price_id'] = $row['price_id'];
            $ticketList[$i]['row'] = $row['row'];
            $ticketList[$i]['place'] = $row['place'];
            $i++;
        }
        
        //добавляем цену для каждого билета
        
        $ticketList = self::addTicketPrice($ticketList, $eventId);
        
        return $ticketList;
    }
    
    /**
     * Возвращает массив с информацией о купленных билетах
     * если билет куплен, то Mas[row][place] = 1
     * @param type $ticketList - массив билетов
     */
    
    public static function createBothTicketsArray($ticketList){
        $boughtTickets = array();
        foreach ($ticketList as $ticket) {
            $boughtTickets[$ticket["row"]][$ticket["place"]] = 1;
        }
        return $boughtTickets;
    }
    
    /**
     * Преобразует массив мест билетов в двумерный массив
     * row_place => [row][place]
     */
    public static function getSplitedTicketList($checkedTicketList) {
        $splitedTicketList = array();
        $i = 0;
        foreach ($checkedTicketList as $ticket){
            $segments = explode('_', $checkedTicketList[$i]);
            //извлекаем ряд
            $splitedTicketList[$i]["row"] = array_shift($segments);
            //извлекаем место
            $splitedTicketList[$i]["place"] = array_shift($segments);
            $i++;
        }
        return $splitedTicketList;
    }
    
    /**
     * Добавляем цены на билеты
     */
    public static function addTicketPrice($ticketList, $eventId) {
        //получаем список цен
        $priceList = Price::getPricesByEventId($eventId);
        //добавляем соответствующие цены каждому билету
        $i = 0;
        foreach ($ticketList as $ticket){
            //перебираем цены
            foreach ($priceList as $price){
                if($ticket["row"] >= $price["rowStart"] && $ticket["row"] <= $price["rowEnd"]){
                    $ticketList[$i]["price"] = $price["price"];
                    $ticketList[$i]["price_id"] = $price["id"];
                    break;
                }
            }
            $i++;
        }
        return $ticketList;
    }
    
    /**
     * Добавление билета
     */
    public static function create($price_id, $row, $place, $event_id, $order_id)
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO ticket (price_id, row, place, event_id, order_id)
            VALUES (:price_id, :row, :place, :event_id, :order_id)";
        
        $result = $db->prepare($sql);
               
        $result->bindParam(':price_id', $price_id, PDO::PARAM_INT);    
        $result->bindParam(':row', $row, PDO::PARAM_STR);
        $result->bindParam(':place', $place, PDO::PARAM_STR);
        $result->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $result->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        
        return $result->execute();
    }
    
    /**
     * Добавление билетов из массива
     */
    
    public static function writeTicketArray($ticketList, $eventId, $orderId){
        
        foreach ($ticketList as $ticket){
            self::create($ticket["price_id"], $ticket["row"], $ticket["place"], $eventId, $orderId);
        }
    }
    /**
     * Удаление белетов по id заказа
     */
    public static function deleteTicketsByOrderId($orderId)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'DELETE FROM ticket WHERE order_id = :orderId';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        return $result->execute();
    }
    
    
}

