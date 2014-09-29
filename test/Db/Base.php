<?php
namespace Db;
use Exception;
use Core\Log;

abstract class Base {

    /**
     *
     * @var \Zend_Db_Adapter_Abstract
     */
    protected $_db;
    protected $_tableName;
    protected $_primaryKey;
    
    /**
     *
     * @var Log 
     */
    protected $_log;

    public function __construct($tableName,$primaryKey = 'id') {
        $this->_tableName = $tableName;
        $this->_primaryKey = $primaryKey;
        $this->_db = getDB('test2');
        $this->_log = Log::getInstance();
    }

    public function getLastInsertId() {
        if (!isset($this->_db)) {
            throw new Exception('Error system');
        }
        $stmt = $this->_db->prepare('SELECT LAST_INSERT_ID() as id');
        $stmt->execute();
        $row = $stmt->fetch();
        $stmt->closeCursor();
        return intval($row['id']);
    }
    
    /**
     * 
     * @param Long $id
     * @return Object
     */
    public function findById($id) {
        $sql = "select * from {$this->_tableName} where {$this->_primaryKey} = ?";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        return $row == false ? null : $row;
    }

    /**
     * 
     * @param Array $data
     * @param Boolean $returnId
     * @return type
     */
    public function insert($data,$returnId = false) {
        $this->_log->log(array(__CLASS__,__FUNCTION__,  $this->_tableName,$data,'$returnId='.$returnId));
        if(empty($data)) {
            return;
        }
        $s1 = array();
        $s2 = array();
        $params = array();
        foreach ($data as $colName => $colVal) {
            $s1[] = "`$colName`";
            $s2[] = ":$colName";
            $params[$colName] = $colVal;
        }
        $sql = 'INSERT INTO `' . $this->_tableName . '`(' . join(',', $s1) . ') VALUES (' . join(',', $s2) . ')';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute($params);
        $stmt->closeCursor();
        if($returnId) {
            return $this->getLastInsertId();
        }
    }

    /**
     * 
     * @param Array $data
     */
    public function update($id,$data) {
        $this->_log->log(array(__CLASS__,__FUNCTION__,  $this->_tableName,$data,'$id='.$id));
        if(empty($data)) {
            return;
        }
        //UPDATE answers SET word_id = :word_id, question_id = :question_id WHERE id = :id
        $params = array($this->_primaryKey => $id);
        $s = array();
        foreach ($data as $key => $value) {
            $s[] = "`{$key}` = :".$key;
            $params[$key] = $value;
        }
        $sql = "UPDATE `{$this->_tableName}` SET ".  join(',', $s)." WHERE {$this->_primaryKey} = :".$this->_primaryKey;
        $stmt = $this->_db->prepare($sql);
        $stmt->execute($params);
        $stmt->closeCursor();
    }
    
    public function query($data = array(),$isOne = false) {
        $where = ' 1 = 1 ';
        $params = array();
        foreach ($data as $key => $value) {
            if(empty($value)) {
                continue;
            }
            $where.= " AND `$key` = :$key";
            $params[$key] = $value;
        }   
        $sql = 'select * from '.$this->_tableName.' where '.$where;
        $stmt = $this->_db->prepare($sql);
        $stmt->execute($params);
        if($isOne) {
            $result = $stmt->fetch();
            if($result == false) {
                $result = null;
            }
        } else{
            $result = $stmt->fetchAll();
        }
        $stmt->closeCursor();
        return $result;
    }
}
