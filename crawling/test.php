<?php
define('ROOT_DIR', realpath(dirname(__FILE__)));
require 'defined.php';
require 'functions.php';
require 'Core/phpQuery.php';
try {
    $redis = Core\Redis::getInstance();
    $retval = $redis->length(KEY_REDIS_JOB_QUEUE);
    debug($retval);
} catch (Exception $exc) {
    var_dump_exception($exc);
    \Core\Log::getInstance()->log($exc, 'error');
}

