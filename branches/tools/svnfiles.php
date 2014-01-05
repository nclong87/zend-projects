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
    echo2('Description : view files change in revisions');
    echo2('Usage : php ~/tools/svnfiles.php [OPTIONS]');
    echo2('Examples :');
    echo2('   svnfiles.php  -> HEAD revision');
    echo2('   svnfiles.php 15451,15453,15455');
    echo PHP_EOL;
    exit;
}
try {
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
    echo2('------------------------------------------------------------------------');
    echo PHP_EOL;
    echo 'Change files:'.PHP_EOL;
    foreach ($changeFiles as $i => $val) {
        echo $i.'. '.$val.PHP_EOL;
    }
    echo PHP_EOL;
    echo2('------------------------------------------------------------------------');
    echo2('Revisions : '.$str_revision);
    echo PHP_EOL;
} catch (Exception $exc) {
    echo2('Error : '.$exc->getMessage());
}

