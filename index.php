<?php

// FRONT CONTROLLER

// Общие настройки
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();

// Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Autoload.php');

// Подключаем картинки и файлы стилей 
$_SESSION["img_path"] = '/template/images/';
$_SESSION["css_path"] = '/template/css/';



// Вызов Router
$router = new Router();
$router->run();



