<?php
echo '<pre>';
$secretKey = '123456'; //key only for test
$apiUrl = 'http://dev.api.myplus.vn/promotion/checkcode';

$post_data = array(
    'partner' => 'LMAH201408',
    'code' => '479071',
    'IMEI' => '123456',
    'OS' => 'IOS 12345',
    'client_ip' => '127.0.0.1',
);
$post_data['checksum'] = sha1($post_data['partner'] . $post_data['code'] . $post_data['IMEI'] . $post_data['OS'] . $post_data['client_ip'] . $secretKey);
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