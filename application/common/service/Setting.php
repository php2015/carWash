<?php
namespace app\common\service;

use app\common\logic\Setting as SettingLogic;
use think\exception\DbException;
use think\helper\Hash;

class Setting extends Base{
    protected $SettingLogic = null;

    public function __construct(){
        parent::__construct();
        $this->SettingLogic = new SettingLogic;
    }

    /**
     * 联系我们
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function contactUs()
    {
        $data = $this->SettingLogic->contactUs();
        if(empty($data)){
            list($this->status, $this->message) = [0, "后台未配置联系电话!"];
            return;
        }
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 关于我们 
     */
    public function aboutUs()
    {
        $data = $this->SettingLogic->aboutUs();
        if(empty($data)){
            list($this->status, $this->message) = [0, "后台未配置关于我们!"];
            return;
        }
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 服务协议
     * @param type 用户服务协议,不传则默认为商家 服务协议
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function servAgreement($params)
    {
        $data = $this->SettingLogic->servAgreement($params);
        if(empty($data)){
            list($this->status, $this->message) = [0, "后台未配置服务协议!"];
            return;
        }
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 修改密码
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @param old_pass 原密码
     * @param seller_id 商家id
     * @param new_pass 新密码
     */
    public function changePassword(array $params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'changePassword')) {
            $this->message = $validate->getError();
            return;
        }
        // 查询原密码是否正确
        $result = $this->SettingLogic->correctPass($params);
        if(empty($result)){
            list($this->status, $this->message) = [0, "没有查到原密码!"];
            return;
        }else{
            $jundge = Hash::check($params["old_pass"],$result["password"]);
            if($jundge == false){
                list($this->status, $this->message) = [0, "原密码错误!"];
                return;
            }
        }
        try{
            $this->SettingLogic->changePassword($params);
            list($this->status, $this->message) = [1, "修改密码成功"];
        }catch(DbException $e){
            list($this->status, $this->message) = [0, "修改密码失败"];
        }
        return;
    }



}