<?php
/**
 * 验证规则
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2018/8/31
 * Time: 19:08
 */
namespace app\carwash\validate;
 
use think\Validate;
 
class Consult extends Validate
{
    //定义验证规则
    protected $rule = [
        'name|分类名称'       => 'require|max:20',
        'title|资讯标题'       => 'require|max:20',
        'order_num|资讯排序'       => 'between:1,100',
        'information_cate_id|分类'     => 'require',
        'source|来源'          => 'require|max:20',
        'icon|封面图' => 'require|number',
        'detail|详情' => 'require',
        'order_num|排序'   => 'require',
        'location|图片位置'       => 'require',
        'adname|图片名称'       => 'require|max:20',
        'homepage_carouselcate_id|图片分类'          => 'require',
        'picture|封面图' => 'require|number',
        // 财务管理 提现比例
        // 'amount|最少提现金额'          => 'require|number|between:1,100000',
        'fee|手续费比例' => 'require|number|between:1,100',
        'img|封面图' => 'require|number',
        // 地域配置
        'areaname'  =>  'require|max:20',
        // 客服
        'phone'     =>  'require|number|length:6,11',
        // 广告管理内联的验证
        'type'  =>  'require',
        'info_id'  =>  'require',
    ];
 
    //定义验证提示
    protected $message = [
        'name.require'    => '名称不能为空',
        'name.max'        => '名称最多不超过20个字',
        'order_num.between'    => '资讯排序必填!',
        'title.require'    => '资讯标题不能为空',
        'title.max'         => '资讯名称最多不超过20个字',
        'information_cate_id.require'    => '资讯分类不能为空',
        'source.require'    => '来源不能为空',
        'source.max'    => '来源最多不超过20个字',
        'icon.number'    => '封面图不能为空',
        'img.number'    => '封面图不能为空',
        'detail.require'    => '详情不能为空',
        'order_num.require'    => '排序不能为空',
        'location.require'    => '图片位置不能为空',
        'adname.require'    => '图片名称不能为空',
        'adname.max'         => '图片名称最多不超过20个字',
        'homepage_carouselcate_id.require'    => '图片分类不能为空',
        'picture.number'    => '封面图不能为空',
        // 财务管理 提现比例
        // 'amount.require'    => '最少提现金额不能为空!',
        // 'amount.number'    => '最少提现金额必须为数字!',
        // 'amount.between'    => '最少提现金额范围只能在1块 到 10万之间!',
        'fee.require'    => '手续费比例不能为空!',
        'fee.number'    => '手续费比例必须为数字!',
        'fee.between'  => '手续费比例范围只能在1%-100%之间',
        // 地域配置
        'areaname.require'    => '名称不能为空',
        'areaname.max'        => '名称最多不超过20个字',
        // 客服
        'phone.require'    => '电话不能为空!',
        'phone.number'    => '电话必须为数字!',
        'phone.length'    => '电话请在6位到11位数字之间!',
        // 广告管理内联的验证
        'type.require'  =>  '请选择类型',
        'info_id.require'  =>  '请选择具体信息',
    ];
    
    // 
    protected $scene = [
        'classify'  =>  ['name'],//验证分类
        'consult'   =>  ['title','information_cate_id','source','icon','detail','order_num'],//资讯管理的验证
        'advert'    =>  ['location','adname','homepage_carouselcate_id','picture','order_num'],//广告管理的验证
        'finance'   =>  ['amount','fee'],//财务管理 提现比例配置
        'bank_card' =>  ['name','img'],//财务管理 银行卡管理
        'city'      =>  ['areaname','area_code'],//地域配置
        'service'   =>  ['name','phone'],//客服
        'advert_inner'  =>  ['location','adname','homepage_carouselcate_id','picture','order_num','type','info_id'],//内联广告的验证
    ];
 
}