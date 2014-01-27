<?php
require '/home/localadm/tools/libs/Predis/Autoloader.php';
Predis\Autoloader::register();
    
class Core_Redis
{
    protected $_redis;

    public function __construct($options = array())
    {
	$this->_redis = new Predis\Client($options);
    }
    
    public function isTheFirst($key,$timeout = 10) {
        if(empty($key)) {
            return false;
        }
        $len = $this->_redis->rpush($key, true);
        if($len > 1) {
            return false;
        }
        if($timeout != null) {
            $this->_redis->expire($key, $timeout);
        }
        return true;
    }
    public function set($key,$data,$timeout = null) {
        if(empty($key)) {
            return;
        }
        $this->_redis->set($key, $data);
        if($timeout != null) {
            $this->_redis->expire($key, $timeout);
        }
        return true;
    }
    public function get($key) {
        return $this->_redis->get($key);
    }
    public function incre($key) {
        return $this->_redis->incr($key);
    }
    public function getset($key,$val) {
        return $this->_redis->getset($key,$val);
    }
    	
}