<?php
/**
 * 陈鑫 Visual Studio
 */
namespace app\api\controller\v1;
use app\api\controller\Base;
use think\Request;
use app\common\service\UserMessage as UserMessageService;
/**
 * 用户消息中心模块接口类
 * Class UserMessage
 * @package app\api\controller\v1
 */
class UserMessage extends Base
{
    protected $UserMessageService = null;

    function __construct(Request $request = null){
        $this->UserMessageService = new UserMessageService;
        parent::__construct($request);
    }

    /**
     * 用户消息中心列表
     * @param user_id 用户id
     * @param page 页数
     */
    public function msgList()
    {
        $params = [
            'user_id' => $this->uid,
            'page' => input('page', '', 'trim'),
        ];
        $this->UserMessageService->msgList($params);
        list($this->status, $this->message, $this->data) = [$this->UserMessageService->status, $this->UserMessageService->message, $this->UserMessageService->data];
    }

}