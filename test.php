<?php
function isValidAlphabet($string) {
    if(empty($string)) {
        return true;
    }
    $length = strlen($string);
    $array = array('1','2','3','4','5','6','7','8','9','0','q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
    $i = 0;
    while ($i < $length) {
        if($i > 100) {
            break;
        }
        if(!isset($string[$i])) {
            break;
        }
        $char = strtolower($string[$i]);
        if(!in_array($char, $array)) {
            return false;
        }
        $i++;
    }
    return true;
}

$otp = '11234$3908';
$retval = isValidAlphabet($otp);
var_dump($retval);
