<?php

class Db
{
    public static function getConnection(){
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        $host = $params['host'];
        $dbName = $params['dbname'];
        $user = $params['user'];
        $password = $params['password'];
        $dsn = 'mysql:dbname='.$dbName.';host='.$host;
        try {
            $db = new PDO($dsn, $user, $password);
            $db->query("SET NAMES utf8");
        }
        catch (PDOException $e) {
            //перейти на страницу сообщения
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        return $db;
    }
}
