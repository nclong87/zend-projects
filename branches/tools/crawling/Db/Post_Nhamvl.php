<?php
namespace Db;
class Post_Nhamvl extends Base {
    protected static $_instance = null;

    /**
     * 
     * @return Post_Nhamvl
     */
    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }
        self::$_instance = new Post_Nhamvl('push_nhamvl');
        return self::$_instance;
    }
    
    public function __construct($tableName, $primaryKey = 'id') {
        parent::__construct($tableName, $primaryKey);
    }
}

