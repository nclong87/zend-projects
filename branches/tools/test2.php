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
 function contains($string,$char) {
		if (strpos($string,$char) !== false) {
	    	return true;
		}
		return false;
	}
        
function trimPhoneNumber($phoneNumber) {
    $i = 0;
    $max = 100;
    $return = '';
    while(isset($phoneNumber[$i])) {
        if($i > $max) {
            break;
        }
        if(is_numeric($phoneNumber[$i])) {
            $return.= $phoneNumber[$i];
        }
        $i++;
    }
    return $return;
} 
$array = array(1,2,3,4);
unset($array[1]);
shuffle($array);
print_r($array);
die;
$vat = get_loaded_extensions();
print_r($vat);die;
$str = ' 1216240768 - ';
$str = trimPhoneNumber($str);
var_dump($str);die;
$user_request = 'longnc';
if(contains($user_request, '@vng.com.vn') === false) {
    $user_request .= '@vng.com.vn';
}
var_dump($user_request) ;die;
$str = '{"totalAmount":"20000",\"phone\":\"01217134732\",\"email\":\"cuongdnp@vng.com.vn\",\"amount\":\"20000\",\"cardType\":\"\",\"number\":\"1\",\"accountName\":\"pluskt01\",\"pid\":\"00141339\"}';
print_r(json_decode($str, true));
die;
$array = array(
    'part1' => 'Do your friend describe enough 3 situation (1point for 1 situation, maximum 3 points)',
    'part2' => 'Do your friend describe it clearly (maximum 3 points)',
    'part3' => 'Do all the situation is a proactive situations? (maximum 3/3)',
        
);
$f = 7/11;
die('f='.$f);
echo json_encode($array);die;
$i = rand(1, 2);
echo 'num='.$array[$i];die;
echo hash('sha256', 'longnc');
die;
$title=urlencode('Nhận ngay 5000 điểm Plus MIỄN PHÍ');
$url=urlencode('https://myplus.vn/san-plus/lmah');
$summary=urlencode('Cài game Liên Minh Anh Hùng Mobile – nhận ngay 5000 điểm Plus. Với điểm Plus bạn dễ dàng đổi được những vật phẩm Ingame, thẻ Zing, thẻ điện thoại, hàng công nghệ… Truy cập Myplus.vn để tham gia nhiều chương trình hấp dẫn khác');
die('http://www.facebook.com/sharer.php?u='.$url.'&t='.$title);
die(urlencode('San diem Plus'));

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