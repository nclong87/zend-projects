<?php
echo '<pre>';
$secretKey = '123456789'; //key only for test
//$apiUrl = 'https://api.myplus.vn/request/csm-add-plus';
$apiUrl = 'http://local.api.myplus.vn/request/csm-add-plus';
$file_detail = '/home/localadm/tools/data/csm_add_plus.xlsx';
$file_detail = '/tmp/file.txt';

//$file_detail = '/home/localadm/csm_add_plus.xlsx';
//$file_detail = '/home/localadm/tools/data/abcd.xlsx';
//$checksum_file = md5_file($file_detail);
$data = file_get_contents($file_detail);
//$data = base64_encode($data);
$post_data = array(
    'partner' => 'CMSPHONGMAY',
    'fa_request_code' => 'fa-pm140905038',
    'request_name' => 'FA - Payment Request',
    'file_detail' => $data,
    'checksum_file' => '265fc8dd15250a1fdb0da1eda3c03bf0',
    //'budget' => '1894630000',
    'budget' => '90154000',
    //'budget' => '15200000',
    'time_request' => '2014-09-05 15:41:43',
    'user_request' => 'thaolst',
    'request_info' => '{"ReferenceNo":"FA-PA140725002","EventCode":"1408016-00"}'
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