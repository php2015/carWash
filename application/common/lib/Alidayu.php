<?php
/**
 * Created by PhpStorm.
 * User: <code301@163.com>
 * Date: 18/8/29
 * Time: 上午12:27
 */
namespace app\common\lib;
use ali\top\TopClient;
use ali\top\request\AlibabaAliqinFcSmsNumSendRequest;
use think\Cache;
use think\Log;
/**
 * 阿里大于发送短信基础类库
 * Class Alidayu
 * @package app\common\lib
 */
class Alidayu {

    const LOG_TPL = "alidayu:";
    /**
     * 静态变量保存全局的实例
     * @var null
     */
    private static $_instance = null;

    /**
     * 私有的构造方法
     */
    private function __construct() {

    }

    /**
     * 静态方法 单例模式统一入口
     */
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * 设置短信验证
     * @param int $phone
     * @return bool
     */
    public function setSmsIdentify($phone = 0) {
        $code = rand(100000, 999999); // 生成6位验证码随机数

        try {
            $c = new TopClient;
            $c->appkey = config('alidayu.appKey');
            $c->secretKey = config('alidayu.secretKey');
            $req = new AlibabaAliqinFcSmsNumSendRequest;
            $req->setExtend("123456");
            $req->setSmsType("normal");
            $req->setSmsFreeSignName(config('alidayu.signName'));
            $req->setSmsParam("{\"number\":\"" . $code . "\"}");
            $req->setRecNum($phone);
            $req->setSmsTemplateCode(config('alidayu.templateCode'));
            $resp = $c->execute($req);
        }catch (\Exception $e) {
            // 记录日志
            Log::write(self::LOG_TPL."alidayu-----" . $e->getMessage());
            return false;
        }

        if($resp->result->success == "true") {
            // 设置验证码失效时间
            Cache::set($phone, $code, config('alidayu.identify_time'));
            return true;
        }else {
            Log::write(self::LOG_TPL.'alidayu----error' . json_encode($resp));
        }
        return false;
    }

    /***
     * 根据手机号码查询验证码是否正常
     * @param int $phone
     * @return bool|mixed
     */
    public function checkSmsIdentify($phone = 0) {
        if(!$phone) {
            return false;
        }
        return session($phone, $phone);
    }
}