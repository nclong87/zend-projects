<?php
echo '<pre>';
$secretKey = '123456'; //key only for test
//$secretKey = 'xXBkoy6FcixMu0Rd'; //key only for test
$apiUrl = 'http://local.api.myplus.vn/index/index';
$file_detail = '/tmp/fa-pm140910059_fix.xlsx';

//$file_detail = '/home/localadm/csm_add_plus.xlsx';
//$file_detail = '/home/localadm/tools/data/abcd.xlsx';
$checksum_file = md5_file($file_detail);
$data = file_get_contents($file_detail);
$data = base64_encode($data);

$post_data = array(
    'partner' => 'MYPLUS',
    'file_detail' => $data,
    'fa_request_code' => 'fa-pm140910059'
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
print_r($result);