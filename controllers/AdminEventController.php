<?php

/**
 * Контроллер AdminEventController
 * Управление концертами в админпанели
 */

class AdminEventController extends AdminBase {

    /**
    * Action для страницы "Управление концертами"
    * @return boolean
    */
    public function actionIndex()
    {
        // Проверка доступа
        self::checkAdmin();

        // Получаем список концертов
        $eventList = Event::getEventList(100);

        //получаем цены для каждого концерта
        $i = 0;
        foreach ($eventList as $event){
            $priceList[] = Price::getPricesByEventId($event["id"]);
            $i++;
        }

        // Подключаем вид
        require_once(ROOT . '/views/admin_event/index.php');
        return true;
    }

    /**
    * Action для обновления концерта
    * @param integer eventId - id концерта
    * @return boolean
    */
    public function actionUpdate($eventId)
    {
        // Проверка доступа
        self::checkAdmin();

        //получаем данные о концерте
        $eventItem = Event::getEventItemById($eventId);

        //получаем данные о залах
        $roomList = Room::getRoomList();

        //получаем цены
        $priceList = Price::getPricesByEventId($eventId);

        $eventId = $eventItem["id"];
        $poster = $eventItem["poster"];
        $title = $eventItem["title"];
        $date = $eventItem["date"];
        $time = $eventItem["time"];
        $roomId = $eventItem["room_id"];
        $announce = $eventItem["announce"];

        $result = false;
        $errors = false;

        //если форма отправлена
        if (isset($_POST['event_update'])) {

            $title = $_POST["title"];
            $priceList[0]["price"] = $_POST["price1"];
            $priceList[1]["price"] = $_POST["price2"];
            $priceList[2]["price"] = $_POST["price3"];
            $date = $_POST["date"];
            $time = $_POST["time"];
            $announce = $_POST["announce"];
            $room_id = $_POST["roomId"];

            //добавить проверку на загрузку файда постера

            if(!Helper::checkEmpty($title)) {
                $errors[] = 'Заполните поле заголовка.';
            }

            if(!Helper::checkEmpty($poster)) {
                $errors[] = 'Загрузите файл постера.';
            }

            if(!Helper::checkEmpty($announce)) {
                $errors[] = 'Заполните поле анонаса.';
            }

            if(!Helper::checkDateTime($date, $time)){
                $errors[] = 'Проверьте правильность даты и времени.
                Нельзя довавить прошедшую дату.';
            }

            //проверяем, нет ли в базе концерта в то же время и в том же зале
            if(!Helper::checkSameDateTimeRoom($date, $time, $roomId, $eventId)){
                $errors[] = 'Проверьте правильность даты и времени.
                Концерт с введённой датой уже добавлен.';
            }

            $currentPrice = 0;
            foreach ($priceList as $price){
                if(!Helper::checkEmpty($price["price"])){
                    $errors[] = 'Проверьте правильность цены №' . $currentPrice
                    . '.';
                }
                $currentPrice++;
            }

            if(empty($errors)){

                if(!empty($_FILES['poster']['tmp_name'])){

                    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/template/images/';
                    $originalFileName = basename($_FILES['poster']['name']);

                    $uploadFile = $uploadDir . $originalFileName;

                    $poster = $_FILES['poster']['tmp_name'];

                    if (!move_uploaded_file($poster, $uploadFile)) {
                        $errors[] = 'Файл постера не был загружен.';
                    }
                    $poster = $originalFileName;
                }
            }

            if ($errors == false) {
                $result = Event::edit($eventId, $title, $poster, $date, $time, $announce, $room_id);

                //формируем массив цен
                $priceList[0]["rowStart"] = 1;
                $priceList[0]["rowEnd"] = 5;
                $priceList[1]["rowStart"] = 6;
                $priceList[1]["rowEnd"] = 10;
                $priceList[2]["rowStart"] = 11;
                $priceList[2]["rowEnd"] = 15;

                //записываем цены в БД
                Price::updateEventPriceZones($eventId, $priceList);
            }

        }
        // Подключаем вид
        require_once(ROOT . '/views/admin_event/update.php');
        return true;
    }

    /**
    * Action для создания концерта концерта
    * @return boolean
    */
    public function actionCreate()
    {
        // Проверка доступа
        self::checkAdmin();

        $roomList = Room::getRoomList();

        $poster = null;
        $title = null;
        $priceList = null;
        $date = null;
        $time = null;
        $roomId = null;
        $announce = null;
        $result = false;
        $errors = false;

        if (isset($_POST['event_create'])) {
            //имя файла
            $poster = $_FILES['poster']['tmp_name'];
            $title = $_POST["title"];
            $priceList[0]["price"] = $_POST["price1"];
            $priceList[1]["price"] = $_POST["price2"];
            $priceList[2]["price"] = $_POST["price3"];
            $date = $_POST["date"];
            $time = $_POST["time"];
            $roomId = $_POST["roomId"];
            $announce = $_POST["announce"];

            if(!Helper::checkEmpty($title)) {
                $errors[] = 'Заполните поле заголовка.';
            }

            if(!Helper::checkEmpty($poster)) {
                $errors[] = 'Загрузите файл постера.';
            }

            if(!Helper::checkEmpty($announce)) {
                $errors[] = 'Заполните поле анонаса.';
            }

            if(!Helper::checkDateTime($date, $time)){
                $errors[] = 'Проверьте правильность даты и времени.
                Нельзя довавить прошедшую дату.';
            }

            //проверяем, нет ли в базе концерта в то же время и в том же зале
            if(!empty($eventId)){
                if(!Helper::checkSameDateTimeRoom($date, $time, $roomId, $eventId)){
                    $errors[] = 'Проверьте правильность даты и времени.
                    Концерт с введённой датой уже добавлен.';
                }
            }

            $currentPrice = 0;
            foreach ($priceList as $price){
                if(!Helper::checkEmpty($price["price"])){
                    $errors[] = 'Проверьте правильность цены №' . $currentPrice
                    . '.';
                }
                $currentPrice++;
            }

            if(empty($errors)){

                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/template/images/';
                $originalFileName = basename($_FILES['poster']['name']);
                $uploadFile = $uploadDir . $originalFileName;

                if (!move_uploaded_file($poster, $uploadFile)) {
                    $errors[] = 'Файл постера не был загружен.';
                }
            }

            if (empty($errors)) {
                //создаём концерт
                $result = Event::create( $title, $originalFileName, $date, $time, $announce, $roomId);

                //формируем массив цен
                $priceList[0]["rowStart"] = 1;
                $priceList[0]["rowEnd"] = 5;
                $priceList[1]["rowStart"] = 6;
                $priceList[1]["rowEnd"] = 10;
                $priceList[2]["rowStart"] = 11;
                $priceList[2]["rowEnd"] = 15;

                //id концерта
                $eventId = $result;

                if($eventId) {
                    //записываем цены в БД
                    Price::createEventPriceZones($eventId, $priceList);
                }
            }


        }
        // Подключаем вид
        require_once(ROOT . '/views/admin_event/create.php');
        return true;
    }


    /**
    * Action для удаления концерта концерта
    * @param integer eventId - id концерта
    * @return boolean
    */
    public function actionDelete($eventId)
    {
        // Проверка доступа
        self::checkAdmin();
        // Обработка формы
        if (isset($_POST['event_delete'])) {
            // Удаляем концерт
            $result = Event::deleteEventById($eventId);

            // Перенаправляем пользователя на страницу управлениями концертами
            header("Location: /admin/event");
        }

        // Подключаем вид
        require_once(ROOT . '/views/admin_event/delete.php');
        return true;
    }
}
