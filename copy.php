<?php
include 'functions.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * svn log -r {2013-12-20}:{2014-12-01} | grep -B2 longnc
 */

$bView = false;
$chdir = '/home/localadm/NetBeansProjects/123Pay/dev';
//$chdir = '/home/localadm/VNG/SandBox/123PaySandbox/sandbox/';
$folders = array(
    'application',
    'library',
    'public_html_ib'
);
$deployFolder = '/home/localadm/deploys/';
chdir($chdir);
$revisions = array('r15451','r15453','r15454','r15457','r15458','r15461');
//$revisions = array('r15456');
echo 'Revisions : '.join(',', $revisions).PHP_EOL;
$changeFiles = array();
foreach ($revisions as $value) {
    $value = Core_Number::parseNumber($value);
    $outputs = array();
    exec("svn log --verbose -r {$value} | grep /src",$outputs);
    $changeFiles = array_merge($changeFiles,$outputs);
}
if($bView) {
    debug($changeFiles);
}
$updateFiles = array();
foreach ($changeFiles as $value) {
    $value = trim($value);
    $arr = split(' ', $value);
    if($arr[0] != 'D') {
        $pos = false;
        foreach ($folders as $folder) {
            if(($pos = stripos($arr[1],$folder)) !== false) {
                break;
            }
        }
        if($pos !== false) {
            $file = substr($arr[1], $pos);
        }
        if(!in_array($file, $updateFiles)) {
            $updateFiles[] = $file;
        }
    }
}
exec("rm -rvf {$deployFolder}*");
echo 'Begin'.PHP_EOL;
foreach ($updateFiles as $key => $value) {
    echo 'Copying file "'.$value.'"'.PHP_EOL;
    $filePath = $value;
    exec("cp -i --parents {$filePath} {$deployFolder}");
}
echo 'Done'.PHP_EOL;

