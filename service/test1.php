<?php
echo '<pre>';
error_reporting(0);
//$secretKey = '123456';
//$apiUrl = 'http://local-api.myplus.vn/quayso/history';
$secretKey = 'TQrWsrBK1wk8sG4H';
$apiUrl = 'https://api.myplus.vn/quayso/history';
$transaction = 'CSM'.date('YmdHis').rand(0, 1000);
$post_data = array(
    'partner' => 'CSM',
    'campaign' => '2',
    'account_id' => 'nclong87',
);
$post_data['checksum'] = sha1($post_data['partner'] . $post_data['campaign'] . $post_data['account_id'] . $secretKey);
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
$post_items = array();
foreach ($post_data as $key => $val) {
    $post_items[] = $key . '=' . $val;
}
$post_string = implode('&', $post_items);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_string);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//curl_setopt($curl, CURLOPT_USERPWD, "username:password");
curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
if ($result == null || empty($result)) {
    return null;
}
//  print_r($result);die;
$result = json_decode($result, true);
print_r($result);
die;
//validate checksum
if($result['checksum'] != sha1($result['response_code'] . $result['response_message'] . $result['transaction'] . $secretKey)) {
    die('Invalid checksum');
}

//Process result
print_r($result);