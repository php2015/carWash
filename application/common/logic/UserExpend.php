<?php
namespace app\common\logic;
use app\common\model\UserOrder as UserOrderModel;
use app\common\model\Comment as CommentModel;
use app\common\model\Seller as SellerModel;

class UserExpend extends Base{
    protected $UserOrderModel = null;
    protected $CommentModel = null;
    protected $SellerModel = null;

    public function __construct(){
        parent::__construct();
        $this->UserOrderModel = new UserOrderModel;
        $this->CommentModel = new CommentModel;
        $this->SellerModel = new SellerModel;
    }

    /**
     * 用户消费记录 列表
     * @param user_id 用户id
     * @param page 页数
     */
    public function expendList($params){
        $params['page'] = $params['page'] ? $params['page'] : 1;
        $result = $this->UserOrderModel->expendList($params);
        foreach($result as &$val){
            $val['seller_pic3'] = config('token.web_site_domain').get_file_path($val['seller_pic3']);
        }
        return $result;
    }

    /**
     * 用户评价商家
     * @param comment_type 评价类型
     * @param user_order_id 订单id
     * @param content 评价内容
     */
    public function comment($params)
    {
        // 1.通过订单id查询订单表 =>返回 用户id,商家id,用户手机号,商家服务id
        $data = $this->UserOrderModel->catOrderDetail($params['user_order_id']);
        $params['user_id'] = $data[0]['user_id'];//用户id
        $params['seller_id'] = $data[0]['seller_id'];//商家id
        $params['mobile'] = $data[0]['mobile'];//用户手机号
        $params['seller_service_id'] = $data[0]['seller_service_id'];//服务id
        // 2.写入评价表
        return $this->CommentModel->userComment($params);
    }

    /**
     * 消费订单详情
     * @param user_order_id 订单id
     * @param seller_id 商家id
     * @param lon 经度
     * @param lat 纬度
     */
    public function expdetail($params)
    {
        $result = [];
        $detail = "";//订单详情
        $distance = 0;//距离
        $sellerContent = "";//商家回复的评价
        // 1.获取商家的信息 通过经纬度 算出 距离
        $sellerInfo = $this->SellerModel->getBizDetail($params);
        if(!empty($sellerInfo['range'])){
            $distance = judgeDistance($sellerInfo['range']);
        }
        // 2.获取商家的评价数
        $comment_count = $this->CommentModel->seller_comment_count($params['seller_id']);
        // 3.获取订单详情
        $data = $this->UserOrderModel->catOrderDetail($params['user_order_id']);
        foreach($data as $val){
            $detail['goodsname'] = $val['goodsname'];//服务名称
            $detail['payprice'] = $val['payprice'];//支付金额
            $detail['order_number'] = $val['order_number'];//订单号
            $detail['create_time'] = $val['create_time'];//付款时间
            $detail['settlement_type'] = $val['settlement_type'];//付款方式
        }
        // 4.获取用户评价和商家回复评价
            //通过订单id 获取 用户评价内容
            $userContent = $this->CommentModel->userContent($params['user_order_id']);
            // 转换图片路径
            if(!empty($userContent['head_img'])){
                $userContent['head_img'] = config('token.web_site_domain').get_file_path($userContent['head_img']);
            }
            if(!empty($userContent['seller_reply_id'])){//获取商家回复的评价
                $content = $this->CommentModel->sellerContent($userContent['seller_reply_id']);
                $sellerContent = $content['content'];
            }
        $result = [
            'seller_info' => [
                'img' => config('token.web_site_domain').get_file_path($sellerInfo['seller_pic2']),
                'sellername' => $sellerInfo['sellername'],  'address'   => $sellerInfo['address'],
                'distance'=>$distance, 'comment_count'=>$comment_count],
                'detail'=>$detail,'userContent'=>$userContent, 'sellerContent'=>$sellerContent
        ];
        return $result;
    }




}