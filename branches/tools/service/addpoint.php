<?php
echo '<pre>';
$secretKey = '123456'; //key only for test
$apiUrl = 'http://local.api.myplus.vn/request/addpoint';
$post_data = array(
    'partner' => 'DS_CSM',
    'request_payment_code' => 'FA-PA140929002',
    'merchant_transaction' => 'CSM_1234567890',
    //'merchant_transaction' => 'CSM_'.date('YmdHis').rand(1, 10000),
    'zingid' => 'pluskt02',
    'point_add' => '4000',
    'more_info' => '',
    'client_ip' => '127.0.0.1',
);
$post_data['checksum'] = sha1($post_data['partner'] . $post_data['request_payment_code'] . $post_data['merchant_transaction'] . $post_data['zingid'] . $post_data['point_add'] . $post_data['client_ip'] . $secretKey);
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
print_r($result);