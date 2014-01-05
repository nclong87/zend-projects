<?php
include 'functions.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * svn log -r {2013-12-20}:{2014-12-01} | grep -B2 longnc
 */
$chdir = getcwd();
chdir($chdir);
//$revisions = array('r15451','r15453','r15454','r15457','r15458','r15461');
echo 'Revisions : ';
$str = fgets(STDIN);
if(empty($str)) {
    die ('No revison selected');
}
$revisions = split(',', $str);
$changeFiles = array();
foreach ($revisions as $value) {
    $value = Core_Number::parseNumber($value);
    $outputs = array();
    exec("svn log --verbose -r {$value} | grep /src",$outputs);
    $changeFiles = array_merge($changeFiles,$outputs);
}
echo 'Change files:'.PHP_EOL;
foreach ($changeFiles as $i => $val) {
    echo $i.'. '.$val.PHP_EOL;
}
echo 'Done'.PHP_EOL;

