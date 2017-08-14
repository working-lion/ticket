<?php

//подключаем файл модели концерта
//include_once ROOT . '/models/Event.php';
//модель подключения к БД
//include_once ROOT . '/components/Db.php';

class AdminController extends AdminBase
{
    /**
     * Action для стартовой страницы "Панель администратора"
     * @return boolean
     */
    public function actionIndex()
    {
        // Проверка доступа
        self::checkAdmin();

        // Подключаем вид
        require_once(ROOT . '/views/admin/index.php');
        return true;
    }

}
