<?php
date_default_timezone_set('Asia/Bangkok');
set_include_path('/home/localadm/tools/libs');
define('DATE_YYYY_MM_DD', 'y-MM-dd');
function debug($data,$exit = true) {
    print_r($data);
    if($exit) {
        exit;
    }
}
/**
 * @desc Echo and break line in console
 * @param type $string
 */
function echo2($string) {
    echo $string.PHP_EOL;
}

function safe_get($array,$element,$defaule='') {
    return isset($array[$element])?$array[$element]:$defaule;
}

function getPart($string,$pattern = ',',$index = 0) {
    if(empty($string)) {
        return '';    
    }
    if($pattern == '|') {
        $string = str_replace($pattern, 'xxx', $string);
        $pattern = 'xxx';
    }
    $array = split($pattern, $string);
    if(!isset($array[1])) return '';
    $return =  isset($array[$index])?$array[$index]:'';
    return trim($return);
}

function parseArgs($argv) {
    $params = array();
    $cur = '';
    foreach ($argv as $value) {
        if(stripos($value, '-') === 0) {
            $cur = str_replace('-', '', $value);
        } elseif(!empty($cur)) {
            $params[$cur] = trim($value);
        }
    }
    return $params;
}
function getDir($fielPath) {
    $pos = strrpos($fielPath, '/');
    if($pos !== false) {
        return substr($fielPath, 0, $pos);
    }
    return '';
}

class Core_Number
{	
	public static function parseInt($string) {
		$length = strlen($string);
		$str = '';
		for($i = 0; $i<$length;$i++) {
			if(is_numeric($string[$i])) {
				$str.=$string[$i];
			}
		}
		return intval($str);
	}
	public static function formatNumber($num) {
		return number_format($num,0,',','.');
	}
	public static function parseNumber($string) {
		$length = strlen($string);
		$str = '';
		for($i = 0; $i<$length;$i++) {
			if(is_numeric($string[$i]) || $string[$i]=='-') {
				$str.=$string[$i];
			}
		}
		return $str;
	}
}
