<?php
/**
 * 陈鑫 Visual Studio
 */
namespace app\api\controller\v1;
use think\helper\Hash;
use app\api\controller\Base;
use think\Request;
use app\common\service\SellerFund as SellerFundService;
/**
 * 商家端 我的资金模块接口类
 * Class SellerFund
 * @package app\api\controller\v1
 */
class SellerFund extends Base
{
    protected $SellerFundService = null;

    function __construct(Request $request = null){
        $this->SellerFundService = new SellerFundService;
        parent::__construct($request);
    }

    /**
     * 积分余额
     * @param seller_id 商家id
     */
    public function intbalance()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->SellerFundService->intbalance($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }

    /**
     * 收入记录
     * @param seller_id 商家id
     */
    public function incomeRecord()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->SellerFundService->incomeRecord($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }

    /**
     * 支出记录
     * @param seller_id 商家id
     */
    public function spendRecord()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->SellerFundService->spendRecord($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }

    /**
     * 提现详情
     * @param cash_account_id 提现id
     */
    public function spDetails()
    {
        $params = [
            'cash_account_id' => input('cash_account_id', '', 'trim'),
        ];
        $this->SellerFundService->spDetails($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }

    /**
     * 提现账户列表
     * @param seller_id 商家id
     * @param type 查看类型 1.支付宝 2.微信 3.银行卡
     */
    public function accountList()
    {
        $params = [
            'seller_id' => $this->sellerid,
            'type' => input('type', '', 'trim'),
        ];
        $this->SellerFundService->accountList($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
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
    public function saveAccount()
    {
        $params = [
            'status' => input('status', '', 'trim'),
            'seller_id' => $this->sellerid,
            'type' => input('type', '', 'trim'),
            'account' => input('account', '', 'trim'),
            'mobile' => input('mobile', '', 'trim'),
            'account_name' => input('account_name', '', 'trim'),
            'bank_id' => input('bank_id', '', 'trim'),
            'idcard' => input('idcard', '', 'trim'),
        ];
        $this->SellerFundService->saveAccount($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }

    /**
     * 可用银联卡信息 => 返回可用开户行id和名称
     */
    public function bankInfo(){
        $this->SellerFundService->bankInfo();
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }

    /**
     * 获取 账号 编辑信息
     * @param id 账号id
     */
    public function editAccountInfo(){
        $params = [
            'id' => input('id', '', 'trim'),
        ];
        $this->SellerFundService->editAccountInfo($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }
    
    /**
     * 返回商家 可用的提现账号信息
     * @param seller_id 商家id
     */
    public function accountInfo(){
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->SellerFundService->accountInfo($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }

    /**
     * 提现
     * @param seller_id 商家id
     * @param cash_account_id 提现账号表id
     * @param cash_price 提现金额
     */
    public function withdrawCash(){
        $params = [
            'seller_id' => $this->sellerid,
            'cash_account_id' => input('cash_account_id', '', 'trim'),
            'cash_price' => input('cash_price', '', 'trim'),
        ];
        $this->SellerFundService->withdrawCash($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }

    /**
     * 提现手续费
     * @param money 提现金额
     * @param seller_id 商家id
     */
    public function serveCharge(){
        $params = [
            'seller_id' => $this->sellerid,
            'money' => input('money', '', 'trim'),
        ];
        $this->SellerFundService->serveCharge($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }
    
    /**
     * 判断账户添加情况
     * @param seller_id 商家id
     */
    public function accountStatus()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->SellerFundService->accountStatus($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }
    
    /**
     * 账号可用提现选择列表 
     * @param seller_id 商家id
     */
    public function AccountAvailable()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->SellerFundService->AccountAvailable($params);
        list($this->status, $this->message, $this->data) = [$this->SellerFundService->status, $this->SellerFundService->message, $this->SellerFundService->data];
    }

}