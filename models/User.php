<?php

class User
{

    /**
     * Регистрация пользователя
     * @param type $name
     * @param type $email
     * @param type $password
     * @return type
     */
    public static function register($name, $email, $password)
    {

        $db = Db::getConnection();

        $sql = 'INSERT INTO user (name, email, password) '
                . 'VALUES (:name, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Редактирование данных пользователя
     * @param string $name
     * @param string $password
     */
    public static function edit($id, $name, $password)
    {
        $db = Db::getConnection();

        $sql = "UPDATE user
            SET name = :name, password = :password
            WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Запоминаем пользователя
     * @param string $email
     * @param string $password
     */
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    /**
     * Проверка на авторизацию
     * @return boolean
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    public static function isAdmin(){
        if(!self::isGuest()){
            $userId = $_SESSION['user'];

            $db = Db::getConnection();
            $sql = 'SELECT role FROM user WHERE id = :userId';

            $result = $db->prepare($sql);
            $result->bindParam(':userId', $userId, PDO::PARAM_INT);
            $result->execute();
            $row = $result->fetch();
            $role = $row["role"];
            if(strcmp($role, 'admin') == 0){
                return true;
            }
        }
        return false;
    }

    /**
     * Returns user by id
     * @param integer $id
     */
    public static function getUserById($id)
    {
        if ($id) {
            $db = Db::getConnection();
            $sql = 'SELECT * FROM user WHERE id = :id';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            // Указываем, что хотим получить данные в виде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();


            return $result->fetch();
        }
    }

    /**
     * Возвращает email пользователь
     * @param integer $id
     */
    public static function getUserEmailById($id)
    {
        if ($id) {
            $db = Db::getConnection();
            $sql = 'SELECT email FROM user WHERE id = :id';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            // Указываем, что хотим получить данные в виде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            $row = $result->fetch();
            $email = $row["email"];

            return $email;
        }
    }

}
