<?php
include 'functions.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * svn log -r {2013-12-20}:{2014-12-01} | grep -B2 longnc
 * svn log -r 15451 --verbose 
 */
define('MIN_PAY_MONEY',20000);
define('MIN_PAY_PLUS',50000);
function getAvailabeRange($userPoint,$totalPoint) {
    if($totalPoint < (MIN_PAY_PLUS + MIN_PAY_MONEY + 10000) && $userPoint < $totalPoint) {
        return array(0,0);
    }
    $result = array(0, 0);
    $min = MIN_PAY_PLUS;
    $max = $totalPoint - MIN_PAY_MONEY;
    if ($max < $min) {
        $max = $min = $totalPoint;
    }
    if ($userPoint < $min) {
        $max = $min = 0;
    } elseif ($userPoint < $max) {
        $max = $userPoint;
    }
    $result[0] = $min;
    $result[1] = $max;

    return $result;
}
try  {
    die(md5('113902918621242014012100759'));
    $key = '123PLUS@SecretKey';
    $transId = '1242014012100929';
    $time= '1390290996';
    $status = '1';
    debug(md5($status. $time .$transId . $key));
    $point = 6400;
    debug($point - ($point%10000));
    debug(time());
    $url = 'https://plus.123pay.vn/news/newsdetail.77.123pay_hop_tac_cung_galaxy_mua_ve_online_that_de_dang.html?utm_source=PlusPay&utm_medium=BannerTop&utm_campaign=&block=PLUSxTOP&adv_type=banner';
    $arr = parse_url($url);
    debug($arr);
    $testcases = array(
        array(39000,40000,0,0),
        array(39000,49000,0,0),
        array(39000,50000,0,0),
        array(39000,60000,0,0),
        array(39000,79000,0,0),
        array(39000,80000,0,0),
        array(39000,90000,0,0),
        
        array(40000,40000,40000,40000),
        array(49000,49000,49000,49000),
        array(50000,50000,50000,50000),
        array(60000,60000,60000,60000),
        array(78000,79000,0,0),
        array(79000,80000,50000,60000),
        array(80000,90000,50000,70000),
        
        array(50000,40000,40000,40000),
        array(59000,49000,49000,49000),
        array(60000,50000,50000,50000),
        array(70000,60000,60000,60000),
        array(89000,79000,50000,59000),
        array(90000,80000,50000,60000),
        array(91000,90000,50000,70000),
        
        array(80000,100000,50000,80000),
    );
    foreach ($testcases as $index => $value) {
        $userPoint = $value[0];
        $totalPoint = $value[1];
        $availabeRange = getAvailabeRange($userPoint, $totalPoint);
        $result = 'Fail';
        if($availabeRange[0] == $value[2] && $availabeRange[1] == $value[3]) {
            $result = 'Pass';
        }
        echo2('Test case '.($index + 1).' : '.$result);
//        print_r(array(
//            'userPoint' => $userPoint,
//            'totalPoint' => $totalPoint,
//            'min' => $availabeRange[0],
//            'max' => $availabeRange[1],
//            'result' => $result
//            
//        ));
//        echo PHP_EOL;
    }
    die;
    $userPoint = 39000;
    $totalPoint = 40000;
    debug(getAvailabeRange($userPoint, $totalPoint));
    $i = 54000;
    debug(intval($i/10000));
    require_once 'Zend/Date.php';
    $date = new Zend_Date();
    debug($date->toString('y-M-d'));
    $date = date('Y-m-d H:s');
    debug($date);
    $string = 'r15454 | longnc@VNG | 2014-01-04 18:38:39 +0700 (T7, 04 Th01 2014) | 1 line';
    $array = split('|', $string);
    debug($array);
    echo 'Done'.PHP_EOL;
} catch (Exception $exc) {
    echo2('Error : '.$exc->getMessage());
    //echo $exc->getTraceAsString();
}



