<?php
echo '<pre>';
$secretKey = '12345678'; //key only for test
$apiUrl = 'https://api.myplus.vn/request/csm-add-plus';
$apiUrl = 'http://local-api.myplus.vn/request/csm-add-plus';
$post_data = array(
    'partner' => 'CSMADDPLUS',
    'fa_request_code' => 'FA-99399393933',
    'request_name' => 'Cộng điểm cho chủ phòng máy tháng 07/2014',
    'file_attach' => 'http://10.10.10.10/filescsm_/add_point_201407.xlsx',
    'total_point' => '1900000',
    'total_user' => '8400',
    'time_request' => '2014-07-15 10:30:00',
    'user_request' => 'sint',
    'request_info' => '{"request_type":"AAA","team":"CSM"}'
);
$post_data['checksum'] = sha1($post_data['partner'] . $post_data['fa_request_code'] . $post_data['file_attach'] . $post_data['total_point'] . $post_data['total_user'] . $post_data['user_request'] . $secretKey);
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
curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
if ($result == null || empty($result)) {
    return null;
}
//print_r($result);die;
$result = json_decode($result, true);
print_r($result);