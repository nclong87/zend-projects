<?php

//require '/home/localadm/tools/libs/Predis/Autoloader.php';

namespace Core;

use Predis\Autoloader;
use Exception;
use Core\Log;
use Predis\Client;

Autoloader::register();

class Redis {

    protected static $_instance = null;

    /**
     * 
     * @return \Core\Redis
     */
    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }
        $options = array(
            'server' => 'localhost',
            'port' => '6379',
            'timeout' => 0,
            'prefix' => 'local'
        );
        self::$_instance = new \Core\Redis($options);
        return self::$_instance;
    }

    protected $_rd;

    public function __construct($options = array()) {
        $this->_rd = new Client($options);
    }

    public function isTheFirst($key, $timeout = 10) {
        if (empty($key)) {
            return false;
        }
        $len = $this->_rd->rpush($key, true);
        if ($len > 1) {
            return false;
        }
        if ($timeout != null) {
            $this->_rd->expire($key, $timeout);
        }
        return true;
    }

    public function push($key, $data = true, $timeout = null) {
        try {
            if (empty($key)) {
                return false;
            }
            if ($this->_rd->exists($key)) {
                return false;
            }
            $this->_rd->rpush($key, $data);
            if ($timeout != null) {
                $this->_rd->expire($key, $timeout);
            }
            return true;
        } catch (Exception $exc) {
            Log::getInstance()->log($exc, 'error');
        }
        return false;
    }

    /**
     * 
     * @param string $key
     * @param mix $data
     * @param int $timeout (0)
     */
    public function set($key, $data, $timeout = 0) {
        if (empty($key)) {
            return false;
        }
        $this->_rd->set($key, $data);
        if ($timeout > 0) {
            $this->_rd->expire($key, $timeout);
        }
        return true;
    }

    /**
     * 
     * @param string $key
     * @return mix
     */
    public function get($key) {
        if (empty($key)) {
            return null;
        }
        return $this->_rd->get($key);
    }

    /**
     * 
     * @param string $key
     */
    public function remove($key) {
        return $this->_rd->del($key);
    }

    /**
     * 
     * @param string $key
     * @return mix
     */
    public function length($key) {
        if (empty($key)) {
            return null;
        }
        return $this->_rd->llen($key);
    }

    public function increase($key, $timeout = null) {
        try {
            if (empty($key)) {
                return 0;
            }

            if ($this->_rd->exists($key)) {
                if ($timeout > 0) {
                    $this->_rd->expire($key, $timeout);
                }
            }

            return $this->_rd->incr($key);
        } catch (Exception $exc) {
            Log::getInstance()->log($exc, 'error');
        }
        return 0;
    }

    public function decrease($key) {
        try {
            if (empty($key)) {
                return 0;
            }
            if (!$this->_rd->exists($key)) {
                return 0;
            }
            $len = $this->_rd->decr($key);
            if ($len == 0) {
                $this->remove($key);
            }
            return $len;
        } catch (Exception $exc) {
            Log::getInstance()->log($exc, 'error');
        }
        return 0;
    }

    public function exists($key) {
        if (empty($key)) {
            throw new Exception(ERROR_SYSTEM);
        }
        return $this->_rd->exists($key);
    }

    public function pop($key,$json_decode = false) {
        try {
            if (empty($key)) {
                return null;
            }
            $val = $this->_rd->lpop($key);
            if($json_decode) {
                $val = json_decode($val, true);
            }
            return $val;
        } catch (Exception $exc) {
            Log::getInstance()->log($exc, 'error');
        }
        return null;
    }

    public function rpush($key, $data = true, $timeout = null) {
        try {
            if (empty($key)) {
                return 0;
            }
            if(is_array($data)) {
                $data = json_encode($data);
            }
            $len = $this->_rd->rpush($key, $data);
            if ($timeout != null) {
                $this->_rd->expire($key, $timeout);
            }
            return $len;
        } catch (Exception $exc) {
            Log::getInstance()->log($exc, 'error');
        }
        return 0;
    }

}
