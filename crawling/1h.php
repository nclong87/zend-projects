<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('ROOT_DIR', realpath(dirname(__FILE__)));
include 'defined.php';
include 'functions.php';
try {
    Core\Log::getInstance()->log(array('Job 1h','begin'));
    if(is_connected() == false) {
        throw new Exception('No internet connection');
    }
    $redis = Core\Redis::getInstance();
    $redis->rpush(KEY_REDIS_JOB_QUEUE, array(
        'class' => 'ChatVl',
        'data' => array(
            'url' => 'http://chatvl.com/',
        )
    ));
    $redis->rpush(KEY_REDIS_JOB_QUEUE, array(
        'class' => 'HaiVl',
        'data' => array(
            'url' => 'http://www.haivl.com/',
        )
    ));
    $redis->rpush(KEY_REDIS_JOB_QUEUE, array(
        'class' => 'HaiVlTv',
        'data' => array(
            'url' => 'http://haivl.tv/',
        )
    ));
    Core\Log::getInstance()->log(array('Job 1h','end'));
} catch (Exception $exc) {
    Core\Log::getInstance()->log($exc, 'error');
}

