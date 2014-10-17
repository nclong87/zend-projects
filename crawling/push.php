<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('ROOT_DIR', realpath(dirname(__FILE__)));
require 'defined.php';
require 'functions.php';
try {
    Core\Log::getInstance()->log(array('Job push data to nhamvl', 'begin'));
    if (is_connected() == false) {
        throw new Exception('No internet connection');
    }
    $rows = Db\Post_Nhamvl::getInstance()->query(array('status' => 1), false, 1);
    if(!empty($rows)) {
        $secretKey = 'tien@nhk0thi3u'; 
        $apiUrl = 'http://test.nhamvl.com/api/post';
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
            'Cookie: __utma=75409613.45388685.1412332518.1413012811.1413103491.19; __utmz=75409613.1412413502.5.4.utmcsr=l.facebook.com|utmccn=(referral)|utmcmd=referral|utmcct=/l.php; _ga=GA1.2.45388685.1412332518; PHPSESSID=nj8v293du9utmpfa2apuclnbb5; __utmc=75409613; _gat=1',
            'Host: test.nhamvl.com',
            'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:30.0) Gecko/20100101 Firefox/30.0',
        );
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        foreach ($rows as $row) {
            $post_data = array(
                'type' => $row['type'],
                'username' => $row['account_id'],
                'date' => date('Y-m-d H:i:s'),
                'caption' => $row['caption'],
                'link' => $row['link'],
                'source_url' => $row['source_url']
            );
            $post_data['checksum'] = sha1($post_data['type'] . $post_data['username'] . $post_data['date'] . $post_data['caption'] . $secretKey);
            Core\Log::getInstance()->log(array('Push data...', $post_data));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            $result = curl_exec($curl);
            Core\Log::getInstance()->log(array('Push data...', '$result='.$result));
            if ($result == null || empty($result)) {
                $result = '';
            }
            if($result == '') {
                throw new Exception('Cannot connect to NhamVL',-1000);
            }
            $result = json_decode($result, true);
            Core\Log::getInstance()->log(array('Push data...', $result));
            $response_code = isset($result['response_code'])?$result['response_code']:0;
            $response_message = isset($result['response_message'])?$result['response_message']:'';
            if($response_code != 1) {
                throw new Exception($response_message,$response_code);
            }
            //success
            Db\Post_Nhamvl::getInstance()->update($row['id'], array('status' => 2));
            sleep(3);
        }
    }
    Core\Log::getInstance()->log(array('Job push data to nhamvl', 'end'));
} catch (Exception $exc) {
    Core\Log::getInstance()->log($exc, 'error');
}
