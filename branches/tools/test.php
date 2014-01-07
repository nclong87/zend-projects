<?php
include 'functions.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * svn log -r {2013-12-20}:{2014-12-01} | grep -B2 longnc
 * svn log -r 15451 --verbose 
 */
try  {
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



