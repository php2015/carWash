<?php
/**
 * 阿里大于短信相关配置
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 14:33
 */
return [
    'appKey' => '', // appkey
    'secretKey' => '',//secrekey
    'signName' => '', //短信标头
    'templateCode' => '',//templateCode
    'identify_time' => 60*10,//十分钟过期
    'top_sdk_work_dir' => '/tmp/',
];