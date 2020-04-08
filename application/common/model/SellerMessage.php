<?php
namespace app\common\model;
use think\exception\DbException;
use think\Model;
use think\Db;

/***
 * Class SellerMessage
 * @package app\common\model
 * @property integer id            商家消息id
 * @property integer seller_id     商家id
 * @property integer seller_service_id 服务id
 * @property string  sellername    商家名称
 * @property string  servicename   服务名称
 * @property string  title         消息标题
 * @property string  content       消息内容
 * @property integer is_read       是否已读[0未读|1已读]
 * @property integer user_order_id 用户订单id
 * @property integer type          消息类型[1代表提现类型,10发起提现,11提现到账,12提现驳回|2代表用户评论|3代表订单通知|4代表审核,40代表审核待处理,41代表审核通过,42审核驳回]
 */
class SellerMessage extends Model{

    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 新增商家消息通知
     * @param $sellMessage
     * @return false|int
     */
    public function addSellerMessage($sellMessage)
    {
        return $this->save($sellMessage);
    }
    /**
     * 消息列表
     * 查询商家的评价列表
     * @param seller_id 商家id
     * @param page 页数
     */
    public function msgList($params)
    {
        $page = $params["page"] ? $params["page"] : 1;
        $map["seller_id"] = $params["seller_id"];
        // 1. 更新请求的条数为已读内容
        Db::execute("update dp_seller_message set is_read=:status",['status'=>1]);
        // 2. 返回请求的条数信息
        $result =  $this->where($map)
        ->field('title,content,create_time,user_order_id,type')
        ->order('create_time desc')
        ->page($page,10)
        ->select();
        return $result ? $result : [];
    }

    /**
     * 首页轮循 消息中心 显示
     * @param seller_id 商家id
     */
    public function roundMessage($params)
    {
        $map["seller_id"] = $params["seller_id"];
        $map["is_read"] = 0;
        $map["type"] = 3;//订单类型
        $result =  $this->where($map)
            ->field("create_time,servicename")
            ->select();
        return $result ? $result : [];
    }

    /**
     * 所有的未读消息
     */
    public function unreadMessage($params)
    {
        $map["seller_id"] = $params["seller_id"];
        $map["is_read"] = 0;
        $result =  $this->where($map)
            ->field("id")
            ->select();
        return $result ? $result : [];
    }
    

}