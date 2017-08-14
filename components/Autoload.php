<?php
//файл подгрузки необходимых компонентов
function __autoload ($class_name){

    $folders = array(
        '/models/',
        '/components/',
        '/controllers/'
    );

    foreach ($folders as $folder){
        $path = ROOT . $folder . $class_name . '.php';
        if (is_file($path)){
            require_once $path;
        }
    }
}
