<?php
/**
 * 陈鑫 Visual Studio
 */
namespace app\api\controller\v1;
use app\api\controller\Base;
use think\Request;
use app\common\service\SellerMessage as SellerMessageService;
/**
 * 消息中心模块接口类
 * Class SellerMessage
 * @package app\api\controller\v1
 */
class SellerMessage extends Base
{
    protected $SellerMessageService = null;

    function __construct(Request $request = null){
        $this->SellerMessageService = new SellerMessageService;
        parent::__construct($request);
    }

    /**
     * 消息中心列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @param seller_id 商家id
     * @param page 页数
     */
    public function msgList()
    {
        $params = [
            'seller_id' => $this->sellerid,
            'page' => input('page', '', 'trim'),
        ];
        $this->SellerMessageService->msgList($params);
        list($this->status, $this->message, $this->data) = [$this->SellerMessageService->status, $this->SellerMessageService->message, $this->SellerMessageService->data];
    }

    /**
     * 首页轮循 消息中心 显示
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @param seller_id 商家id
     */
    public function roundMessage()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->SellerMessageService->roundMessage($params);
        list($this->status, $this->message, $this->data) = [$this->SellerMessageService->status, $this->SellerMessageService->message, $this->SellerMessageService->data];
    }

    /**
     * 所有的未读消息
     * @param seller_id 商家id
     */
    public function unreadMessage()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->SellerMessageService->unreadMessage($params);
        list($this->status, $this->message, $this->data) = [$this->SellerMessageService->status, $this->SellerMessageService->message, $this->SellerMessageService->data];
    }

}