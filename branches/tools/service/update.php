<?php
function queryByInvoiceNo($invoiceNo) {
    $secretKey = '123456'; //key only for test
    //$apiUrl = 'http://local.api.myplus.vn/index/index';
    //$secretKey = 'xXBkoy6FcixMu0Rd'; //key only for test
    $apiUrl = 'https://api.myplus.vn/index/index';

    $post_data = array(
        'partner' => 'MYPLUS',
        'plus_invoice_no' => $invoiceNo,
    );
    $post_data['checksum'] = sha1($post_data['partner'] . $secretKey);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    $post_items = array();
    curl_setopt($curl, CURLOPT_TIMEOUT, 120);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if ($result == null || empty($result)) {
        return null;
    }
    //print_r($result);die;
    $result = json_decode($result, true);
    if(isset($result['response_data']['data']['order'])) {
        return $result['response_data']['data']['order'];
    }
    return null;
}
