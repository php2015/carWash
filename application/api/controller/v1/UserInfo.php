<?php
/**
 * 陈鑫 Visual Studio
 */
namespace app\api\controller\v1;
use app\api\controller\Base;
use think\Request;
use app\common\service\UserInfo as UserInfoService;
/**
 * 用户个人中心 模块接口类
 * Class UserInfo
 * @package app\api\controller\v1
 */
class UserInfo extends Base
{
    protected $UserInfoService = null;

    function __construct(Request $request = null){
        $this->UserInfoService = new UserInfoService;
        parent::__construct($request);
    }

    /**
     * 个人中心页
     * @param user_id 用户id
     */
    public function index()
    {
        $params = [
            'user_id' => $this->uid,
        ];
        $this->UserInfoService->index($params);
        list($this->status, $this->message, $this->data) = [$this->UserInfoService->status, $this->UserInfoService->message, $this->UserInfoService->data];
    }

    /**
     * 保存用户资料 
     * @param user_id 用户id
     * @param head_img 用户头像
     * @param nickname 用户昵称
     * @param sex 性别(0未知,1男,2女)
     * @param birthday 生日
     */
    public function saveUserInfo()
    {
        $params = [
            'user_id' => $this->uid,
            'head_img' => input('head_img', '', 'trim'),
            'nickname' => input('nickname', '', 'trim'),
            'sex' => input('sex', '', 'trim'),
            'birthday' => input('birthday', '', 'trim'),
        ];
        if(empty($params['head_img'])){
            unset($params['head_img']);
        }
        if(empty($params['nickname'])){
            unset($params['nickname']);
        }
        if(empty($params['sex'])){
            unset($params['sex']);
        }
        if(empty($params['birthday'])){
            unset($params['birthday']);
        }
        $this->UserInfoService->saveUserInfo($params);
        list($this->status, $this->message, $this->data) = [$this->UserInfoService->status, $this->UserInfoService->message, $this->UserInfoService->data];
    }

    /**
     * 显示 用户资料 
     * @param user_id 用户id
     */
    public function showUserInfo()
    {
        $params = [
            'user_id' => $this->uid,
        ];
        $this->UserInfoService->showUserInfo($params);
        list($this->status, $this->message, $this->data) = [$this->UserInfoService->status, $this->UserInfoService->message, $this->UserInfoService->data];
    }

}