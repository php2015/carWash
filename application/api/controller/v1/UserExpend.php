<?php
/**
 * 陈鑫 Visual Studio
 */
namespace app\api\controller\v1;
use app\api\controller\Base;
use think\Request;
use app\common\service\UserExpend as UserExpendService;
/**
 * 用户消费记录模块接口类
 * Class UserExpend
 * @package app\api\controller\v1
 */
class UserExpend extends Base
{
    protected $UserExpendService = null;

    function __construct(Request $request = null){
        $this->UserExpendService = new UserExpendService;
        parent::__construct($request);
    }

    /**
     * 用户消费记录 列表
     * @param user_id 用户id
     * @param page 页数
     */
    public function expendList()
    {
        $params = [
            'user_id' => $this->uid,
            'page'  =>  input('page', '', 'trim'),
        ];
        $this->UserExpendService->expendList($params);
        list($this->status, $this->message, $this->data) = [$this->UserExpendService->status, $this->UserExpendService->message, $this->UserExpendService->data];
    }

    /**
     * 用户评价商家
     * @param comment_type 评价类型
     * @param user_order_id 订单id
     * @param content 评价内容
     */
    public function comment()
    {
        $params = [
            'comment_type'  =>  input('comment_type', '', 'trim'),
            'user_order_id'  =>  input('user_order_id', '', 'trim'),
            'content'  =>  input('content', '', 'trim'),
        ];
        $this->UserExpendService->comment($params);
        list($this->status, $this->message, $this->data) = [$this->UserExpendService->status, $this->UserExpendService->message, $this->UserExpendService->data];
    }

    /**
     * 消费订单详情
     * @param user_order_id 订单id
     * @param seller_id 商家id
     * @param lon 经度
     * @param lat 纬度
     */
    public function expdetail()
    {
        $params = [
            'seller_id'  =>  input('seller_id', '', 'trim'),
            'user_order_id'  =>  input('user_order_id', '', 'trim'),
            'lon' => input('lon', '', 'trim'),//经度
            'lat' => input('lat', '', 'trim'),//纬度
        ];
        $this->UserExpendService->expdetail($params);
        list($this->status, $this->message, $this->data) = [$this->UserExpendService->status, $this->UserExpendService->message, $this->UserExpendService->data];
    }

}