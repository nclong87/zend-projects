<?php
echo '<pre>';
$secretKey = '123456789'; //key only for test
$apiUrl = 'https://api.myplus.vn/request/csm-add-plus';
//$apiUrl = 'http://dev.api.myplus.vn/request/csm-add-plus';
$file_detail = '/home/localadm/tools/data/csm_add_plus.xlsx';
$file_detail = '/home/localadm/tools/data/csm_add_plus123.xlsx';

//$file_detail = '/home/localadm/csm_add_plus.xlsx';
//$file_detail = '/home/localadm/tools/data/abcd.xlsx';
$checksum_file = md5_file($file_detail);
$data = file_get_contents($file_detail);
$data = base64_encode($data);
$post_data = array(
    'partner' => 'CMSPHONGMAY',
    'fa_request_code' => 'FA-99399393985',
    'request_name' => 'Cộng điểm cho chủ phòng máy tháng 07/2014',
    'file_detail' => $data,
    'checksum_file' => $checksum_file,
    //'budget' => '1894630000',
    'budget' => '2000940000',
    //'budget' => '15200000',
    'time_request' => '2014-07-15 10:30:00',
    'user_request' => 'sint',
    'request_info' => '{"ReferenceNo":"123456","EventCode":"ABCD"}'
);
$post_data['checksum'] = sha1($post_data['partner'] . $post_data['fa_request_code'] . $post_data['checksum_file'] . $post_data['budget'] . $post_data['user_request'] . $secretKey);
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