<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('ROOT_DIR', realpath(dirname(__FILE__)));
require 'defined.php';
require 'functions.php';
require 'Core/phpQuery.php';
try {
    Core\Log::getInstance()->log(array('Job 15m','begin'));
    if(is_connected() == false) {
        throw new Exception('No internet connection');
    }
    $redis = Core\Redis::getInstance();
    $retval = $redis->pop(KEY_REDIS_JOB_QUEUE,true);
    if(isset($retval['class'])) {
        $class = call_user_func(array('\Site\\'.$retval['class'], 'getInstance'));
        //$class = \Site\HaiVl::getInstance();
        $class->process($retval['data']);
    }
    Core\Log::getInstance()->log(array('Job 15m','end'));
} catch (Exception $exc) {
    Core\Log::getInstance()->log($exc, 'error');
}
