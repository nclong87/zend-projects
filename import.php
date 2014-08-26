<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'functions.php';
include ROOT_DIR.'/libs/Zend/DB.php';
include ROOT_DIR.'/libs/Zend/Loader.php';
require_once ROOT_DIR.'/libs/Excel/excelMap.class.php';
$file = 'D:\import.xlsx';
$retval = readExcel($file, 'Sheet1');
$db = getDB();
$sql = 'INSERT INTO `zingid`(`zingid`) VALUES ';
//$sql = 'INSERT INTO `plus_product_discount`(`promotion_code`,`product_id`,`discount_type`,`discount_value`,`start_time`,`end_time`,`create_time`,`update_time`,`status`) VALUES (?,?,?,?,?,?,NOW(),NOW(),1)';
$tmp = array();
foreach ($retval as $data) {
    // $data;
	$tmp[] = "('{$data[0]}')";
	//echo2(json_encode($data));
    //$stmt->execute($data);
}
//print_r($tmp);die;
$sql .= join(',',$tmp);
$stmt = $db->prepare($sql);
$stmt->execute();
//echo $sql;
//
//$sql = 'SELECT * FROM `add_point` WHERE `status` = 1';
//$stmt = $db->prepare($sql);
//$stmt->execute();
//$rows = $stmt->fetchAll();
$stmt->closeCursor();
die;