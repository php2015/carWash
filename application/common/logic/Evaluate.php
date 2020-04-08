<?php
/**
 * Created by Visual Studio Code.
 * User: chenxin
 * Date: 2018/9/30
 * Time: 15:08
 */
namespace app\common\logic;
use think\Db;
use app\common\model\Comment as CommentModel;

class Evaluate extends Base{
    protected $CommentModel = null;

    public function __construct(){
        parent::__construct();
        $this->CommentModel = new CommentModel;
    }

    /**
     * 评价列表
     */
    public function commentsList($params)
    {
        $data = [];
        $result = $this->CommentModel->commentsList($params);// 评价列表
        if(!empty($result)){
            foreach($result as &$val){
                if($val['seller_content'] == null){
                    $val['seller_content'] = "";
                }
                $val['head_img'] = config('token.web_site_domain').get_file_path($val['head_img']);
                $val["mobile"] = substr($val["mobile"], 0, 3).'****'.substr($val["mobile"], 7);
                $data["comment_list"][] = $val;
            }
        }else{
            $data["comment_list"] = [];
        }
        //评价类型数量
        $commentsType = $this->CommentModel->commentsType($params);
        foreach($commentsType as $val){
            $data["all"] = $val["all"];
            $data["good"] = $val["good"];
            $data["normal"] = $val["normal"];
            $data["bad"] = $val["bad"];
        }
        return $data;
    }

    /**
     * 商家端评价类型 数量
     * @param seller_id 商家id
     */
    public function commentsType($params)
    {
        return $this->CommentModel->commentsType($params);
    }

    /**
     * 我的订单 获取订单单条评价
     * @param user_order_id 用户订单id
     */
    public function orderComment($params)
    {
        return $this->CommentModel->orderComment($params);
    }

     /**
     * 商家回复评价
     * @param user_order_id 用户订单id
     * @param content 商家回复内容
     */
    public function sellerReply($params)
    {
        // 1.写入商家回复评论表(dp_seller_comment)
        try{
            $this->CommentModel->addSellerComment($params['content']);
            $seller_comment_id = Db::name('seller_comment')->getLastInsID();
        }catch(\Exception $e){
            return 0;
        }
        // 2.获取操作1的id填入对应的comment表的seller_replay_id
        try{
            $this->CommentModel->addSellerRlyid($params,$seller_comment_id);
        }catch(\Exception $e){
            return 0;
        }
        // 3.获取用户消息中心所需内容and拼接数据
        $result = $this->CommentModel->sellerRly($params);
        if(!empty($result)){
            $msg = [
                'title'=>'['.$result['sellername'].']回复了您的评价','content' => $params['content'],
                'create_time' => time(),'message_type' => 1,
                'user_id'   =>  $result['user_id'], 'user_order_id' =>  $params['user_order_id']
            ];
        }else{
            return 0;
        }
        // 4.写入到用户消息中心
        try{
            $this->CommentModel->sellerReply($msg);
            return 1;
        }catch(\Exception $e){
            return 0;
        }
    }

}