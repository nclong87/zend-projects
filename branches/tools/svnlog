<?php
include 'functions.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * svn log -r {2013-12-20}:{2014-12-01} | grep -B2 longnc
 * svn log -r 15451 --verbose 
 */
if(isset($argv[1]) && ($argv[1] == '--help' || $argv[1] == '--h')) {
    echo PHP_EOL;
    echo2('Description : view log revisions with files change in each revision');
    echo2('Usage : php ~/tools/svnlog.php [OPTIONS]');
    echo2('Examples :');
    echo2('   svnlog.php t=time from=2014-01-01 grep=longnc');
    echo2('   svnlog.php limit=20 grep=longnc');
    echo PHP_EOL;
    exit;
}
try {
    $args = parseArgs($argv);
    $chdir = getcwd();
    chdir($chdir);
    $grep = safe_get($args, 'grep');
    if(empty($grep)) {
        $grep = 'longnc';
    }
    $type = safe_get($args, 't');
    if($type == 'time') {
        if(($from = safe_get($args, 'from')) == '') {
            throw new Exception('Miss param "from"');
        }
        $to = safe_get($args, 'to');
        if(empty($to)) {
            $to = date('Y-m-d');
        }
        $exec = "svn log -r {{$from}}:{{$to}} | grep -B3 ".$grep;
    } else {
        $limit = safe_get($args, 'limit', 10);    
        $exec = "svn log --limit {$limit} | grep -B3 ".$grep;
    }
    echo2($exec);
    $outputs = array();
    exec($exec,$outputs);
    $revisions = array();
    foreach ($outputs as $key => $value) {
        $revision = getPart($value, '|', 0);
        if(!empty($revision)) {
            $revisions[] = Core_Number::parseNumber($revision);
            
        }
    }
    echo2('Revisions : '.join(',', $revisions));
    foreach ($revisions as $revision) {
        echo PHP_EOL;
        $outputs = array();
        exec("svn log -r {$revision} --verbose",$outputs);
        if(!empty($outputs)) {
            unset($outputs[count($outputs) - 1]);
            echo join(PHP_EOL, $outputs);
        }
        
        echo PHP_EOL;
    }
    echo PHP_EOL;
    echo PHP_EOL;
    echo PHP_EOL;
    echo2('------------------------------------------------------------------------');
    echo2('Revisions : '.join(',', $revisions));
    echo 'Done'.PHP_EOL;
} catch (Exception $exc) {
    echo2('Error : '.$exc->getMessage());
    //echo $exc->getTraceAsString();
}



