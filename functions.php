<?php
date_default_timezone_set('Asia/Bangkok');
define('DATE_YYYY_MM_DD', 'y-MM-dd');
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('ROOT_DIR', dirname(__FILE__));
set_include_path(ROOT_DIR.'/libs');
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

function getDB() {
    $options_storage = array(
        'adapter' => 'pdo_mysql',
        'params' => array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'test2',
            'charset' => 'utf8'
        )
    );

    //Set params
    if(empty($options_storage['params']['driver_options'])){
        $options_storage['params']['driver_options'] = array(
            1002    =>  'SET NAMES \'utf8\'',
            12      =>  0
        );
    }            

    //Create object to Connect DB
    $storageMaster = Zend_Db::factory($options_storage['adapter'], $options_storage['params']);

    //Changing the Fetch Mode
    $storageMaster->setFetchMode(Zend_Db::FETCH_ASSOC);

    // Create Adapter default is Db_Table
    //Zend_Db_Table::setDefaultAdapter($storageMaster);
    return $storageMaster;
}

function readExcel($file,$sheet) {
    $excel = new excel2JSON($file);
    $excel->load_sheet($sheet);
    $excel->load_sheet_data();
    $data = $excel->get_data();
    $retval = array();
    foreach ($data as $val) {
        $row = array();
        foreach ($val as $val2) {
            $row[] = trim($val2);
        }
        $retval[] = $row;
    }
    return $retval;
}
function callAPI($url, $post_data,$apikey) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_POST, 1);
	$post_items = array();
	foreach ($post_data as $key => $val) {
		$post_items[] = $key . '=' . $val;
	
	}
	$post_string = implode ('&', $post_items);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_string);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_USERPWD, "username:password");
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($curl);
	if($result == null || empty($result)){
            return null;
        }
	$result = json_decode($result,true);
	if(sha1(join('', $result['response']).$apikey) != $result['checksum']){
            die('Invalid checksum!');
        }
	return $result['response'];
}
function genTransactionID($prefix = 'TEST_') {
    return $prefix.date('YmdHis');
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
