<?php
/**
 * @author chengtao<751753158@qq.com>
 */

namespace d1studio\php_queue;
/**
 * 队列消息
 * @package d1studio\php_queue
 */
class Message{
    /**
     * 消息内容
     * @var null
     */
    private $data = null;
    /**
     * Message constructor.
     * @param string $data 消息数据
     */
    public function __construct($data){
        $this->data = $data;
    }
    /**
     * @return string
     */
    public function getData(){
        return $this->data;
    }
}