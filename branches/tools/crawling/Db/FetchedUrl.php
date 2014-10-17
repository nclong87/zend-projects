<?php
namespace Db;
class FetchedUrl extends Base {
    protected static $_instance = null;

    /**
     * 
     * @return FetchedUrl
     */
    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }
        self::$_instance = new FetchedUrl('fetched_url');
        return self::$_instance;
    }
    
    public function __construct($tableName, $primaryKey = 'id') {
        parent::__construct($tableName, $primaryKey);
    }
}

