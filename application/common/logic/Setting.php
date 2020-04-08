<?php
namespace app\common\logic;
use app\common\model\Contactus as ContactusModel;
use app\common\model\ServiceProtocol as ServiceProtocolModel;
use app\common\model\SellerStaff as SellerStaffModel;

class Setting extends Base{
    protected $ContactusModel = null;
    protected $ServiceProtocolModel = null;
    protected $SellerStaffModel = null;

    public function __construct(){
        parent::__construct();
        $this->ContactusModel = new ContactusModel;
        $this->ServiceProtocolModel = new ServiceProtocolModel;
        $this->SellerStaffModel = new SellerStaffModel;
    }

    /**
     * 联系我们
     */
    public function contactUs()
    {
        return $this->ContactusModel->contactUs();
    }

    /**
     * 关于我们 
     */
    public function aboutUs()
    {
        return $this->ServiceProtocolModel->aboutUs();
    }

    /**
     * 服务协议
     * @param type 用户服务协议,不传则默认为商家 服务协议
     */
    public function servAgreement($params)
    {
        return $this->ServiceProtocolModel->servAgreement($params);
    }

    /**
     * 验证原密码是否正确
     * @param seller_ud 商家id
     */
    public function correctPass(array $params)
    {
        return $this->SellerStaffModel->correctPass($params);
    }
    
     
     /**
     * 修改密码
     * @param seller_ud 商家id
     * @param new_pass 输入的密码
     */
    public function changePassword(array $params)
    {
        return $this->SellerStaffModel->changePassword($params);
    }

}