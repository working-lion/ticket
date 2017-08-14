<?php

/**
 * Контроллер SiteController
 * Вывод домашней страницы и странциы 404
 */

class SiteController {

    /**
    * Action для вывода домашней страницы
    * @return boolean
    */
    public function actionIndex(){
        require_once(ROOT . '/template/index.php');
	    return true;
    }

    /**
    * Action для вывода страницы 404
    * @return boolean
    */
    public static function action404(){
        require_once(ROOT . '/template/404.php');
    	return true;
    }
}
