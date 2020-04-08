<?php

namespace app\carwash\model;

use think\helper\Hash;
use think\Model;
use think\Db;

/**
 * 用户模型
 * Class AppUser
 * @package app\carwash\model
 * @author 陈鑫 
 * @property integer id 用户id
 * @property string nickname 用户名
 * @property string mobile 手机号码
 * @property string sex 性别
 * @property integer birthday 生日
 * @property integer create_time 注册时间
 */
class User extends Model
{
    /**
     * @var bool 自动写入时间戳
     */
    protected $autoWriteTimestamp = true;

    /**
     * 用户列表 || 权益卡和次数卡显示购买历史总数 || 1块钱 = 1积分
     * @param $map  搜索条件
     * 用户id 用户名称
     */
    public function userList($map){
        // 用户表,用户卡表,平台卡表
        return Db::table('dp_user')
                ->where($map)
                ->paginate()
                ->each(function($item, $key){
                    // 区分权益卡和次数卡类型 || 1.权益 2.次数
                    // 获取该用户的总权益卡和次数卡
                    $item["equity_card"] = Db::name('user_buycard')->where('user_id='.$item['id'].' and card_type=1')->count().'张';
                    $item["times_card"] = Db::name('user_buycard')->where('user_id='.$item['id'].' and card_type=2')->count().'张';
                    return $item;
                });
    }

    /**
     * 用户购买记录
     *  @param $map  搜索条件
     *  用户id 用户名称
     */
    public function buyHistory($map){
        // 用户表,用户卡表,平台卡表
        return Db::table('dp_user_buycard')
                ->alias('ub')
                ->join('dp_user u','u.id = ub.user_id','left')
                ->join('dp_platform_card pc','ub.platform_card_id = pc.id','left')
                ->join('dp_user_card uc','uc.id = ub.user_card_id','left')
                ->where($map)
                ->field('ub.*,u.nickname,pc.cardname,pc.cash_pay_value,uc.card_number')
                ->paginate();
    }

    /**
     * 查看卡种
     * @param $map  搜索条件
     * 卡号,卡种名称
     * */ 
    public function viewCards($map){
        return Db::table('dp_user_card')
                ->alias('uc')
                ->join('dp_platform_card pc','uc.platform_card_id = pc.id','left')
                ->join('dp_user u','uc.user_id = u.id','left')
                ->where($map)
                ->field('u.nickname,uc.*,pc.*,uc.create_time as buy_time,uc.id as user_card_id')
                ->paginate()->each(function($item, $key){
                    $item["period"] = $item["period"]."天";
                    // 区分权益卡和次数卡类型 || 1.权益 2.次数
                    if($item["card_type"] == 1){
                        $item["total_value"] = $item["total_value"]."权益值";
                        $item["balance_value"] = $item["balance_value"]."权益值";
                    }else if($item["card_type"] == 2){
                        $item["total_value"] = $item["total_value"]."次";
                        $item["balance_value"] = $item["balance_value"]."次";
                        //获取次数卡剩余次数 = 用平台卡单月可使用次数 - 当月已使用次数
                        // 1.通过用户id获取 当月 已使用次数
                        $map = "user_id=".$item["user_id"]." and user_card_id =".$item['user_card_id']." and (create_time >=".strtotime(date('Y-m-01'))." and create_time <=".strtotime(date('Y-m-t 23:59:59')).")";
                        $used_count = Db::name('user_card_statement')->where($map)->count();
                        $item["surplus_value"] = $item['monthly_times'] - $used_count."次";
                        // 2.如果剩余次数 > 余额次数,则使用余额次数
                        if(Rtrim($item["surplus_value"],'次') > Rtrim($item["balance_value"],'次')){
                            $item["surplus_value"] = $item["balance_value"];
                        }
                    }
                    return $item;
                });
    }

    /**
     * 导出用户数据
     */
    public function userExcel(){
        return Db::table('dp_user')
                ->alias('u')
                ->join('dp_user_buycard ub','u.id = ub.user_id','left')
                ->field('u.*,ub.card_type,ub.buy_price')
                ->select();
    }

}
