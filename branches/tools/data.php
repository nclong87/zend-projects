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
$file = 'D:\zingvip.xlsx';
$retval = readExcel($file, 'Worksheet');
$db = getDB();
$sql = 'INSERT INTO `add_point`(`account`,`point`,`transaction`) VALUES (?,?,?)';
$stmt = $db->prepare($sql);
foreach ($retval as $data) {
    echo2(json_encode($data));
    $stmt->execute($data);
}
//
//$sql = 'SELECT * FROM `add_point` WHERE `status` = 1';
//$stmt = $db->prepare($sql);
//$stmt->execute();
//$rows = $stmt->fetchAll();
$stmt->closeCursor();
die;