<?php
include __DIR__.'/../vendor/autoload.php';
$mysql_queue = \d1studio\php_queue\Queue::getQueue('send_coupon',[
    'drive'  => 'Mysql',
    'option' => [
        'database_name' => 'queue',
        'server'        => '127.0.0.1',
        'username'      => 'root',
        'password'      => '123456',

    ],
]);