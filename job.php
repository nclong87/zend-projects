<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'functions.php';
include ROOT_DIR.'/libs/Zend/DB.php';
include ROOT_DIR.'/libs/Zend/Loader.php';
$db = getDB();
$sql = 'SELECT * FROM `zingid` WHERE `status` = 1 LIMIT 0,1';
$stmt = $db->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();
$sql = 'UPDATE `zingid` SET `status` = 0 WHERE `id` = ?';
$stmt = $db->prepare($sql);
foreach($rows as $row) {
	$url = 'https://admin.myplus.vn/test/update-csm?zid='.$row['zingid'];
	echo2($url);
	getContentByURL($url);
	$stmt->execute(array($row['id']));
}
$stmt->closeCursor();
die;