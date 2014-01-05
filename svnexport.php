<?php
include 'functions.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * svn log -r {2013-12-20}:{2014-12-01} | grep -B2 longnc
 */
if(isset($argv[1]) && ($argv[1] == '--help' || $argv[1] == '--h')) {
    echo PHP_EOL;
    echo2('Description : export files change in revisions');
    echo2('Usage : php ~/tools/svnexport.php [OPTIONS]');
    echo2('Examples :');
    echo2('   svnexport.php  -> HEAD revision');
    echo2('   svnexport.php 15451,15453,15455');
    echo PHP_EOL;
    exit;
}
try {
    $deployFolder = '/home/localadm/deploys/';
    $folders = array(
        'application',
        'library',
        'public_html_ib'
    );
    $chdir = getcwd();
    chdir($chdir);
    if(!isset($argv[1]) || empty($argv[1])) {
        $str_revision = 'HEAD';
    } else {
        $str_revision = $argv[1];
    }
    echo2('Revisions : '.$str_revision);
    $revisions = split(',', $str_revision);
    $changeFiles = array();
    foreach ($revisions as $value) {
        $outputs = array();
        exec("svn log --verbose -r {$value} | grep /src",$outputs);
        $changeFiles = array_merge($changeFiles,$outputs);
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
    echo PHP_EOL;
    foreach ($updateFiles as $key => $value) {
        echo 'Copying file "'.$value.'"'.PHP_EOL;
        $filePath = $value;
        exec("cp -i --parents {$filePath} {$deployFolder}");
    }
    echo PHP_EOL;
    echo 'Done'.PHP_EOL;
} catch (Exception $exc) {
    echo2('Error : '.$exc->getMessage());
}

