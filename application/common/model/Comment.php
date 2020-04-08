<?php
/**
 * Created by Visual Studio Code.
 * User: chenxin
 * Date: 2018/9/30
 * Time: 15:08
 */
namespace app\common\model;
use think\Model;
use think\Db;

/***
 * 评价模型
 * Class Comment
 * @package app\common\model
 */
class Comment extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /**
     * 商家回复评价 
     * 1.写入商家回复评论表(dp_seller_comment)
     * @param content 评论内容
     * return 商家回复id seller_replay_id
     */
    public function addSellerComment($content)
    {
        $data = ['content' => $content, 'create_time' => time()];
        return Db::name('seller_comment')->insert($data);
    }

    /**
     * 商家回复评价 
     * 2.获取操作1的id填入对应的comment表的seller_replay_id
     * @param $params['user_order_id']  用户订单id
     * @param id 商家回复id
     */
    public function addSellerRlyid($params,$id)
    {
        return $this->where("user_order_id",$params["user_order_id"])->update(['seller_reply_id' => $id]);
    }

   /**
     * 商家回复评价 
     * 3.获取用户消息中心所需内容and拼接数据
     * @param $params['user_order_id']  用户订单id || content 商家回复内容
     */
    public function sellerRly($params)
    {
        $result = $this->alias('c')
            ->join('dp_user u','c.user_id = u.id')
            ->join('dp_seller s','c.seller_id = s.id')
            ->where('c.user_order_id ='.$params["user_order_id"])
            ->field('c.user_id,s.sellername')
            ->find();
        return $result ? $result : [];
    }

    /**
     * 商家回复评价
     * 4.写入到用户消息中心
     * @param msg 消息
     */
    public function sellerReply($msg)
    {
        return  Db::name('user_message')->insert($msg);
    }

    /**
     * 我的订单 获取订单单条评价
     * @param user_order_id 用户订单id
     */
    public function orderComment($params)
    {
        // 评价类容,评价等级,商家是否回复评价
        $result = $this->alias('c')
            ->join('dp_seller_comment sc','sc.id = c.seller_reply_id','left')
            ->where('c.is_release = 0 and c.user_order_id ='.$params["user_order_id"])
            ->field('c.comment_type,c.content,sc.id as replay_id')
            ->find();
        $data = ["comment_type" => 0, "content" => "", "replay_id"=> 0];
        return $result ? $result : $data;
    }

    /**
     * 商家端评价类型 数量
     * @param seller_id 商家id
     */
    public function commentsType($params)
    {
        $where = "is_release = 0 and seller_id=".$params["seller_id"];
        $data = [];
        // 总评价数
        $all = $this->where($where)->count();
        // 好评
        $good = $this->where($where." and comment_type = 3")->count();
        // 中评
        $normal = $this->where($where." and comment_type = 2")->count();
        // 差评
        $bad = $this->where($where." and comment_type = 1")->count();
        $data[] = ["all"=>$all,"good"=>$good,"normal"=>$normal,"bad"=>$bad];
        return $data ? collection((array)$data) : [];
    }

    /**
     * 评价列表
     * 查询商家的评价列表
     * @param seller_id 商家id
     * @param page 页数
     * @param type 查看评价类型 0全部 1差评 2一般 3好评
     */
    public function commentsList($params)
    {
        $params['page'] = $params['page'] ? $params['page'] : 1;
        $map["c.is_release"] = 0;
        if(!empty($params["type"])){//1差评,2一般,3好评,0全部
            $map["c.comment_type"] = $params["type"];
        }
        $result =  $this->alias('c')
        ->join('dp_seller_comment sc','c.seller_reply_id = sc.id','left')
        ->join('dp_user u','u.id = c.user_id','left')
        ->where('c.seller_id',$params["seller_id"])
        ->where($map)
        ->field('c.mobile,c.comment_type,c.content,c.create_time,sc.content as seller_content,u.head_img')
        ->order('c.create_time desc')
        ->page($params['page'],30)
        ->select();
        return $result ? $result : [];
    }

    /**
     * 写入用户评论
     * @param user_id 用户id
     * @param seller_id 商家id
     * @param user_order_id 订单id
     * @param mobile 用户手机号
     * @param seller_service_id 商家服务id
     * @param comment_type 评价类型(1差评,2一般,3好评)
     * @param content 评价内容
     * 
    */
    public function userComment($params)
    {
        // 写入进商家中心 消息表中
        $data = ['seller_id' => $params['seller_id'], 'seller_service_id' => $params['seller_service_id'],
            'title' => '用户评价', 'content' => $params['content'],
            'create_time' => time(), 'user_order_id' => $params['user_order_id'],
            'type' => 2
        ];
        Db::name('seller_message')->insert($data);
        // 写入评价表
        return $this->save($params);
    }

    /**
     * 修改用户评论成功后的订单评价状态
     * @param user_order_id 订单id
     */
    public function userCommentStatus($id)
    {
        $map['id'] = $id;
        return Db::name('user_order')->where($map)->update(['is_comment' => 1]);
    }

    /**
     * 获取单个用户的评论
     * @param user_order_id 订单id
     */
    public function userContent($id)
    {
        $map['c.user_order_id'] = $id;
        $field = 'u.head_img,c.mobile,c.create_time,c.content,c.comment_type,c.seller_reply_id';
        $result = $this->alias('c')
            ->join('dp_user u','c.user_id = u.id','left')
            ->where($map)
            ->field($field)
            ->find();
        return $result ? $result : "";
    }

    /**
     * 获取商家回复的评价
     * @param seller_reply_id 用户评价表的商家回复id
     */
    public function sellerContent($id)
    {
        $map['id'] = $id;
        $result = Db::name('seller_comment')->where($map)->field('content')->find();
        return $result ? $result : [];
    }

    /**
     * 商家评价数量
     */
    public function seller_comment_count($seller_id){
        $map['seller_id'] = $seller_id;     //商家id
        $map['is_release'] = 0;            //状态(0显示,1屏蔽)
        $result = $this
            ->where($map)
            ->count();
        return $result ? $result : 0;
    }
}