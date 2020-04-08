<?php
namespace app\common\service;
use app\common\logic\UserMessage as UserMessageLogic;

class UserMessage extends Base{
    protected $UserMessageLogic = null;

    public function __construct(){
        parent::__construct();
        $this->UserMessageLogic = new UserMessageLogic;
    }

    /**
     * 用户消息中心列表
     * @param user_id 用户id
     * @param page 页数
     */
    public function msgList($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'msgList')) {
            $this->message = $validate->getError();
            return;
        }
        $status = $this->UserMessageLogic->editMsgStatus($params['user_id']);//点击之后修改消息状态为已读
        $data = $this->UserMessageLogic->msgList($params);
        if($data == false){
            list($this->status, $this->message, $this->data) = [0, "当前无消息~", $data];
        }else{
            list($this->status, $this->message, $this->data) = [1, "请求成功!", $data];
        }
        return;
    }

}