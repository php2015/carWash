<?php
namespace app\common\service;
use app\common\logic\UserNews as UserNewsLogic;

class UserNews extends Base{
    protected $UserNewsLogic = null;

    public function __construct(){
        parent::__construct();
        $this->UserNewsLogic = new UserNewsLogic;
    }

    /**
     * 资讯分类
     */
    public function newsClass()
    {
        $data = $this->UserNewsLogic->newsClass();
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     *  资讯列表 
     *  @param class_id 资讯分类id
     *  @param page 页数
     */
    public function newsList($params){
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'newsList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserNewsLogic->newsList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 资讯详情
     * @param id 资讯id
     */
    public function newsDetail($params){
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'newsDetail')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserNewsLogic->newsDetail($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

}