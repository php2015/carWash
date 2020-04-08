<?php
/**
 * 陈鑫 Visual Studio
 */
namespace app\api\controller\v1;
use think\helper\Hash;
use app\api\controller\Base;
use think\Request;
use app\common\service\Setting as SettingService;
/**
 * 商家端/用户端 设置模块接口类
 * Class Setting
 * @package app\api\controller\v1
 */
class Setting extends Base
{
    protected $SettingService = null;

    function __construct(Request $request = null){
        $this->SettingService = new SettingService;
        parent::__construct($request);
    }

    /**
     * 联系我们
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function contactUs()
    {
        $this->SettingService->contactUs();
        list($this->status, $this->message, $this->data) = [$this->SettingService->status, $this->SettingService->message, $this->SettingService->data];
    }

    /**
     * 服务协议
     * @param type 用户服务协议,不传则默认为商家 服务协议
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function servAgreement()
    {
        $params = [
            'type' => input('type', '', 'trim'),
        ];
        $this->SettingService->servAgreement($params);
        list($this->status, $this->message, $this->data) = [$this->SettingService->status, $this->SettingService->message, $this->SettingService->data];
    }

    /**
     * 修改密码
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function changePassword()
    {
        $params = [
            'seller_id' => $this->sellerid,
            'old_pass' => input('old_pass', '', 'trim'),
            'new_pass' => Hash::make(input('new_pass', '', 'trim')),
        ];
        $this->SettingService->changePassword($params);
        list($this->status, $this->message, $this->data) = [$this->SettingService->status, $this->SettingService->message, $this->SettingService->data];
    }

    /**
     * 关于我们 
     */
    public function aboutUs()
    {
        $this->SettingService->aboutUs();
        list($this->status, $this->message, $this->data) = [$this->SettingService->status, $this->SettingService->message, $this->SettingService->data];
    }


}