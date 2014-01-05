<?php
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
    foreach ($argv as $index => $value) {
        if($index > 0) {
            $arr = split('=', $value);
            if(count($arr) == 2) {
                $params[$arr[0]] = $arr[1];
            }
        }
    }
    return $params;
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
