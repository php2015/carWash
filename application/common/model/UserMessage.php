<?php
namespace app\common\model;
use think\exception\DbException;
use think\Model;
use think\Db;
class UserMessage extends Model{

    protected $autoWriteTimestamp  = true; // 自动写入时间戳
    /**
     * 功能:查询该用户是否有即将过期的卡
     * 1.查询该用户是否 还剩15天即将过期或已过期 的权益卡和次数卡 || 
     * @param user_id 用户id
     * @param type 判断是查询剩余还是过期 || type='' =>即将过期|type='past' =>查询过期的卡
     */
    public function pastCardSearch($user_id,$type = '')
    {
        $map["uc.user_id"] = $user_id;
        if($type != 'past'){//剩余15天的
            $map["uc.status"] = 0;//0正常消费 1消费完毕 2已过期
            $map["uc.expire_time"] = ['>',time()];
            $map["uc.expire_time"] = ['<=',strtotime('+15 day')];//过期时间小等于 当前时间后的15天,则需要 写入进用户消息中心
        }else{//过期的
            $map["uc.status"] = ['>',0];
            $map["uc.expire_time"] = ['<',time()];//小等于当前时间被认为已过期
        }
        $result = Db::name('user_card')->alias('uc')
            ->join('dp_platform_card pc','uc.platform_card_id = pc.id')
            ->where($map)
            ->field('pc.card_type,uc.id as user_card_id,uc.card_number,uc.user_id,uc.expire_time')
            ->select();
        return $result ? $result : [];
    }

    /**
     * 功能:查询该用户是否有即将过期或已过期的卡  
     * 2.用户消息中心 查询该用户所有卡的id(单独剥离,方便后面直接调用)
     * @param user_id 用户id
     * @param type 判断是查询剩余还是过期 type=2 即将过期||type=4 已过期
     */
    public function setCardSearch($user_id,$type = 2)
    {
        $map["user_id"] = $user_id;
        $map['message_type']  = ['like',"%$type%"];
        $result = $this
            ->where($map)
            ->field('user_card_id')
            ->select();
        return $result ? $result : [];
    }

    /**
     * 功能:查询该用户是否有即将过期的卡
     * 3.如果用户消息中心没有当前的用户卡id 则把提示快过期或快过期 写入到用户消息中心
     * @param card_type 卡类型
     * @param user_card_id 用户卡id
     * @param user_id 用户id
     * @param title 标题
     * @param content 内容
     */
    public function addpsCardMsg($params)
    {
        //写入到用户消息表
        $data = [
            'title'=>$params['title'],'content'=>$params['content'],
            'message_type' => $params['message_type'],'user_card_id'=>$params['user_card_id'],
            'user_id'=>$params['user_id'],'create_time'=>time()
        ];
        return $this->insert($data);
    }

    /**
     * 用户消息列表
     * @param user_id 用户id
     * @param limit 一页行数
     * @param page 页数
     */
    public function msgList($params)
    {
        $map["m.user_id"] = $params["user_id"];
        $result = $this->alias('m')
            ->join('dp_user_order uo','uo.id  = m.user_order_id','left')
            ->where($map)
            ->order('id desc')
            ->field('m.id,m.title,m.content,m.create_time,m.message_type,m.user_order_id,uo.seller_id')
            ->page($params['page'],$params['limit'])
            ->select();
        return $result ? $result : [];
    }

    /***
     * 新增用户扣款通知
     * @param $userMessage
     * @return false|int
     */
    public function addUserMessage($userMessage)
    {
        return $this->save($userMessage);
    }

    /**
     * 获取用户消息中心未读的消息个数
     * @param user_id
     */
    public function unreadMsg($user_id)
    {
        $map['user_id'] = $user_id;
        $map['is_read'] = 0;
        $result = $this->where($map)->count();
        return $result ? $result : 0;
    }

    /**
     * 修改消息状态为已读
     * @param user_id 用户id
     */
    public function editMsgStatus($user_id)
    {
        return $this->where('user_id',$user_id)->update(['is_read' => 1]);
    }
}