<?php
namespace app\common\logic;
use app\common\model\SellerBalance as SellerBalanceModel;
use app\common\model\UserOrder as UserOrderModel;
use app\common\model\CashAccount as CashAccountModel;
use app\common\model\Seller as SellerModel;
use think\Db;
class SellerFund extends Base{
    protected $SellerBalanceModel = null;
    protected $UserOrderModel = null;
    protected $CashAccountModel = null;
    protected $SellerModel = null;

    public function __construct(){
        parent::__construct();
        $this->SellerBalanceModel = new SellerBalanceModel;
        $this->UserOrderModel = new UserOrderModel;
        $this->CashAccountModel = new CashAccountModel;
        $this->SellerModel = new SellerModel;
    }

    /**
     * 积分余额
     * @param seller_id 商家id
     */
    public function intbalance($params)
    {
        $income = $this->SellerBalanceModel->income($params['seller_id']);//进账金额
        $out = $this->SellerBalanceModel->out($params['seller_id']);//出账金额
        $balance = $income - $out;
        return $balance ? round($balance) : 0;
    }

    /**
     * 收入记录
     * @param seller_id 商家id
     */
    public function incomeRecord($params)
    {
        $result = [];
        // 1.用户在该商店支付成功的记录
        $userSucHistory = $this->UserOrderModel->userSucHistory($params['seller_id']);
        // 2.商户提现被驳回的记录,提现id>0,进账
        $incomeRecord = $this->SellerBalanceModel->incomeRecord($params['seller_id']);
        $result = array_merge($userSucHistory,$incomeRecord);
        return $result;
    }

    /**
     * 支出记录
     * @param seller_id 商家id
     */
    public function spendRecord($params)
    {
        return $this->SellerBalanceModel->spendRecord($params);
    }

    /**
     * 提现详情
     * @param cash_account_id 提现id
     */
    public function spDetails($params)
    {
        $data = [];
        $result = $this->SellerBalanceModel->spDetails($params);
        foreach($result as &$val){
            switch($val["account_type"]){
                case 1://支付宝
                    $val["account_type"] = "支付宝账号";
                break;
                case 2://微信
                    $val["account_type"] = "微信账号";
                break;
                case 3://银行卡
                    $val["account_type"] = "银行卡账号";
                break;
            }
            // 共有的第一步
            $data[0]["id"] = 0;
            $data[0]["title"] = "提交申请";
            if((filter_var($val["account"], FILTER_VALIDATE_EMAIL)) != false){//该账户为邮箱
                $num = strpos($val["account"], "@");//邮箱@的位置
                $str = substr($val["account"],0,$num);//邮箱@前的数字
                $val["account"] = substr($str ,-4,4);//取四位
            }else{//不为邮箱正常取后四位
                $val["account"] = substr($val["account"],-4,4);
            }
            $data[0]["des"] = $val["account_type"]."(尾号****".$val["account"].")";
            $data[0]['create_time'] = $val['create_time'];
            // 不同的第二步
            if($val["cash_status"] == 1){//待处理提现
                $data[1]['id'] = 1;
                $data[1]['title'] = '预计到账时间';
                $data[1]['des'] = '';
                $data[1]['create_time'] = strtotime("+3 day",$val['create_time']);//默认加3天
            }else if($val["cash_status"] == 2){//驳回提现
                $reason = Db::name('seller_reject')->where('relevant_id',$val["id"])->field('reject_reason')->find();
                $data[1]['id'] = 2;
                $data[1]['title'] = '提现驳回';
                $data[1]['des'] = $reason["reject_reason"];
                $data[1]['create_time'] = $val["cash_time"];
            }else if($val["cash_status"] == 3){//成功到账时间
                $data[1]['id'] = 3;
                $data[1]['title'] = '成功到账时间';
                $data[1]['des'] = '';
                $data[1]['create_time'] = $val["make_time"];
            }
        }
        return $data;
    }

     /**
     * 提现账户列表
     * @param seller_id 商家id
     * @param type 查看类型 1.支付宝 2.微信 3.银行卡
     */
    public function accountList($params)
    {
        switch($params["type"]){
            case 1://支付宝
                return $this->CashAccountModel->aliAcount($params);
            break;
            case 2://微信
                return $this->CashAccountModel->wechatAcount($params);
            break;
            case 3://银行卡
                $data = $this->CashAccountModel->bankAcount($params);
                if(!empty($data)){
                    $data["img"] = config('token.web_site_domain').get_file_path($data["img"]);
                    $data["icon"] = config('token.web_site_domain').get_file_path($data["icon"]);
                    $data['account'] = '**** **** **** '.substr($data['account'],-4,4);
                }
                return $data;
            break;
            default:
                return [];
        }
    }

