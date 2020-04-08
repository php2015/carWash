<?php
/**
 * 陈鑫 Visual Studio
 */
namespace app\api\controller\v1;
use app\api\controller\Base;
use think\Request;
use app\common\service\UserCard as UserCardService;
/**
 * 用户卡模块接口类
 * Class UserCard
 * @package app\api\controller\v1
 */
class UserCard extends Base
{
    protected $UserCardService = null;

    function __construct(Request $request = null){
        $this->UserCardService = new UserCardService;
        parent::__construct($request);
    }

     /**
     * 用户卡列表
     * @param user_id 用户id
     * @param card_type 卡类型 ||1.权益 2.次数
     * @param status 卡状态 ||0.可使用 2.已失效
     * @param page 分页
     */
    public function cardList()
    {
        $params = [
            'user_id' => $this->uid,
            'card_type' => input('card_type', '', 'trim'),
            'status' => input('status', '', 'trim'),
            'page' => input('page', '', 'trim'),
        ];
        $this->UserCardService->cardList($params);
        list($this->status, $this->message, $this->data) = [$this->UserCardService->status, $this->UserCardService->message, $this->UserCardService->data];
    }

    /**
     * 用户卡详情(不放在列表中,单独剥离,方便后面详情加数据)
     * @param card_id 用户卡id
     */
    public function cardInfo(){
        $params = [
            'card_id' => input('id', '', 'trim'),
        ];
        $this->UserCardService->cardInfo($params);
        list($this->status, $this->message, $this->data) = [$this->UserCardService->status, $this->UserCardService->message, $this->UserCardService->data];
    }

    /**
     * 权益卡帮助协议
     */
    public function helpProtocol()
    {
        $this->UserCardService->helpProtocol();
        list($this->status, $this->message, $this->data) = [$this->UserCardService->status, $this->UserCardService->message, $this->UserCardService->data];
    }

    /**
     * 权益卡余额
     * @param user_id 用户id
     */
    public function cardBalance(){
        $params = [
            'user_id' => $this->uid,
        ];
        $this->UserCardService->cardBalance($params);
        list($this->status, $this->message, $this->data) = [$this->UserCardService->status, $this->UserCardService->message, $this->UserCardService->data];
    }
}