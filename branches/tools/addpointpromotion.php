<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'functions.php';
include ROOT_DIR . '/libs/Zend/DB.php';
include ROOT_DIR . '/libs/Zend/Loader.php';

try {
	exit;
    $apikey = 'hUas@jk98*khas11';
    /*$aData = array(
        'zingid' => 'sintvn',
        'point' => 100000,
        'transaction' => genTransactionID('PROx2_'),
        'campaign_id' => 9,
        'notes' => 'Add Plus cho user mapping Smilescard nap zingxu'
    );
    echo2(json_encode($aData));
    $aData['checksum'] = sha1(join('', $aData).$apikey);
    $rs = callAPI('http://api-dev.123.vn/plusapi/addpoint-promotion',$aData,$apikey);
    debug($rs);
    exit;*/
    $sql = 'SELECT * FROM `add_point_promotion` WHERE `status` = 1 ORDER BY id limit 0,10';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    $stmt2 = $db->prepare('UPDATE `add_point_promotion` SET `status` = 0,transaction=? WHERE `id` = ?');
    foreach ($rows as $row) {
		$transaction = genTransactionID('PROx2_');
		$aData = array(
			'zingid' => $row['account'],
			'point' => $row['point'],
			'transaction' => $transaction,
			'campaign_id' => 47,
			'notes' => 'Add Plus cho user mapping Smilescard nap zingxu'
		);
        echo2(json_encode($aData));
        $aData['checksum'] = sha1(join('', $aData).$apikey);
        $rs = callAPI('http://api.123.vn/plusapi/addpoint-promotion',$aData,$apikey);
        if($rs[0] != 1) {
            debug($rs);
        }
        $stmt2->execute(array($transaction,$row['id']));
        sleep(3);
    }
    $stmt->closeCursor();
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}
die;
