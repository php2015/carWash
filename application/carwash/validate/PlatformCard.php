<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/6
 * Time: 18:11
 */

namespace app\carwash\validate;


class PlatformCard extends Base
{
    //定义验证规则
    protected $rule = [
        'card_type|卡种类别'       => 'require',
        'cardname|卡名称'          => 'require|max:8|unique:platform_card',
        'cash_pay_value|卡种价格'  => 'require|gt:0|decimalValue',
        'period|使用期限'          => 'require',
        'sale_status|状态'         => 'require',
    ];

    //定义验证提示
    protected $message = [
        'card_type.require'     =>'请选择卡种类别',
        'cardname.require'      =>'请输入卡种名称',
        'cardname.max'          =>'卡种名称不能超过8个字',
        'cash_pay_value.require'=>'请输入卡种价格',
        'cash_pay_value.gt'     =>'卡种价格需大于0',
        'period.require'        =>'请选择卡种使用期限',
        'sale_status.require'   =>'请选择卡种状态',

    ];
    protected function decimalValue($value, $rule, $data) {
        //$reg = '/^[0-9]{1,5}+(.[0-9]{1,2})?$/';//整数或者2位小数
        $reg = '/^\d{1,5}\.\d{2}$/';//整数或者2位小数
        $res = preg_match($reg, $value);
        return $res ? true : '卡种价格保留两位小数且不能超过5位数';
    }
}