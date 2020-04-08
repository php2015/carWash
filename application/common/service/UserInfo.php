<?php
namespace app\common\service;
use app\common\logic\UserInfo as UserInfoLogic;

class UserInfo extends Base{
    protected $UserInfoLogic = null;

    public function __construct(){
        parent::__construct();
        $this->UserInfoLogic = new UserInfoLogic;
    }

    /**
     * 个人中心页
     * @param user_id 用户id
     */
    public function index($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'msgList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserInfoLogic->index($params['user_id']);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 保存用户资料 
     * @param user_id 用户id
     * @param head_img 用户头像
     * @param nickname 用户昵称
     * @param sex 性别(0未知,1男,2女)
     * @param birthday 生日
     */
    public function saveUserInfo($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'msgList')) {
            $this->message = $validate->getError();
            return;
        }
        try{
            $this->UserInfoLogic->saveUserInfo($params);
            list($this->status, $this->message) = [1, "更新成功!"];
        }catch(Exception $e){
            list($this->status, $this->message) = [0, "更新失败!"];
        }
        return;
    }

    /**
     * 显示 用户资料 
     * @param user_id 用户id
     */
    public function showUserInfo($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'msgList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserInfoLogic->showUserInfo($params['user_id']);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

}