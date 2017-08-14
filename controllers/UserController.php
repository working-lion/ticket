<?php

/**
 * Контроллер AdminEventController
 * Управление данными пользователя
 */

class UserController
{
    /**
    * Action для регистрации пользователя
    * @return boolean
    */
    public function actionRegister()
    {
        $name = '';
        $email = '';
        $password = '';
        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            if (!Helper::checkName($name) || !Helper::checkEmpty($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }

            if (!Helper::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }

            if (!Helper::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if (Helper::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }

            if ($errors == false) {
                $result = User::register($name, $email, $password);
            }

        }

        require_once(ROOT . '/views/user/register.php');
        return true;
    }

    /**
    * Action для авторизации пользователя
    * @return boolean
    */
    public function actionLogin()
    {
        $email = '';
        $password = '';

        if (isset($_POST['user_login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            // Валидация полей
            if (!Helper::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!Helper::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            // Проверяем существует ли пользователь
            $userId = Helper::checkUserData($email, $password);

            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
            }
            else {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);

                // Перенаправляем пользователя в закрытую часть - кабинет
                header("Location: /cabinet/");
            }


        }

        require_once(ROOT . '/views/user/login.php');
        return true;
    }

    /**
    * Action для выхода пользователя из аккаунта
    * @return boolean
    */
    public function actionLogout()
    {
        //echo '<p>actionLogout</p>';
        //session_start();
        unset($_SESSION["user"]);
        //echo '<p>Дошли до редиректа</p>';
        //header("Location: /site/home", true, 307);
        header("Location: /", true, 307);
        return true;
    }
}
