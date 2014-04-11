<?php
function drawUserInfo($param) {
    $point = $param['point'];
    $colorBg = '#ffffff';
    $colorText = '#656469';
    $width = 10 + strlen($point) * 11;
    $im = imagecreate($width + 20, 20);
    $red = hexdec(substr($colorBg, 1 , 2));
    $green = hexdec(substr($colorBg, 3 , 2));
    $blue = hexdec(substr($colorBg, 5 , 2));
    $red_txt = hexdec(substr($colorText, 1 , 2));
    $green_txt = hexdec(substr($colorText, 3 , 2));
    $blue_txt = hexdec(substr($colorText, 5 , 2));
    $white = imagecolorallocate($im, $red,$green,$blue);		
    $black = imagecolorallocate($im, $red_txt,$green_txt,$blue_txt);

    // Make the background transparent
    imagecolortransparent($im, $white);
    $dest = imagecreatefrompng('font/plus.png');
    imagecopy($im,$dest,$width, -2, 0, 0, 20, 20);
    imagettftext($im, 11, 0, 5, 16, $black, "font/tahoma.ttf", number_format($point));
    imagepng($im);
    imagedestroy($im);
}
header('Content-Type: image/png');
drawUserInfo(array('point' => '100000','ranking' => 'Kim Cương'));