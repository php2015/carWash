<?php

namespace app\common\validate;
use think\Validate;
/**
 * user:陈鑫
 * 用户模块功能的验证器
 * Class UserValidate
 * @package app\common\validate
 */
class UserValidate extends Validate
{
    //定义验证规则
    protected $rule = [
        // 用户消息中心列表 || UserMessage => msgList
        'user_id|用户id' => 'require|number',
        'page|页数' =>  'number',
        // 资讯列表
        'class_id|资讯分类id' => 'number',
        //资讯详情
        'id|资讯详情id' =>  'require|number',
        // 用户卡列表
        'card_type|卡类型' =>  'require|number',//1.权益 2.次数
        'status|卡状态' =>  'require|number',//0.可使用 2.已失效
        // 用户卡详情
        'card_id|用户卡详情id' =>  'require|number',
        // 首页推荐商家端列表
        'lon|经度' => 'require|number',
        'lat|纬度' => 'require|number',
        //取消收藏
        'seller_id|商家id' => 'require',
        //搜索列表
        'keywords' => 'require',
        // 用户评价
        'comment_type' => 'require|number',
        'user_order_id' => 'require|number',
        'content' => 'require',
        // 用户定位
        'latitude|地名'  => 'require',
        // 切换区县
        'areaname|地区名称' =>  'require',
        'area_code|地区区号'    =>  'require|number',
    ];

    //定义验证提示
    protected $message = [
        // 用户消息中心列表
        'user_id.require' => '请传入用户id!',
        'user_id.number' => '用户id必须为数字!',
        'page.number' => '页数必须为数字!',
        // 资讯列表
        'class_id.number' => '资讯分类id必须为数字!',
        //资讯详情
        'id.require' => '请传入资讯id!',
        'id.number' => '资讯id必须为数字!',
        // 用户卡列表
        'card_type.require' => '请传入卡类型!',
        'card_type.number' => '卡类型必须为数字!',
        'status.require' => '请传入卡状态!',
        'status.number' => '卡状态必须为数字!',
        // 用户卡详情
        'card_id.require' => '请传入用户卡id!',
        'card_id.number' => '用户卡id必须为数字!',
        // 首页推荐商家端列表
        'lon.require' => '请传入经度!',
        'lon.number' => '经度必须为数字!',
        'lat.require' => '请传入纬度!',
        'lat.number' => '纬度必须为数字!',
        //取消收藏
        'seller_id.require' => '请传入商家id!',
        //搜索列表
        'keywords.require' => '请输入搜索词~',
        // 用户评价
        'comment_type.require' => '请传入评价类型!',
        'comment_type.number' => '评价类型必须为数字!',
        'user_order_id.require' => '请传入订单id!',
        'user_order_id.number' => '订单id必须为数字!',
        'content.require' => '请传入用户id!',
        // 用户定位
        'latitude.require'  => '请传入定位名称!',
        // 切换区县
        'areaname.require' => '请输入地区名称!',
        'area_code.require' => '请传入地区区号!',
        'area_code.number' => '地区区号必须为数字!',
        
    ];

    //定义验证场景
    protected $scene = [
        // 用户消息中心列表
        'msgList' => ['user_id','page'],
        // 资讯列表
        'newsList' => ['class_id','page'],
        //资讯详情
        'newsDetail' => ['id'],
        //用户卡列表
        'cardList'  =>  ['user_id','card_type','status','page'],
        // 用户卡详情
        'cardInfo'  =>  ['card_id'],
        // 首页推荐商家端列表
        'sellerList'     =>  ['lon','lat','page'],
        //我的收藏列表
        'myCollectList'     =>  ['lon','lat','page','user_id'],
        //取消收藏
        'removeCollect'     =>  ['user_id','seller_id'],
        //搜索列表
        'searchList'    =>  ['user_id','keywords','page','lon','lat'],
        // 用户评价
        'comment'     =>  ['comment_type', 'user_order_id', 'content'],
        // 消费订单详情
        'expdetail' =>  ['seller_id', 'user_order_id', 'lon', 'lat'],
        // 定位列表
        'locationList'  =>  ['user_id'],
        // 添加历史定位
        'locationHistory'   =>  ['user_id', 'latitude','area_code'],
        // 切换区县
        'switchArea'    =>  ['area_code'],
        // 搜索城市
        'searchCity'    =>  ['areaname'],
    ];
}
