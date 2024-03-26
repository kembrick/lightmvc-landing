<?php

const ADMIN_DIR = 'admin';

return [

    ADMIN_DIR => [
        'controller' => 'admin',
        'action' => 'index',
        'restricted' => true,
    ],

    ADMIN_DIR . '/view/{table:[\w\-_]+}' => [
        'controller' => 'admin',
        'action' => 'view',
        'restricted' => true,
    ],

    ADMIN_DIR . '/edit/{table:[\w\-_]+}/{id:[0-9]+}' => [
        'controller' => 'admin',
        'action' => 'edit',
        'restricted' => true,
    ],

    ADMIN_DIR . '/edit/{table:[\w\-_]+}' => [
        'controller' => 'admin',
        'action' => 'edit',
        'restricted' => true,
    ],

    ADMIN_DIR . '/deleterow/{table:[\w\-_]+}/{id:[0-9]+}/{mode:[0-9]+}' => [
        'controller' => 'admin',
        'action' => 'deleterow',
        'restricted' => true,
    ],

    ADMIN_DIR . '/login' => [
        'controller' => 'admin',
        'action' => 'login',
    ],

    ADMIN_DIR . '/logout' => [
        'controller' => 'admin',
        'action' => 'logout',
    ],

    /*
    // Создание нового пользователя админки
    ADMIN_DIR . '/newuser/{login:[\w\-_]+}/{password:[\w\-_]+}' => [
        'controller' => 'admin',
        'action' => 'newuser',
    ],
    */

    '' => [
        'controller' => 'landing',
        'action' => 'index',
    ],

];