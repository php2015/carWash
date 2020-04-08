<?php
/**
 * 定义新增商家验证规则
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/8/31
 * Time: 19:08
 */
namespace app\carwash\validate;

use app\carwash\validate\Base;
use think\Validate;

class Seller extends Base
{
    //定义验证规则
    protected $rule = [
        'sellername|商家名称'       => 'require|max:20',
        'shopkeeper|店主姓名'       => 'require|max:20',
        'provinces_id|省份城市'     => 'require',
        'address|详细地址'          => 'require|max:50',
        'homepage_cate_parent_id|营业项目' => 'require',
        'start_time|开始营业时间' => 'require',
        'end_time|开始营业时间'   => 'require',
        'contactphone|联系电话'   => 'require|cphone|unique:seller',
        'vmphone|业务经理联系电话' => 'require|phone',
        //'fee|提现比例'            => 'require|vfee',
        'remark|备注'             => 'require|max:150',
        'is_review|状态'          => 'require',
        'seller_pic1|营业执照'    => 'require',
        'seller_pic2|店铺图片'    => 'require',
        'seller_pic3|店铺介绍图'  => 'require',
    ];

    //定义验证提示
    protected $message = [
        'sellername.require'    => '商家名称不能为空',
        'sellername.max'        => '商家名称最多不超过20个字',
        'shopkeeper.require'    => '店主姓名不能为空',
        'shopkeeper.max'        => '店主姓名最多不超过20个字',
        'provinces_id.require'  => '请选择所在省份',
        'address.require'       => '详细地址不能为空',
        'address.max'           => '详细地址最多不超过50个字',
        'homepage_cate_parent_id.require' => '营业项目不能为空',
        'start_time'            => '开始营业时间不能为空',
        'end_time'              => '结束营业时间不能为空',
        'contactphone.require'  => '联系电话不能为空',
        //'contactphone.unique'   => '电话号码已存在',
        'vmphone.require'       => '业务经理联系电话不能为空',
        //'fee.require'           => '提现比例不能为空',
        'remark.require'        => '备注不能为空',
        'remark.max'            => '备注最多不超过150个字',
        'is_review.require'     => '状态不能为空',
        'seller_pic1.require'   => '请上传营业执照',
        'seller_pic2.require'   => '请上传店铺图',
        'seller_pic3.require'   => '请上传店铺介绍图',
    ];

    //定义验证场景
    protected $scene = [
        'update' => ['sellername','shopkeeper','provinces_id','address','homepage_cate_parent_id','start_time','end_time','contactphone','vmphone','seller_pic1','seller_pic2','seller_pic3','remark','is_review'],//修改店铺信息
        'add' => ['sellername','shopkeeper','provinces_id','address','homepage_cate_parent_id','start_time','end_time','contactphone','vmphone','seller_pic1','seller_pic2','seller_pic3','remark','is_review'],
    ];

    //验证电话号码
    public function cphone($value, $rule, $data)
    {
        $preg = '/^13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57][0-9]{8}$/';
        return preg_match($preg, $value) ? true : "联系电话格式填写错误，请重新填写";
    }
    public function phone($value, $rule, $data)
    {
        $preg = '/^(0|86|17951)?(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/';
        return preg_match($preg, $value) ? true : "业务经理联系电话格式填写错误，请重新填写";
    }
    public function vfee($value,$rule,$data)
    {
        $preg = '/^([0].[0-9]{2})?$/';
        return preg_match($preg, $value) ? true : "提现比例请输入小于0的两位小数";
    }

}