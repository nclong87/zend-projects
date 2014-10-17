<?php
echo '<pre>';
$secretKey = '123456'; //key only for test
$apiUrl = 'http://local.nhamvl.com/api/post';
$post_data = array(
    'type' => 'video',
    'username' => '10203577281291090',
    'date' => date('Y-m-d H:i:s'),
    'caption' => 'Test auto post VIDEO',
    'link' => 'https://www.youtube.com/watch?v=KPGHx5vSdDU',
    'source_url' => 'http://haivl.com'
);
$post_data['checksum'] = sha1($post_data['type'] . $post_data['username'] . $post_data['date'] . $post_data['caption'] . $secretKey);
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
print_r($result);die;
$result = json_decode($result, true);
print_r($result);