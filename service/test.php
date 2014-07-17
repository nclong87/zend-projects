<?php
echo '<pre>';
$secretKey = '123456789'; //key only for test
$apiUrl = 'https://api.myplus.vn/request/csm-add-plus';
$post_data = array(
    'partner' => 'CSMADDPLUS',
    'fa_request_code' => 'FA-99399393933',
    'request_name' => 'Cộng điểm cho chủ phòng máy tháng 07/2014',
    'file_detail' => 'csm_add_point_201407.xlsx',
    'budget' => '1900000',
    'time_request' => '2014-07-15 10:30:00',
    'user_request' => 'sint',
    'request_info' => '{"request_type":"AAA","team":"CSM"}'
);
$post_data['checksum'] = sha1($post_data['partner'] . $post_data['fa_request_code'] . $post_data['file_detail'] . $post_data['budget'] . $post_data['user_request'] . $secretKey);
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
$result = json_decode($result, true);
print_r($result);