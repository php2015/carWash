<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/7
 * Time: 20:50
 */

namespace app\carwash\validate;


class SellerCashAccount extends Base
{
    //定义验证规则
    protected $rule = [
        'seller_id|商户名称'     => 'require',
        'account_name|收款人姓名'=> 'require',
        'account|提现账号'       => 'require',
        'status|状态'           => 'require',
    ];

    //定义验证提示
    protected $message = [
        'seller_id.require'     =>'请选择商户',
        'account_name.require'  =>'请输入收款人姓名',
        'account.require'       =>'请输入提现账号',
        'status.require'        =>'请选择状态',

    ];

    /***
     * lum法 验证银行卡
     * @param $no
     * @param $rule
     * @param $data
     * @return bool|string
     */
    public function validateBankNum($no, $rule, $data)
    {
        $arr_no = str_split($no);
        $last_n = $arr_no[count($arr_no)-1];
        krsort($arr_no);
        $i = 1;
        $total = 0;
        foreach ($arr_no as $n){
            if($i%2==0){
                $ix = $n*2;
                if($ix>=10){
                    $nx = 1 + ($ix % 10);
                    $total += $nx;
                }else{
                    $total += $ix;
                }
            }else{
                $total += $n;
            }
            $i++;
        }
        $total -= $last_n;
        $x = 10 - ($total % 10);
        if($x == $last_n){
            return true;
        } else {
            return '请输入正确的银行卡号';
        }
    }

    /***
     * 验证身份证号码
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     */
    public function validateIdCard($value,$rule,$data)
    {
        $preg = '/^\d{15}|\d{18}$/';
        return preg_match($preg, $value) ? true : "请输入正确的身份证号码";
    }

    /***
     * 验证手机号码
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     */
    public function cphone($value, $rule, $data)
    {
        $preg = '/^(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/';
        return preg_match($preg, $value) ? true : "提现手机号码格式填写错误，请重新填写";
    }
}