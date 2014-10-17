<?php
echo '<pre>';
$secretKey = 'tien@nhk0thi3u'; //key only for test
$apiUrl = 'http://test.nhamvl.com/api/post';
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
$header = array(
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'Accept-Encoding: gzip, deflate',
    'Accept-Language: en-US,en;q=0.5',
    'Authorization: Basic bmhhbXZsOm5oYW1uaGFt',
    'Cache-Control: max-age=0',
    'Connection: keep-alive',
    'Cookie: __utma=75409613.45388685.1412332518.1412937191.1413012811.18; __utmz=75409613.1412413502.5.4.utmcsr=l.facebook.com|utmccn=(referral)|utmcmd=referral|utmcct=/l.php; _ga=GA1.2.45388685.1412332518; PHPSESSID=nj8v293du9utmpfa2apuclnbb5',
    'Host: test.nhamvl.com',
    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:30.0) Gecko/20100101 Firefox/30.0',
);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
//curl_setopt($curl, CURLINFO_HEADER_OUT, true);
//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
//$headerSent = curl_getinfo($curl, CURLINFO_HEADER_OUT );
//print_r($headerSent);
if ($result == null || empty($result)) {
    return null;
}
print_r($result);die;
$result = json_decode($result, true);
print_r($result);