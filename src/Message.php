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
     * @var null|string
     */
    private $data     = null;
    /**
     * 优先级
     * @var int
     */
    private $priority = 0;
    /**
     * 生命周期(retry 机制)
     * @var int
     */
    private $ttl      = 0;
    /**
     * Message constructor.
     * @param string $data 消息数据
     */
    public function __construct($data,$ttl = 0){
        $this->data = $data;
        $this->ttl  = $ttl;
    }
    /**
     * 设置ttl
     */
    public function getTtl(){
        return $this->ttl;
    }
    /**
     * @return string
     */
    public function getData(){
        return $this->data;
    }
}