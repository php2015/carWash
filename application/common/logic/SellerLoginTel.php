<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/14
 * Time: 11:21
 */

namespace app\common\logic;

use app\common\model\Contactus as ContactusModel;

class SellerLoginTel extends Base
{
    /***
     * 联系我们 模型
     * @var null
     */
    protected $contactusModel = null;
    /**
     * 构造方法
     * SellerStaffModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->contactusModel = new ContactusModel();
    }

    /***
     * 查询后台联系我们电话
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryContactPhone()
    {
        return $this->contactusModel->queryContactPhone();
    }
}