<?php
/**
 * @author chengtao<751753158@qq.com>
 */
namespace d1studio\php_queue\drives;

use d1studio\php_queue\Message;

/**
 * 队列驱动-MySQL
 *
 * 说明 :
 * 1 mysql 驱动使用了mysql的自增ID作为消息存储的唯一标示,因此依赖mysql数据表的自增ID的最大值 4,294,967,295 42亿多
 * 2 如果消息预估大于这个mysql驱动不能够使用
 *
 * 使用场景:
 * 1 没有其他中间件
 * 2 数据量较小
 *
 *
 * Interface TaskInterface
 * @package ctod\core
 */
class MysqlQueue extends BaseQueue{
    /**
     * 数据库实例
     * @var null
     */
    private $db = null;
    /**
     * 队列对应的表名称
     * @var string
     */
    private $queue_table_name = '';
    /**
     * 默认配置
     * @var array
     */
    private $default_config = [
        'database_type' => 'mysql',
        'charset'       => 'utf8',
        'port'          => 3306,
    ];
    /**
     * @inheritdoc
     */
    public function init(){
        if(!$this->tableExist()){
            $sql = "CREATE TABLE IF NOT EXISTS `{$this->queue_table_name}` (
                    `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
                    `priority` TINYINT(1) NOT NULL,
                    `data` TEXT NOT NULL,
                    `create_time` VARCHAR(45) NOT NULL DEFAULT 0,
                    `status` TINYINT(1) NOT NULL DEFAULT 0,
                    PRIMARY KEY (`id`)
                ) ENGINE = InnoDB  DEFAULT CHARACTER SET = utf8";
            $this->db->query($sql);
        }
    }
    /**
     * MysqlQueue constructor.
     * @param string $queue_name
     * @param array $config
     */
    public function __construct($queue_name, array $config){
        parent::__construct($queue_name, $config);
        $db_config = array_merge($this->default_config,$this->config);
        $this->db = new \medoo($db_config);
        $this->queue_table_name = 'queue_'.$queue_name;
    }
    /**
     * @inheritdoc
     */
    public function getLength(){
        if(!$this->tableExist()){
            throw new \Exception('table不存在'.$this->queue_table_name);
        }
        return $this->db->count($this->queue_table_name);
    }
    /**
     * @inheritdoc
     */
    public function pop(){
        $result = false;
        $this->db->query('begin');
        $sql_base = "SELECT * FROM %s ORDER BY id LIMIT 1 FOR UPDATE ";
        $sql = sprintf($sql_base,$this->queue_table_name);
        $row  = $this->db->query($sql)->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $flag = $this->db->delete($this->queue_table_name, [
                'id' => $row['id']
            ]);
            if ($flag) {
                $this->db->query('commit');
                $data = json_decode($row['data'],true);
                $result = new Message($data['data'],$data['ttl']);
            } else {
                $this->db->query('rollback');
            }
        } else {
            $this->db->query('rollback');
        }
        return $result;
    }
    /**
     * 进入队列
     * @param string $data
     * @param int    $ttl
     * @throws \Exception
     */
    public function push($data,$ttl = 1 ){
        if(!is_string($data)){
            throw new \Exception("入队列必须是字符串");
        }
        if(!is_numeric($ttl)){
            throw new \Exception("TTL必须是数字");
        }
        if($ttl>=1){
            $insert_data = [
                'data'          => json_encode(['data'=>$data,'ttl'=>$ttl],JSON_UNESCAPED_UNICODE),
                'create_time'   => time(),
                'priority'      => 1,
            ];
            $this->db->insert($this->queue_table_name,$insert_data);
        }
    }

    public function isEmpty(){
        return $this->getLength() == 0 ;
    }
    private function tableExist(){
        $sql   = "show tables like '{$this->queue_table_name}'";
        $count = $this->db->query($sql)->rowCount();
        return $count > 0;
    }
}