<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/13
 * Time: 14:05
 */
namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\SellerStaff as SellerStaffService;


/**
 * 商家登录控制器
 * Class Login
 * @package app\api\controller\v1
 * @author
 */
class SellerLogin extends Base
{
    /**
     * 商家登录业务类
     *
     * @var sellerStaffService|null
     */
    protected $sellerStaffService = null;

    /***
     * 重写构造函数
     * SellerLogin constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->sellerStaffService = new SellerStaffService();
    }

    /***
     * [signin] [0启用,1停用,2不存在]
     * 登录验证
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function check()
    {
        $params = [
            'mobile' => input('mobile', '', 'trim'),
        ];
        $this->sellerStaffService->check($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerStaffService->status,
            $this->sellerStaffService->message,
            $this->sellerStaffService->data,
        ];
    }

    /***
     * 登录 | 密码登录
     */
    public function signin()
    {
        $params = [
            'mobile' => input('mobile', '', 'trim'),
            'password' => input('password', '', 'trim'),
        ];
        $this->sellerStaffService->login($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerStaffService->status,
            $this->sellerStaffService->message,
            $this->sellerStaffService->data,
        ];
    }
}