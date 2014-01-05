<?php
function debug($data,$exit = true) {
    print_r($data);
    if($exit) {
        exit;
    }
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
