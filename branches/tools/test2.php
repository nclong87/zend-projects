<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getSubDirFoolproof($dir, $sub)
{
    /*
    This is the ONLY WAY we have to make SURE that the
    last segment of $dir is a file and not a directory.
    */
    if (is_file($dir))
    {
        $dir = dirname($dir);
    }

    // Is it necessary to convert to the fully expanded path?
    $dir = realpath($dir);
    $sub = realpath($sub);

    // Do we need to worry about Windows?
    $dir = str_replace('\\', '/', $dir);
    $sub = str_replace('\\', '/', $sub);

    // Here we filter leading, trailing and consecutive slashes.
    $dir = array_filter(explode('/', $dir));
    $sub = array_filter(explode('/', $sub));

    // All done!
    return array_slice(array_diff($dir, $sub), 0, 1);
}
$path = 'http://10.60.30.251:8080/svn/MyPlus/Source/static.myplus.vn/dev/public_html/plus/v3.0/images/hot0.gif';
$ret = split('/', $path);
$ret = array_reverse($ret);
//$ret = getSubDirFoolproof($path,'v3.0');
print_r($ret);die;
$str = 'longnc@gmail.com';
if(strpos($str,'@vng.com.vn') > 0) {
    echo 'isVNG';
} else {
    echo 'notVNG';
}
die;
$str = '{"ReferenceNo":"123456","EventCode":"ABCD"}';
$array = json_decode($str, true);
print_r($array);die;
$array = array(
    'ReferenceNo' => '123456',
    'EventCode' => 'ABCD'
);
echo json_encode($array);
die;
$month = date('m');
die($month);
$str = 'myplus.vn: ban nhan duoc %s Plus tu chuong trinh phong may CSM  thang %s va %s luot quay so mien phi. Truy cap myplus.vn/csmqs de quay so';
$str = printf($str, number_format(100000),7,5);
echo $str;
die;
if($phone[0] != '0') {
    $phone = '0'.$phone;
}
die($phone);
$url = 'https://img.123pay.vn/imgmyplus/plus/v3.0/images/egg_ngan_nam_resized.png';
$tmp = parse_url($url);
var_dump($tmp);die;
$array = array(
    'request_type' => 'AAA',
    'team' => 'CSM'
);
echo json_encode($array);