<?php

use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      =>  getenv('DB_HOST'),
    'port'      =>  getenv('DB_PORT'),
    'database'  =>  getenv('DB_NAME'),
    'username'  =>  getenv('DB_USER'),
    'password'  =>  getenv('DB_PASS'),
    'charset'   =>  'utf8',
    'collation' =>  'utf8_unicode_ci',
    'prefix'    =>  ''
]);

$capsule->setEventDispatcher(new Dispatcher());
$capsule->setAsGlobal();
$capsule->bootEloquent();
