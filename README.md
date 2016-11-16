# php-queue 


##1.说明
php-queue是一个对常用对列使用封装的库。

| 驱动      |     说明 |限制|
| :--------| --------|-------|
| MySQL    |   MySQL驱动 |消息个数最大支持42亿|
|Redis|Redis驱动|没有ack|
|Kafka|kafka驱动|暂无..|
<pre>
升级日志
   v-0.2.0
     1.添加retry机制(ttl)
     2.去掉medoo,使用pdo方式,防止内存泄漏
   v-0.1.0
     1.添加mysql驱动
</pre>

##2 安装以及使用
###2.1 安装
`composer require d1studio\php-queue `
###2.2 使用
<pre>
&lt?php
include __DIR__.'/vendor/autoload.php';
$mysql_queue = \d1studio\php_queue\Queue::getQueue('send_coupon',[
    'drive'  => 'Mysql',
    'option' => [
        'database_name' => 'queue',
        'server'        => '127.0.0.1',
        'username'      => 'root',
        'password'      => '123456',

    ],
]);
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
$mysql_queue->push("test",5);
$data = $mysql_queue->pop();
</pre>


