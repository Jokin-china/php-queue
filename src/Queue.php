<?php
/**
 * @author chengtao<751753158@qq.com>
 */

namespace d1studio\php_queue;

use d1studio\php_queue\drives\MysqlQueue;

/**
 * 队列接口
 * Interface TaskInterface
 * @package d1studio\php_queue;
 */
class Queue {

    /**
     * @param string $queue_name 队列名称
     * @param array  $config     配置文件
     * [
     *     'drive_name' => 'Mysql',
     *     'options'    => [
     *        'host' ..
     *     ]
     * ]
     * @return QueueInterface
     */
    public static function getQueue($queue_name ,$config){
        $queue = new MysqlQueue($queue_name,$config['option']);
        return $queue;
    }

}