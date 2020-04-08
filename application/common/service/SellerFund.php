<?php
namespace app\common\service;

use app\common\logic\SellerFund as SellerFundLogic;
use think\exception\DbException;

class SellerFund extends Base{
    protected $SellerFundLogic = null;

    public function __construct(){
        parent::__construct();
        $this->SellerFundLogic = new SellerFundLogic;
    }

    /**
     * 积分余额
     * @param seller_id 商家id
     */
    public function intbalance($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证商家id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->SellerFundLogic->intbalance($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 收入记录
     * @param seller_id 商家id
     */
    public function incomeRecord($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证提现id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->SellerFundLogic->incomeRecord($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 支出记录
     * @param seller_id 商家id
     */
    public function spendRecord($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证商家id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->SellerFundLogic->spendRecord($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 提现详情
     * @param cash_account_id 提现id
     */
    public function spDetails($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'spDetails')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->SellerFundLogic->spDetails($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

     /**
     * 提现账户列表
     * @param seller_id 商家id
     * @param type 查看类型 1.支付宝 2.微信 3.银行卡
     */
    public function accountList($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'accountList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->SellerFundLogic->accountList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 新增/编辑保存 账户列表
     * @param status 状态:新增/编辑保存 1新增 2编辑保存
     * @param seller_id 商家id
     * @param type 账户类型 1.支付宝 2.微信 3.银行卡
     * @param account 账号
     * @param mobile 手机号
     * @param account_name 持卡人姓名
     * @param bank_id 开户行(后台银行卡表id)
     * @param idcard 身份证号
     */
    public function saveAccount($params)
    {
        $validate = validate('Management');
        if($params["type"] == 3){//银行卡需要单独验证身份证和开户行id
            $msge = $validate->check($params, [],'addBankAcount');
        }else{
            $msge = $validate->check($params, [],'addAcount');
        }
        // 验证参数
        if (!$msge) {
            $this->message = $validate->getError();
            return;
        }
        // 判断是保存编辑还是新增
        if($params["status"] == 1){//新增
            // 判断该用户是否已有账号
            $result = $this->SellerFundLogic->accountList($params);
            if(!empty($result)){
                list($this->status, $this->message) = [0, "相关账号只能保留一个!"];
                return;
            }
            //新增账号 
            try{
                $data = $this->SellerFundLogic->addAccount($params);
                if(!empty($data)){
                    list($this->status, $this->message) = [1, "新增账号成功!"];
                }else{
                    list($this->status, $this->message) = [0, "账号类型参数有误!新增账号失败!"];
                }
            }catch(DbException $e){
                list($this->status, $this->message) = [0, "新增账号失败!"];
            }
            return;
        }else if($params["status"] == 2){//保存编辑
            //编辑账号 
            try{
                $data = $this->SellerFundLogic->editAccount($params);
                if(!empty($data)){
                    list($this->status, $this->message) = [1, "编辑成功!"];
                }else{
                    list($this->status, $this->message) = [0, "当前未做修改!"];
                }
            }catch(DbException $e){
                list($this->status, $this->message) = [0, "编辑失败!"];
            }
            return;
        }
    }

    /**
     * 可用银联卡信息 => 返回可用开户行id和名称
     */
    public function bankInfo(){
        $data = $this->SellerFundLogic->bankInfo();
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 获取 账号 编辑信息
     * @param id 账号id
     */
    public function editAccountInfo($params){
        $validate = validate('Management');
        if (!$validate->check($params, [],'editAccountInfo')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->SellerFundLogic->editAccountInfo($params);
        if(!empty($data)){
            list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        }else{
            list($this->status, $this->message, $this->data) = [0, "查找不到数据,请求失败", $data];
        }
        return;
    }

    /**
     * 返回商家 可用的提现账号信息
     * @param seller_id 商家id
     */
    public function accountInfo($params){
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证商家id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->SellerFundLogic->accountInfo($params);
        if(!empty($data)){
            list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        }else{
            list($this->status, $this->message, $this->data) = [0, "查找不到数据,请求失败", $data];
        }
        return;
    }

    /**
     * 提现
     * @param seller_id 商家id
     * @param cash_account_id 提现账号表id
     * @param cash_price 提现金额
     */
    public function withdrawCash($params){
        $validate = validate('Management');
        if (!$validate->check($params, [],'withdrawCash')) {
            $this->message = $validate->getError();
            return;
        }
        //提现
        $data = $this->SellerFundLogic->withdrawCash($params);
        if($data == 1){
            list($this->status, $this->message) = [1, "提现成功!"];
        }else{
            list($this->status, $this->message) = [0, "提现账号不可用或网络不稳定!"];
        }
        return;
    }

    /**
     * 提现手续费
     * @param money 提现金额
     * @param seller_id 商家id
     */
    public function serveCharge($params){
        $data = $this->SellerFundLogic->serveCharge($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 判断账户添加情况
     * @param seller_id 商家id
     */
    public function accountStatus($params)
    {
        $data = $this->SellerFundLogic->accountStatus($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 账号可用提现选择列表 
     * @param seller_id 商家id
     */
    public function AccountAvailable($params)
    {
        $data = $this->SellerFundLogic->AccountAvailable($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

}