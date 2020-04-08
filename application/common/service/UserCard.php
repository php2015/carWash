<?php
namespace app\common\service;
use app\common\logic\UserCard as UserCardLogic;

class UserCard extends Base{
    protected $UserCardLogic = null;

    public function __construct(){
        parent::__construct();
        $this->UserCardLogic = new UserCardLogic;
    }

    /**
     * 用户卡列表
     * @param user_id 用户id
     * @param card_type 卡类型 ||1.权益 2.次数
     * @param status 卡状态 ||0.可使用 2.已失效
     */
    public function cardList($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'cardList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserCardLogic->cardList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

     /**
     * 用户卡详情
     * @param card_id 用户卡id
     */
    public function cardInfo($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'cardInfo')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserCardLogic->cardInfo($params['card_id']);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 权益卡帮助协议
     */
    public function helpProtocol()
    {
        $data = $this->UserCardLogic->helpProtocol();
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 权益卡余额
     * @param user_id 用户id
     */
    public function cardBalance($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'msgList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserCardLogic->cardBalance($params['user_id']);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

}