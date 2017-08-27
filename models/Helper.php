<?php

/**
 * модель Helper
 * содержит методы для проверки вводимых пользователей данных,
 * для определения формата данных при выводе
 */


class Helper{

    /**
    * Метод для проверки даты и времени при добавлении концерта
    * возвращает ture, если $userData > текущая дата
    * иначе - false
    * @param string userDate - дата (gggg-mm-dd)
    * @param string userTime - время (hh:mm:ss)
    * @return boolean
    */
    public static function checkDateTime($userDate, $userTime){
        //получаем строку с датой и временем
        $userDataTimeStr = $userDate . ' ' . $userTime;
        //преобразуем строку с датой и временем в формат UTC
        $userDataTime = strtotime($userDataTimeStr);
        //получаем текущее значение времени
        //$currentDataTime = date();
        $currentDataTime = strtotime("now");
        if($userDataTime < $currentDataTime)
            return false;
        return true;
    }

    /**
     * Метод проверяет дату, время, чтобы в одно время в одном зале
     * не было двух концертов
     * возвращает true при положительном результате проверки
     * иначе - false
     * @param string userDate - дата (gggg-mm-dd)
     * @param string userTime - время (hh:mm:ss)
     * @return boolean
     */
    public static function checkSameDateTimeRoom($userDate, $userTime, $userRoomId, $eventId){
        //получаем список концертов в выбранном зале
        $eventList = Event::getEventListByRoomId($userRoomId);

        //получаем строку с датой и временем
        $userDataTimeStr = $userDate . ' ' . $userTime;
        //преобразуем строку с датой и временем в формат UTC
        $userDataTime = strtotime($userDataTimeStr);

        foreach ($eventList as $event) {
            $eventDataTimeStr = $event["date"] . ' ' . $event["time"];
            $eventDataTime = strtotime($eventDataTimeStr);
            if($userDataTime == $eventDataTime && $event["id"] != $eventId)
                return false;
        }

        return true;

    }

    /**
     * Метод проверяет, является ли  вводимое поле пустым (с учётом пробелов)
     * @param string data - строка для проверки
     * @return boolean
     */
    public static function checkEmpty($data){
        if(trim($data)){
            return true;
        }
        return false;
    }

    /**
     * Метод проверяет email
     * @param string email
     * @return boolean
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Метод проверяет, есть ли пользователь с таким же адресом
     * @param string email
     * @return boolean
     */
    public static function checkEmailExists($email)
    {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * Метод проверяет длину пароля: не меньше, чем 6 символов
     * @param string password - пароль
     * @return boolean
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * Метод проверяет, залогинен ли пользователь
     * @return string
     */
        public static function checkLogged()
    {
        // Если сессия есть, вернем идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    /**
     * Метод проверяем существует ли пользователь с заданными $email и $password
     * @param string email
     * @param string password
     * @return mixed : ingeger user id or false
     */
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();

        $user = $result->fetch();
        if ($user) {
            return $user['id'];
        }

        return false;
    }

    /**
     * Метод проверяет имя: не меньше, чем 2 символа
     * @param string name - имя
     * @return - boolean
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    /**
     * Метод возвращает дату в нужном формате для вывода
     * @param string date - дата (gggg-mm-dd)
     * @return string - дата в нужном формате
     */
    public static function formatDateForView($date)
    {
        $formatedDate = date('d.m.Y г.', strtotime($date));
        return $formatedDate;
    }

    /**
     * Метод возвращает дату и время в нужном формате для вывода
     * @param date - дата и время (gggg-mm-dd hh:mm:ss)
     * @return string - дата и время в нужном формате
     */
    public static function formatOrderDateForView($date)
    {
        $formatedDate = strftime('%k час. %M мин. %d.%m.%G г.', time($date));
        return $formatedDate;
    }

    /**
     * Метод возвращает время в нужном формате для вывода
     * @param string time - время (hh:mm:ss)
     * @return string - время в нужном формате
     */
    public static function formatTimeForView($time)
    {
        $segments = explode(':', $time);
        $h = array_shift($segments);
        $m = array_shift($segments);
        $formatedTime = $h . ' час. ' . $m . ' мин.';
        return $formatedTime;
    }
}
