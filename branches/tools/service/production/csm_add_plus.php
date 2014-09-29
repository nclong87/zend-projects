<?php
echo '<pre>';
$secretKey = 'xcjqbI6xArYGOoRI'; //key only for test
$apiUrl = 'https://api.myplus.vn/request/csm-add-plus';
$file_detail = '/tmp/FA-PM140903045_csm_add_plus.xlsx';
$checksum_file = md5_file($file_detail);
$data = file_get_contents($file_detail);
$data = base64_encode($data);
$post_data = array(
    'partner' => 'CMSPHONGMAY',
    'fa_request_code' => 'fa-pm140903045',
    'request_name' => 'FA - Payment Request',
    'file_detail' => $data,
    'checksum_file' => $checksum_file,
    'budget' => '130569545',
    'time_request' => '2014-09-03 14:47:03',
    'user_request' => 'phuongnht',
    'request_info' => '{"ReferenceNo":"FA-PA140701001","EventCode":"1407069-00"}'
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