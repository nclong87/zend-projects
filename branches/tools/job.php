<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'functions.php';
include 'service/update.php';
include ROOT_DIR.'/libs/Zend/Db.php';
include ROOT_DIR.'/libs/Zend/Loader.php';
$db = getDB();
$sql = 'select * from myplus_topup where alo_order_id is null and test_status = 1 limit 0,30';
$stmt = $db->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();
$sql = 'update myplus_topup set test_status = 0, alo_order_id = :alo_order_id, order_status = :order_status where plus_invoice_no = :plus_invoice_no';
$stmt = $db->prepare($sql);
foreach ($rows as $row) {
    $response = queryByInvoiceNo($row['plus_invoice_no']);
    $aloOrderNo = isset($response['order_no'])?$response['order_no']:'';
    $orderStatus = isset($response['order_status_id'])?$response['order_status_id']:0;
    if(!empty($aloOrderNo)) {
        $updateData = array(
            'alo_order_id' => $aloOrderNo,
            'order_status' => $orderStatus,
            'plus_invoice_no' => $row['plus_invoice_no']
        );
        echo2(json_encode($updateData));
        $stmt->execute($updateData);
        sleep(1);
    }
}
die;