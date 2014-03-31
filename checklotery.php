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
    $apikey = 'hU%12a@s789HaakL1';
    $aData = array(
        'zingid' => 'kiemtra123pay004',
        'client_ip' => '127.0.0.1'
    );
    echo2(json_encode($aData));
    $aData['checksum'] = sha1(join('', $aData).$apikey);
    $rs = callAPI('http://api.123.vn/plusapi/checklottery',$aData,$apikey);
    debug($rs);
    exit;
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}
die;
