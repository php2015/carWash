<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/17
 * Time: 19:02
 */

namespace app\common\validate;

use think\Validate;

/***
 * 商家验证器
 * Class Store
 * @package app\common\validate
 */
class Store extends Validate
{

    //定义验证规则
    protected $rule = [
        'seller_id|商家id'        => 'require',
        'start_time|开始营业时间'  => 'require',
        'end_time|结束营业时间'    => 'require',
        'seller_pic2|店铺图片'     => 'require|checkSellerPic',
        'seller_pic3|店铺介绍图片' => 'require',
        'shopkeeper|店主姓名'            =>'require|max:17',
        'contactphone|手机号码'          =>'require|cphone|unique:seller',
        'sellername|商户名称'            =>'require|max:20',
        'provinces_id|省份城市'          =>'require|gt:0',
        'address|详细地址'               =>'require|max:20',
        'homepage_cate_parent_id|营业项目'=>'require',
        'seller_pic1|营业执照'           =>'require',

    ];
    //定义验证提示
    protected $message = [
        'seller_id.require'  => '参数缺失',
        'start_time.require' => '请输入开始营业时间',
        'end_time.require'   => '请输入结束营业时间',
        'seller_pic2.require' => '请选择店铺图片',
        'seller_pic3.require' => '请选择店铺介绍图片',
        'shopkeeper.require'  => '店主姓名不能为空',
        'shopkeeper.max'      => '店主姓名最多输入17字',
        'contactphone.require'=> '联系电话不能为空',
        'contactphone.unique' => '电话号码已存在',
        'sellername.require'  => '店铺名不能为空',
        'sellername.max'      => '店铺名最多输入20字',
        'provinces_id.require'=> '请选择省份城市',
        'provinces_id.gt'     => '请选择省份城市',
        'address.require'     => '详细地址不能为空',
        'homepage_cate_parent_id.require' => '请选择营业项目',
        'seller_pic1.require' => '请上传营业执照',
    ];

    //定义验证场景
    protected $scene = [
        'update' => ['seller_id','start_time','end_time','seller_pic2','seller_pic3'],//修改店铺信息
        'apply' => ['shopkeeper','contactphone','sellername','provinces_id','address','homepage_cate_parent_id','seller_pic1'],//商家入驻
    ];

    /***
     * 验证店铺图片
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     */
    public function checkSellerPic($value, $rule, $data)
    {
        $sellerPic2 = explode(',',$value);
        return count($sellerPic2) == 3 ?  true : '您需要上传三张店铺图片';
    }
    //验证电话号码
    public function cphone($value, $rule, $data)
    {
        $preg = '/^13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57][0-9]{8}$/';
        return preg_match($preg, $value) ? true : "联系电话格式填写错误,请重新填写";
    }
}