<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/14
 * Time: 11:21
 */

namespace app\common\service;

use app\common\logic\SellerLoginTel as SellerLoginTelLogic;

class SellerLoginTel extends Base
{
    /**
     * 商家端登录页客服逻辑类
     * @var SellerLoginTelLogic|null
     */
    protected $sellerLoginTelLogic = null;

    /**
     * 构造方法
     * SellerStaffLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerLoginTelLogic = new SellerLoginTelLogic();
    }

    /***
     * 商家登录页联系我们
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryContactPhone()
    {
        try{
            $phone = $this->sellerLoginTelLogic->queryContactPhone();
            list($this->status,$this->message,$this->data) = [1, '获取成功', $phone];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0, '获取失败'];
        }
    }
}