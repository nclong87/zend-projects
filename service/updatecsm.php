<?php
function updateCsm($zingid) {
    $apiUrl = 'https://api.myplus.vn/index/index';
    $post_data = array(
        'partner' => 'MYPLUS',
        'zingid' => $zingid,
    );
    //$post_data['checksum'] = sha1($post_data['partner'] . $post_data['code'] . $post_data['IMEI'] . $post_data['OS'] . $post_data['client_ip'] . $secretKey);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 120);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if ($result == null || empty($result)) {
        throw new Exception('Connection failed!');
    }
    return $result;
    //return json_decode($result, true);
}

function queryCsm($zingid) {
    $url = 'http://api2.csmbonus.csm.zing.vn/api/grlv?v='.$zingid.'&m=2';
    echo2($url);
    $result = getContentByURL($url);
    echo2($result);
    return json_decode($result, true);;
}