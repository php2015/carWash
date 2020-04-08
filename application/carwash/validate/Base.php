<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/4
 * Time: 15:07
 */
namespace app\carwash\validate;


use think\Validate;

class Base extends Validate
{
    /**
     * 限制2位小数
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     */
    protected function decimal($value, $rule, $data) {
        $reg = '/^[0-9]+(.[0-9]{1,2})?$/';//整数或者2位小数
        $res = preg_match($reg, $value);
        return $res ? true : '金额类请输入两位小数';
    }

    /**
     * 只允许输入中文
     * @param $value
     * @return bool|string
     */
    protected function regChinese($value, $rule, $data){
        $reg = '/^[\x7f-\xff]+$/';//只允许输入中文
        $res = preg_match($reg,$value);
        return $res ? true : '服务类别只允许输入中文';
    }
}