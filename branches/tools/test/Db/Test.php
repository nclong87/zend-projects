<?php
namespace Db;
use Db\Base;
class Test extends Base {
    protected static $_instance = null;

    /**
     * 
     * @return Test
     */
    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }
        self::$_instance = new Test('report1');
        return self::$_instance;
    }
    
    public function __construct($tableName, $primaryKey = 'id') {
        parent::__construct($tableName, $primaryKey);
    }
}

