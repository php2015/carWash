<?php
namespace app\common\logic;
use app\common\model\UserCard as UserCardModel;

class UserCard extends Base{
    protected $UserCardModel = null;

    public function __construct(){
        parent::__construct();
        $this->UserCardModel = new UserCardModel;
    }

    /**
     * 用户卡列表
     * @param user_id 用户id
     * @param card_type 卡类型 ||1.权益 2.次数
     * @param status 卡状态 ||0.可使用 2.已失效
     */
    public function cardList($params)
    {
        $data = [];
        $result = $this->UserCardModel->cardList($params);
        foreach($result as $k=>$val){
            $data[$k] = $val;//卡列表
            if($val['card_type'] == 1){
                $data[$k]["service"] = "全部服务";
            }
        }
        return $data; 
    }

    /**
     * 用户卡详情
     * @param card_id 用户卡id
     */
    public function cardInfo($card_id)
    {
        $result = $this->UserCardModel->cardInfo($card_id);
        if(!empty($result)){
            $result["service"] = "全部服务";
        }
        return $result ? $result : [];
    }

    /**
     * 权益卡帮助协议
     */
    public function helpProtocol()
    {
        return $this->UserCardModel->helpProtocol();
    }

    /**
     * 权益卡余额
     * @param user_id 用户id
     */
    public function cardBalance($user_id){
        return $this->UserCardModel->cardBalance($user_id);
    }
}