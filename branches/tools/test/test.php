<?php

//include '../functions.php';
//$log = Core\Log::getInstance();
//$redis = Core\Redis::getInstance();
//$retval = $redis->increase('test_12345',1000);
//debug($retval);
//$log->log(array('a','b',1));
//$test = Db\Test::getInstance();
//$id = $test->insert(array('test_value' => 'Test'), true);
//echo $id;

define('ROOT_DIR', realpath(dirname(__FILE__)));
require 'defined.php';
require 'functions.php';
$testDb = Db\Test::getInstance();
$data = $testDb->query();

foreach ($data as $value) {
    $array = array('path_image' => img_path($value['image']));
    print_r($array);
}
echo PHP_EOL;

