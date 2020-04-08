<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/18
 * Time: 14:33
 */

namespace app\common\validate;

use think\Validate;
class SellerService extends Validate
{
    //定义验证规则
    protected $rule = [
        'seller_id|商家id'             => 'require',
        'homepage_cate_parent_id|营业项目'=>'require',
        'homepage_cate_id|营业级别' => 'require|gt:0',
        'servicename|服务名称'      => 'require|max:10',
        'serviceprice|服务价格'     => 'require|decimal',
        'remark|服务详情'           => 'require|max:50',
        'is_timescard|是否支持次卡' =>'require',

    ];
    //定义验证提示
    protected $message = [
        'seller_id.require'               => '参数缺失',
        'homepage_cate_parent_id.require' => '请选择服务类别',
        'homepage_cate_id.require'        => '请选择服务级别',
        'homepage_cate_id.gt'             => '暂无服务级别,不可添加',
        'servicename.require'             => '请填写服务名称',
        'servicename.max'                 => '服务名称最多输入10个字',
        'serviceprice.require'            => '请填写服务价格',
        'remark.require'                  => '请填写服务详情',
        'remark.max'                      => '服务详情最多输入50个字',
        'is_timescard.require'            => '请选择是否支持次卡',
    ];

    //定义验证场景
    protected $scene = [
        'addService' => ['seller_id','homepage_cate_parent_id','homepage_cate_id','servicename','serviceprice','remark','is_timescard'],
    ];

    /***
     * 验证金额
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     */
    public function decimal($value, $rule, $data) {
        $reg = '/^[0-9]+(.[0-9]{1,2})?$/';//整数或者2位小数
        $res = preg_match($reg, $value);
        return $res ? true : '金额类请输入两位小数';
    }
}