    /**
     * 新增账户
     * @param status 状态:新增/编辑保存 1新增 2编辑保存
     * @param seller_id 商家id
     * @param type 账户类型 1.支付宝 2.微信 3.银行卡
     * @param account 账号
     * @param mobile 手机号
     * @param account_name 持卡人姓名
     * @param bank_id 开户行(后台银行卡表id)
     * @param idcard 身份证号
     */
    public function addAccount($params)
    {
        switch($params["type"]){
            case 1://支付宝
                return $this->CashAccountModel->addAcount($params);
            break;
            case 2://微信
                return $this->CashAccountModel->addAcount($params);
            break;
            case 3://银行卡
                return $this->CashAccountModel->addBankAcount($params);
            break;
            default:
                return [];
        }
    }

    /**
     * 编辑账户
     * @param status 状态:新增/编辑保存 1新增 2编辑保存
     * @param seller_id 商家id
     * @param type 账户类型 1.支付宝 2.微信 3.银行卡
     * @param account 账号
     * @param mobile 手机号
     * @param account_name 持卡人姓名
     * @param bank_id 开户行(后台银行卡表id)
     * @param idcard 身份证号
     */
    public function editAccount($params)
    {
        switch($params["type"]){
            case 1://支付宝
                return $this->CashAccountModel->editAccount($params);
            break;
            case 2://微信
                return $this->CashAccountModel->editAccount($params);
            break;
            case 3://银行卡
                return $this->CashAccountModel->editBankAcount($params);
            break;
            default:
                return [];
        }
    }

     /**
     * 可用银联卡信息 => 返回可用开户行id和名称
     */
    public function bankInfo(){
        return $this->CashAccountModel->bankInfo();
    }

     /**
     * 获取 账号 编辑信息
     * @param id 账号id
     */
    public function editAccountInfo($params){
        return $this->CashAccountModel->editAccountInfo($params);
    }

     /**
     * 返回商家 可用的提现账号信息
     * @param seller_id 商家id
     */
    public function accountInfo($params){
        return $this->CashAccountModel->accountInfo($params);
    }

    /**
     * 提现
     * @param seller_id 商家id
     * @param cash_account_id 提现账号表id
     * @param cash_price 提现金额
     */
    public function withdrawCash($params){
        // 判断该提现账号id是否可用
        $result = $this->CashAccountModel->accountUse($params['cash_account_id']);
        if(empty($result)){
            return 0;
        }
        $balance = $this->intbalance($params);
        $params["nowbalance"] = $balance - $params["cash_price"];//当前余额
        return $this->CashAccountModel->withdrawCash($params);
    }

    /**
     * 提现手续费
     * @param money 提现金额
     * @param seller_id 商家id
     */
    public function serveCharge($params){
        $fee = 0;//手续费比率
        $cash_fee = 0;//手续费
        $info = '';//提示信息
        // 1.查询 商家表 中该商家是否有额外的比例配置
        $ratio = $this->SellerModel->sellerFee($params['seller_id']);
        if(!empty((float)$ratio["fee"])){
            // 按照单独配置的商家比例算 , 商家的比例已经是小数点了
            $cash_fee = ((float)$params['money'] * (float)$ratio["fee"]);
            $fee = (float)$ratio["fee"]*100;
        }else{
            // 按照后台配置的比例算
            $scale = Db::table('dp_cash_scale')->field("fee")->find();
            $cash_fee = ((float)$params['money'] * (float)$scale["fee"] * 0.01);
            $fee = (float)$scale["fee"];
        }
        $info = '额外收取'.round($cash_fee,2).'元的手续费，费率'.$fee.'%';
        return $info;
    }

    /**
     * 判断账户添加情况
     * @param seller_id 商家id
     */
    public function accountStatus($params)
    {
        $data = ['ali'=>2,'wx'=>2,'bk'=>2];//1表示存在,2表示不存在
        $result = $this->CashAccountModel->accountStatus($params['seller_id']);
        if(!empty($result)){
            foreach($result as $val){
                switch($val['account_type']){
                    case 1:
                        $data['ali'] = 1;
                    break;
                    case 2:
                        $data['wx'] = 1;
                    break;
                    case 3:
                        $data['bk'] = 1;
                    break;
                }
            }
        }
        return $data;
    }

    /**
     * 账号可用提现选择列表 
     * @param seller_id 商家id
     */
    public function AccountAvailable($params)
    {
        $result =  $this->CashAccountModel->AccountAvailable($params);
        return $result;
    }

}