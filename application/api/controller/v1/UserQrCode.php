<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/28
 * Time: 20:56
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\UserQrCode as UserQrCodeService;

/***
 * 用户扫码结算接口
 * Class UserQrCode
 * @package app\api\controller\v1
 */
class UserQrCode extends Base
{
    /**
     * 扫一扫结算流程业务类
     * @var UserQrCodeService|null
     */
    protected $userQrCodeService = null;

    /***
     * 重写构造函数
     * SellerQrCode constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->userQrCodeService = new UserQrCodeService();
    }

    /***
     * 查询用户是否有权益卡或次卡
     */
    public function isOwnCard()
    {
        $params = [
            'user_id'=> $this->uid,
        ];
        $this->userQrCodeService->isOwnCard($params);
        list($this->status,$this->message,$this->data) = [
            $this->userQrCodeService->status,
            $this->userQrCodeService->message,
            $this->userQrCodeService->data,
        ];
    }
    /***
     * 用户端扫码获取商家信息
     */
    public function getBizInfo()
    {
        $params = [
            'qr_data' => input('qr_data','','trim'),
        ];
        $this->userQrCodeService->getBizInfo($params);
        list($this->status,$this->message,$this->data) = [
            $this->userQrCodeService->status,
            $this->userQrCodeService->message,
            $this->userQrCodeService->data,
        ];
    }

    /***
     * 用户端扫码获取商家审核通过的所有服务
     */
    public function getBizInUseService()
    {
        $params = [
            'qr_data' => input('qr_data','','trim'),
        ];
        $this->userQrCodeService->getAllInUseService($params);
        list($this->status,$this->message,$this->data) = [
            $this->userQrCodeService->status,
            $this->userQrCodeService->message,
            $this->userQrCodeService->data,
        ];
    }

    /***
     * 用户扫码获取当前用户所有的卡,列表显示用户当前拥有未过期的权益值/当月剩余次数大于0的次数卡
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSettlementCard()
    {
        $params = [
            'user_id'=> $this->uid,
        ];
        $this->userQrCodeService->getSettlementCard($params);
        list($this->status,$this->message,$this->data) = [
            $this->userQrCodeService->status,
            $this->userQrCodeService->message,
            $this->userQrCodeService->data,
        ];
    }

    /***
     * 用户结算服务,验证支付密码
     */
    public function validatePayPwd()
    {
        $params = [
            'user_id'=>$this->uid,
            'pay_pwd'=>input('password','','trim'),
        ];
        $this->userQrCodeService->validatePayPwd($params);
        list($this->status,$this->message,$this->data) = [
            $this->userQrCodeService->status,
            $this->userQrCodeService->message,
            $this->userQrCodeService->data,
        ];
    }

    /***
     * 发起支付
     */
    public function userPayMent()
    {
        $params = [
            'user_id'=>$this->uid,
            'card_id'=>input('card_id/d',0),                      //卡id
            'sellername'=>input('sellername','','trim'),          //商家名称
            'settlement_type' =>input('settlement_type/d',0),     //1权益卡,2次数卡
            'seller_service_id' => input('seller_service_id/d',0),//服务id
            'qr_data'=>input('qr_data',0),                        //二维码参数,seller_id,staff_id,token,时间戳
        ];
        $this->userQrCodeService->userPayMent($params);
        list($this->status,$this->message,$this->data) = [
            $this->userQrCodeService->status,
            $this->userQrCodeService->message,
            $this->userQrCodeService->data,
        ];
    }
}