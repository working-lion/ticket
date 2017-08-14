<?php

/**
 * Контроллер EventController
 * Управление концертами
 */

class EventController {

    /**
    * Action для страницы списка концертов
    * @return boolean
    */
    public function actionList() {
        $eventList = array();
        //формируем массив концертов из БД
        $eventList = Event::getEventList(100);
        //для каждого концерта получаем минимальную и максимальную цену
        //получаем доступные цены
        $i = 0;//индекс концерта
        foreach ($eventList as $event){
            $eventId = $event["id"];
            $minMaxPriceArray[$i] = Price::getAvailableMinMaxPrice($eventId);
            $price[$i] = false;
            $noTicketsAvailable[$i] = true;
            //если есть свободные места
            if($minMaxPriceArray[$i]) {
                $noTicketsAvailable[$i] = false;
                if(is_array($minMaxPriceArray[$i])){
                    $minPrice[$i] = $minMaxPriceArray[$i]["minPrice"];
                    $maxPrice[$i] = $minMaxPriceArray[$i]["maxPrice"];
                }
                else {
                    $price[$i] = $minMaxPriceArray[$i];
                }
            }
            $i++;
        }

        //вызоваем нужный файл вывода
        require_once(ROOT . '/views/event/index.php');
        return true;
    }

    /**
    * Action для страницы концерта
    * @param integer eventId - id концерта
    * @return boolean
    */
    public function actionId($eventId) {
        //получаем данные о концерте
        $eventItem = Event::getEventItemById($eventId);
        //получаем данные о купленных билетах
        $ticketList = Ticket::getTicketList($eventId);
        //получаем данные о ценах на билеты
        $priceList = Price::getPricesByEventId($eventId);
        //формирвем массив индексов купленных билетов
        $boughtTickets = Ticket::createBothTicketsArray($ticketList);
        //получаем количество рядов и количество мест в зале
        $roomSizeArray = Room::getRoomSize($eventItem["room_id"]);
        //получаем цены на концерт (с учётом купленных)
        $minMaxPriceArray = Price::getAvailableMinMaxPrice($eventId);
        $price = false;
        $noTicketsAvailable = true;
        //если есть свободные места
        if($minMaxPriceArray) {
            $noTicketsAvailable = false;
        }
        //проверяем была ли нажата кнопка "оформить заказ"
        $error = '';
        if(!empty($_POST["go_to_order"])){
            if(!empty($_POST["checkedTicketList"])){
                //сохраняем массив с отмеченными билетами
                $_SESSION["checkedTicketList"] = $_POST["checkedTicketList"];
                //сохраняем $eventId
                $_SESSION["eventId"] = $eventId;
                //сохраняем $eventItem
                $_SESSION["eventItem"] = $eventItem;
                header("Location: ../order/make_order");
            }
            else{
                $error = 'Выбирете билет!';
            }
        }

        //выводим страницу концерта
        require_once(ROOT . '/views/event/id.php');
        return true;
    }

    /**
    * Action для вывода списка концертов
    * @return boolean
    */
    public static function actionPrintList() {
        //получить список концертов из БД
        $eventList = array();
        $eventList = Event::getEventList(10);
        //получаем доступные цены
        $i = 0;//индекс концерта
        foreach ($eventList as $event){
            $eventId = $event["id"];
            $minMaxPriceArray[$i] = Price::getAvailableMinMaxPrice($eventId);
            $price[$i] = false;
            $noTicketsAvailable[$i] = true;
            //если есть свободные места
            if($minMaxPriceArray[$i]) {
                $noTicketsAvailable[$i] = false;
                if(is_array($minMaxPriceArray[$i])){
                    $minPrice[$i] = $minMaxPriceArray[$i]["minPrice"];
                    $maxPrice[$i] = $minMaxPriceArray[$i]["maxPrice"];
                }
                else {
                    $price[$i] = $minMaxPriceArray[$i];
                }
            }
            $i++;
        }

        //вызоваем нужный файл вывода
        include_once (ROOT . '/views/event/printList.php');
        return true;
    }

}
