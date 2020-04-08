<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/13
 * Time: 15:16
 */

namespace app\common\logic;

use app\common\model\SellerStaff as SellerStaffModel;


class SellerStaff extends Base
{
    /**
     * 商户模型
     * @var SellerStaffModel|null
     */
    protected $sellerStaffModel = null;

    /**
     * 构造方法
     * SellerStaffModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerStaffModel = new SellerStaffModel();
    }

    /***
     * 查询手机号是否存在
     * @param $mobile
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStaffMobile($mobile)
    {
        return $this->sellerStaffModel->getStaffMobile($mobile);
    }

    /***
     * 查询店主id
     * @param $sellerId
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStaffId($sellerId)
    {
        return $this->sellerStaffModel->getStaffId($sellerId);
    }
}