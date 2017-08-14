<?php
return array(
    /*управление заказами*/
    'admin/order/view/([0-9]+)' => 'adminOrder/viewUpdatedOrder/$1',//просмотр заказа после обновления
    'admin/order/update/([0-9]+)' => 'adminOrder/update/$1',//обновление заказа
    'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1',//удалить заказ
    'admin/order' => 'adminOrder/index', //список заказов

    /*управление концертами*/
    'admin/event/create' => 'adminEvent/create',//создать концерт
    'admin/event/update/([0-9]+)' => 'adminEvent/update/$1',//редактировать концерт
    'admin/event/delete/([0-9]+)' => 'adminEvent/delete/$1',//удалить концерт
    'admin/event' => 'adminEvent/index',//список концертов

    /*панель администратора*/
    'admin' => 'admin/index',//стартовая страница панели администратора

    /*страницы пользователя*/
    'user/register' => 'user/register', // регистрация
    'user/login' => 'user/login', // вход
    'user/logout' => 'user/logout',// выход

    /*кабинет пользователя*/
    'cabinet/list' => 'cabinet/orderList',//список заказов
    'cabinet/edit' => 'cabinet/edit',//страница редактирования данных пльзователя
    //'cabinet/history' => 'cabinet/history',//список заказов
    'cabinet' => 'cabinet/index', // кабинет пользователя

    /*конецерты*/
    'event/([0-9]+)' => 'event/id/$1', // actionId in NewsController
    'event' => 'event/list', // actionIndex in NewsController

    /*заказы*/
    'order/order_add/([0-9]+)' => 'order/addOrder/$1', //оформление заказа
    'order/make_order' => 'order/makeOrder', //оформление заказа
    'order/([0-9]+)' => 'order/id/$1', // actionId in NewsController
    
    /*главная*/
    '' => 'site/index'//домашняя страница
);
