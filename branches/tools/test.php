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
    $string = '197553,197556,197557,197560,197567,197568,197571,197573,197574,197575,197576,197577,197580,197581,197584,197585,197589,197591,197593,197594,197598,197599,197600';
    $array = explode(',', $string);
    var_dump($array);die;
    require_once 'Zend/Date.php';
    $now = new Zend_Date();
    $date = new Zend_Date('2014-02-28','y-MM-dd');
    if($date->isLater($now,'MM') ) {
        echo 'Later';
    } else {
        echo 'Earlier';
    }
    die;
    require_once 'Zend/Validate/Date.php';
    $validator = new Zend_Validate_Date('dd/MM/yy');
    $retval = $validator->isValid('30/11/1');
    
    echo '$retval='.$retval;
    die;
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



