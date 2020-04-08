<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/27
 * Time: 10:17
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\UserCardCenter as UserCardCenterService;
/***
 * 卡包中心
 * Class UserCardCenter
 * @package app\api\controller\v1
 */
class UserCardCenter extends Base
{
    /**
     * 卡包业务类
     * @var SellerService|null
     */
    protected $userCardCenterService = null;

    /***
     * 重写构造函数
     * UserCardCenter constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->userCardCenterService = new UserCardCenterService();
    }

    /***
     * 卡种类别列表
     * @param $card_type [1权益卡|2次数卡]
     */
    public function cardCategories()
    {
        $params = [
            'card_type' =>input('card_type/d',0),
            'paginate'  =>input('paginate/d',0),
        ];
        $this->userCardCenterService->cardCategories($params);
        list($this->status,$this->message,$this->data) = [
            $this->userCardCenterService->status,
            $this->userCardCenterService->message,
            $this->userCardCenterService->data,
        ];
    }
    /***
     * 查看卡详情|购买指定的卡
     * @param $card_id [卡id]
     * @param $card_type [卡类别,1权益卡|2次数卡]
     */
    public function getCardDetail()
    {
        $params = [
            'card_id' => input('id/d',0),
        ];
        $this->userCardCenterService->getCardDetail($params);
        list($this->status,$this->message,$this->data) = [
            $this->userCardCenterService->status,
            $this->userCardCenterService->message,
            $this->userCardCenterService->data,
        ];
    }

    /***
     * 用户购买卡
     * 当月剩余次数需要干掉
     */
    public function userBuyCard()
    {
        $params = [
            'user_id' => $this->uid,
            //'user_id'  =>input('user_id/d',0),
            'card_id' => input('id/d',0),
        ];
        $this->userCardCenterService->userBuyCard($params);
        list($this->status,$this->message,$this->data) = [
            $this->userCardCenterService->status,
            $this->userCardCenterService->message,
            $this->userCardCenterService->data,
        ];
    }

    /***
     *  查看我的订单列表
     */
    public function userMyOrder()
    {
        $params = [
            'user_id' => $this->uid,
            'paginate'=> input('paginate/d',1),
        ];
        $this->userCardCenterService->userMyOrder($params);
        list($this->status,$this->message,$this->data) = [
            $this->userCardCenterService->status,
            $this->userCardCenterService->message,
            $this->userCardCenterService->data,
        ];
    }

    /***
     * 查看我的订单详情
     */
    public function catMyOrderDetail()
    {
        $params = [
            'user_buycard_id'  =>input('id/d',0),
        ];
        $this->userCardCenterService->catMyOrderDetail($params);
        list($this->status,$this->message,$this->data) = [
            $this->userCardCenterService->status,
            $this->userCardCenterService->message,
            $this->userCardCenterService->data,
        ];
    }

    /***
     * 卡包使用说明
     */
    public function instructions()
    {
        $this->userCardCenterService->instructions();
        list($this->status,$this->message,$this->data) = [
            $this->userCardCenterService->status,
            $this->userCardCenterService->message,
            $this->userCardCenterService->data,
        ];
    }
}