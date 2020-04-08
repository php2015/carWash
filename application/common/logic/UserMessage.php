<?php
namespace app\common\logic;
use app\common\model\UserMessage as UserMessageModel;

class UserMessage extends Base{
    protected $UserMessageModel = null;

    public function __construct(){
        parent::__construct();
        $this->UserMessageModel = new UserMessageModel;
    }

    /**
     * 用户消息中心列表
     * @param user_id 用户id
     * @param page 页数
     */
    public function msgList($params)
    {
    //------------------------------------查询该用户是否有剩余15天即将过期的卡------------------------------//
        //1.查询该用户是否 还剩15天可用的权益卡和次数卡
        $exist = $this->UserMessageModel->pastCardSearch($params["user_id"],'');
        // 2.查询用户消息中的 即将过期的用户卡id type =2 即将过期
        $setCardSearch = $this->UserMessageModel->setCardSearch($params["user_id"],2);
        $data = [];
        foreach($setCardSearch as $val){
            array_push($data,$val['user_card_id']);
        }
        if($exist){//3.如果用户消息中心没有 即将过期且当前的用户卡id ,则把提示快过期 写入到用户消息中心
            foreach($exist as $val){
                $message_type = 0;
                if(!in_array($val['user_card_id'],$data)){
                    switch($val['card_type']){
                        case 1:
                            $val['card_type'] = "权益卡";
                            $message_type = 21;
                        break;
                        case 2:
                            $val['card_type'] = "次数卡";
                            $message_type = 22;
                        break;
                    }
                    $data = [
                        'card_type' => $val["card_type"], 'user_card_id' => $val['user_card_id'],
                        'user_id' => $val['user_id'],   'title' =>  $val['card_type'].'即将过期',
                        'message_type' => $message_type,
                        'content'   =>  '您的'.$val['card_type'].': '.$val['card_number'].'即将过期,请尽快使用哦~'
                    ];
                    try{
                        $this->UserMessageModel->addpsCardMsg($data);
                    }catch(\Exception $e){//写入失败
                        return false;
                    }
                }
            }
        }
    //-------------------------------------------end------------------------------------------//
      
    //------------------------------------查询用户是否有已经过期的卡------------------------------//
        //1.查询该用户是否 有已经过期的权益卡和次数卡
        $exist = $this->UserMessageModel->pastCardSearch($params["user_id"],'past');
        // 2.查询用户消息中的用户卡id type=4,已过期
        $setCardSearch = $this->UserMessageModel->setCardSearch($params["user_id"],4);
        $data = [];//重置$data
        foreach($setCardSearch as $val){
            array_push($data,$val['user_card_id']);
        }
        if($exist){//3.如果用户消息中心没有当前的用户卡id 则把已过期 写入到用户消息中心
            foreach($exist as $val){
                $message_type = 0;
                if(!in_array($val['user_card_id'],$data)){
                    switch($val['card_type']){
                        case 1:
                            $val['card_type'] = "权益卡";
                            $message_type = 41;
                        break;
                        case 2:
                            $val['card_type'] = "次数卡";
                            $message_type = 42;
                        break;
                    }
                    $data = [
                        'card_type' => $val["card_type"], 'user_card_id' => $val['user_card_id'],
                        'user_id' => $val['user_id'],   'title' =>  $val['card_type'].'已过期',
                        'message_type' => $message_type,
                        'content'   =>  '您的'.$val['card_type'].': '.$val['card_number'].'已于'.date("Y-m-d H:i:s",$val['expire_time']).'过期,请知晓'
                    ];
                    try{
                        $this->UserMessageModel->addpsCardMsg($data);
                    }catch(\Exception $e){//写入失败
                        return false;
                    }
                }
            }
        }
    //-------------------------------------------end------------------------------------------//
    //------------------------------------获取消息列表------------------------------//
        $params["limit"] = 10;//1页显示的行数;
        $params["page"] = $params["page"] ? ((int)$params["page"]) : 1;
        $result = $this->UserMessageModel->msgList($params);
        foreach($result as &$val){
            if($val['seller_id'] == null){
                $val['seller_id'] = 0;
            }
        }
        return $result;
    }

    /**
     * 修改消息状态为已读
     * @param user_id 用户id
     */
    public function editMsgStatus($user_id)
    {
        return $this->UserMessageModel->editMsgStatus($user_id);
    }

}