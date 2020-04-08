<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/10/22
 * Time: 10:06
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\UserOnlinePay as UserOnlinePayService;

/***
 * 用户在线购买服务/服务详情中直接购买
 * Class UserOnlinePay
 * @package app\api\controller\v1
 */
class UserOnlinePay extends Base
{
    /**
     * 用户在线购买服务业务类
     * @var UserOnlinePayService|null
     */
    protected $userOnlinePayService = null;

    /***
     * 重写构造函数
     * UserLogin constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->userOnlinePayService = new UserOnlinePayService();
    }

    /***
     * 在线购买服务
     */
    public function onlinePayMent()
    {
        $params = [
            'user_id'=>$this->uid,                                //用户id
            'card_id'=>input('card_id/d',0),                      //卡id,如果结算方式为权益卡,卡id为0
            'seller_id' =>input('seller_id/d',0),                 //商家id
            'sellername'=>input('sellername','','trim'),          //商家名称
            'settlement_type'   => input('settlement_type/d',0),  //结算方式1权益卡,2次数卡
            'seller_service_id' => input('seller_service_id/d',0),//服务id
        ];
        $this->userOnlinePayService->onlinePayMent($params);
        list($this->status,$this->message,$this->data) = [
            $this->userOnlinePayService->status,
            $this->userOnlinePayService->message,
            $this->userOnlinePayService->data,
        ];
    }

}