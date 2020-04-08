<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/13
 * Time: 15:03
 */
namespace app\common\service;

use think\helper\Hash;
use app\common\util\Token;
use app\common\logic\SellerStaff as SellerStaffLogic;

/***
 * 商家员工业务类
 * Class SellerStaff
 * @package app\common\service
 */
class SellerStaff extends Base
{
    /**
     * 商家员工逻辑类
     * @var SellerStaffLogic|null
     */
    protected $sellerStaffLogic = null;

    /**
     * 构造方法
     * SellerStaffLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerStaffLogic = new SellerStaffLogic();
    }

    /***
     * 登录前验证
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function check(array $data)
    {
        //验证器验证手机号
        $validateCheck = validate('SellerStaff');
        if(!$validateCheck->check($data,[],'check')){
            $this->message = $validateCheck->getError();
            return;
        }
        try{
            //查询
            $sellerStaff = $this->sellerStaffLogic->getStaffMobile($data['mobile']);
            //如果为空则账号不存在
            if(empty($sellerStaff)){
                list($this->status,$this->message,$this->data) = [
                    1,
                    '账号不存在',
                    ['signin'=>2],
                ];
                return;
            }
            //是否被停用
            if($sellerStaff['is_disabled'] == 1){
                list($this->status,$this->message,$this->data) = [
                    1,
                    '该员工账号已停用',
                    ['signin'=>1],
                ];
                return;
            }
            list($this->status, $this->message, $this->data) = [
                    1,
                    '用户已启用',
                    ['signin' => 0],
            ];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0, '查询失败'];
        }
    }

    /***
     * 登录接口
     */
    public function login(array $data)
    {
        //登录验证
        $validate = validate('SellerStaff');
        if(!$validate->check($data,[],'login')){
            $this->message = $validate->getError();
            return;
        }
        try{
            //查询
            $sellerStaff = $this->sellerStaffLogic->getStaffMobile($data['mobile']);
            //如果为空则账号不存在
            if(empty($sellerStaff)){
                list($this->status,$this->message) = [0, '当前手机号未开通账号'];
                return;
            }
            //是否被停用
            if($sellerStaff['is_disabled'] == 1){
                list($this->status,$this->message) = [0, '该员工账号已停用'];
                return;
            }
            //验证密码
            if (!Hash::check((string)$data['password'], $sellerStaff['password'])) {
                list($this->status, $this->message) = [0, '密码输入错误'];
                return;
            }
            //商家下架之后是否允许登录
            $token = Token::makeToken($sellerStaff['id']);
            list($this->status, $this->message, $this->data) = [1, '登录成功', [
                'id'                 => $sellerStaff['id'],
                'seller_id'          => $sellerStaff['seller_id'],
                'seller_position_id' => $sellerStaff['seller_position_id'],
                'staffname'          => $sellerStaff['staffname'],
                'mobile'             => $sellerStaff['mobile'],
                'sellername'         => $sellerStaff['sellername'],
                'position'           => $sellerStaff['position'],
                'vmphone'            => $sellerStaff['vmphone'],
                'token'              => $token,
                'menu'               => getMenuList($sellerStaff['seller_position_id'],$sellerStaff['seller_id']),  //获取权限节点
            ]];
        }catch(\Exception $e){
            list($this->status,$this->message) =  [0,'登录失败'];
        }
    }
}