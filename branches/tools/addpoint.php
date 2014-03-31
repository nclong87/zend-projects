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
    $apikey = 'hUas@jk98*khas11';
    /*
    $aData = array(
        'zingid' => 'pluskt01',
        'amount' => 100000,
        'transaction' => genTransactionID(),
        'percent' => 2,
        'merchantCode' => 'MP3',
        'notes' => 'Add Plus cho user nap MP3',
        'merchantType' => 'Zing VIP'
    );
    echo2(json_encode($aData));
    $aData['checksum'] = sha1(join('', $aData).$apikey);
    $rs = callAPI('http://api.123.vn/plusapi/addpoint',$aData,$apikey);
    debug($rs);
    exit;
     * 
     */
    $sql = 'SELECT * FROM `add_point` WHERE `status` = 1 ORDER BY id';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    $stmt2 = $db->prepare('UPDATE `add_point` SET `status` = 0 WHERE `id` = ?');
    foreach ($rows as $row) {
        $aData = array(
            'zingid' => $row['account'],
            'amount' => $row['amount'],
            'transaction' => $row['transaction'],
            'percent' => 2,
            'merchantCode' => 'MP3',
            'notes' => 'Add Plus cho user nap MP3',
            'merchantType' => 'Zing VIP'
        );
        echo2(json_encode($aData));
        /*$aData['checksum'] = sha1(join('', $aData).$apikey);
        $rs = callAPI('http://api.123.vn/plusapi/addpoint',$aData,$apikey);
        if($rs[0] != 1) {
            debug($rs);
        }*/
        $stmt2->execute(array($row['id']));
        sleep(3);
    }
    $stmt->closeCursor();
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}
die;
