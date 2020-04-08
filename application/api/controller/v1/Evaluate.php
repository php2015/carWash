<?php
/**
 * 陈鑫 Visual Studio
 */
namespace app\api\controller\v1;
use think\helper\Hash;
use app\api\controller\Base;
use think\Request;
use app\common\service\Evaluate as EvaluateService;
/**
 * 评价模块接口类
 * Class Evaluate
 * @package app\api\controller\v1
 */
class Evaluate extends Base
{
    protected $EvaluateService = null;

    function __construct(Request $request = null){
        $this->EvaluateService = new EvaluateService;
        parent::__construct($request);
    }

    /**
     * 商家端评价列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @param seller_id 商家id
     * @param page 页数
     * @param type 查看评价类型 0全部 1差评 2一般 3好评
     */
    public function commentsList()
    {
        $params = [
            'seller_id' => $this->sellerid,
            'page' => input('page', '', 'trim'),
            'type' => input('type', '', 'trim'),
        ];
        $this->EvaluateService->commentsList($params);
        list($this->status, $this->message, $this->data) = [$this->EvaluateService->status, $this->EvaluateService->message, $this->EvaluateService->data];
    }

    /**
     * 商家端评价类型 数量
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @param seller_id 商家id
     */
    public function commentsType()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->EvaluateService->commentsType($params);
        list($this->status, $this->message, $this->data) = [$this->EvaluateService->status, $this->EvaluateService->message, $this->EvaluateService->data];
    }

    /**
     * 我的订单 获取订单单条评价
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @param user_order_id 用户订单id
     */
    public function orderComment()
    {
        $params = [
            'user_order_id' => input('user_order_id', '', 'trim'),
        ];
        $this->EvaluateService->orderComment($params);
        list($this->status, $this->message, $this->data) = [$this->EvaluateService->status, $this->EvaluateService->message, $this->EvaluateService->data];
    }

    /**
     * 商家回复评价
     * @param user_order_id 用户订单id
     * @param content 商家回复内容
     */
    public function sellerReply()
    {
        $params = [
            'user_order_id' => input('user_order_id', '', 'trim'),
            'content' => input('content', '', 'trim'),
        ];
        $this->EvaluateService->sellerReply($params);
        list($this->status, $this->message, $this->data) = [$this->EvaluateService->status, $this->EvaluateService->message, $this->EvaluateService->data];
    }

    /**
     * 用户评价列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @param seller_id 商家id
     * @param page 页数
     * @param type 查看评价类型 0全部 1差评 2一般 3好评
     */
    public function userComList()
    {
        $params = [
            'seller_id' => input('sellerid', '', 'trim'),
            'page' => input('page', '', 'trim'),
            'type' => input('type', '', 'trim'),
        ];
        $this->EvaluateService->commentsList($params);
        list($this->status, $this->message, $this->data) = [$this->EvaluateService->status, $this->EvaluateService->message, $this->EvaluateService->data];
    }


}