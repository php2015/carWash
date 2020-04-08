<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/25
 * Time: 14:16
 */

namespace app\api\controller\v1;

use captchas\Captchas;

/***
 * 生成系统验证码控制器
 * Class Vcode
 * @package app\api\controller\v1
 */
class Vcode
{
    /***
     * 返回验证码
     * @return string
     */
    public function getVerify(){
        list($t1, $sid) = explode(' ', microtime());
        $data['url'] = config('token.web_site_domain')."index.php/api/v1/Vcode/setVerify?sid=".$sid;
        $data['sid'] = $sid;
        return $data;
    }

    /***
     * 生成验证码
     * @return \think\Response
     */
    public function setVerify(){
        $sid=request()->get('sid');
        $captcha = new captchas(config('app.captcha'));
        return $captcha->entry($sid);
    }

    /***
     * 校验验证码
     * @param $vCode
     * @return bool
     */
    public function checkVCode($params)
    {
        $captcha = new captchas(config('app.captcha'));
        return $captcha->check($params['code'] , $params['sid']);
    }
}