<?php
namespace app\common\service;

use app\common\logic\SellerMessage as SellerMessageLogic;
use think\exception\DbException;

class SellerMessage extends Base{
    protected $SellerMessageLogic = null;

    public function __construct(){
        parent::__construct();
        $this->SellerMessageLogic = new SellerMessageLogic;
    }

    /**
     * 消息中心列表
     * @param seller_id 商家id
     * @param page 页数
     */
    public function msgList($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证商家id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->SellerMessageLogic->msgList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 首页轮循 消息中心 显示
     * @param seller_id 商家id
     */
    public function roundMessage($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证商家id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->SellerMessageLogic->roundMessage($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 所有的未读消息
     * @param seller_id 商家id
     */
    public function unreadMessage($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证商家id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->SellerMessageLogic->unreadMessage($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }
}