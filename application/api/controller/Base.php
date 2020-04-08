<?php

namespace app\api\controller;

use Lcobucci\JWT\Parser;
use think\Controller;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use app\common\util\Token;
use think\Db;

class Base extends Controller
{
    /**
     * 状态值
     * @var null
     */
    protected $status = null;
    /**
     * 提示信息
     * @var string
     */
    protected $message = '';
    /**
     * 返回数据
     * @var null
     */
    protected $data = null;
    /**
     * 用户uid
     * @var int|mixed
     */
    protected $uid = 0;
    /**
     * 商家id
     */
    protected $sellerid = 0;

    /**
     * 员工id
     */
    protected $staffid = 0;

    public $controller;

    public $action;

    public $version;

    public $responseKey;

    public $token;

    public $msgType;

    private $app_no_login = [ // 不需要登录验证的模块信息
        'controller_name' => [
            'action_name'
        ],
        'sellerlogin'   => ['check','signin'],   //商家登录相关
        'attachment'    => ['uploadImage'],      //图片上传
        'sellerlogintel'=> ['queryContactPhone'],//商家端登录页联系电话
        'userlogin'     => ['getMessageCode','checkVCode','registerAgreement','register','login','resetPwd','getVerify','checkVCode'],//用户登录相关
        'usercardcenter'=> ['cardCategories','instructions'],     //用户卡包中心
        'vcode'         => ['getVerify','setVerify','checkVCode'],//图形验证码相关
        'sellerstore'   => ['SellerEnter','SellerEnterApply'],    //商家入驻
    ];

    /***
     * 构造函数
     * Base constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $controller = trim(request()->header('c', ''));
        if (strstr($controller, '_')) {
            $arr = explode('_', $controller);
            $arr_str = '';
            foreach ($arr as $item) {
                $arr_str .= ucfirst($item);
            }
            $this->controller = $arr_str;
        } else {
            $this->controller = $controller;
        }
        $this->action  = trim(request()->header('a', ''));
        $this->version = trim(request()->header('v', ''));
        $this->token   = trim(request()->header('token', ''));    // token
        $this->uid     = trim(request()->header('uid', ''));      // 用户uid
        $this->sellerid = trim(request()->header('sellerid', ''));// 商家sellerid
        $this->staffid  = trim(request()->header('staffid', '')); // 商家员工staffid
        //$this->needLogin($this->token);
        if(!empty($this->uid)){
            $this->psCard($this->uid);
        }
    }

    /**
     * 验证是否需要登录
     */
    private function needLogin($token)
    {

        $arr = $this->app_no_login;
        $key = strtolower($this->controller);
        if (isset($arr[$key])) {
            if (!in_array($this->action, $arr[$key])) {
                $this->checkToken($token);
            }
        } else {
            $this->checkToken($token);
        }
    }

    /***
     * 1.判断用户卡是否过期2.若过期则修改卡的状态
     * @param $uid
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function psCard($uid){
        $map['status'] = 0;//正常
        $map['expire_time'] = ['<=',time()];
        $result = Db::name('user_card')->where($map)->select();
        if(!empty($result)){
            foreach($result as &$val){
                // 启动事务
                Db::startTrans();
                try{
                    Db::name('user_card')->where('id='.$val['id'])->update(['status' => 2]);
                    // 提交事务
                    Db::commit();
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                }
            }
        }
    }

    /**
     * 禁止clone
     */
    private function __clone(){}

    /**
     * token 验证
     */
    private function checkToken($token)
    {
        if(empty($token)){
            $this->status = 0;
            $this->message = '缺少参数token';
            $this->__destruct();
        }
        $token_ = (new Parser())->parse((string)$this->token);
        if (!$token_) {
            $this->status = 0;
            $this->message = '未登录';
            $this->__destruct();
        } else {
            //验证token
            $res = Token::validateToken($token_);
            if (is_array($res)) {
                $this->uid = $res['uid'];
            } else if ($res === false) {
                //是否是token过期
                $res = Token::validateTokenIsExpired($token_);
                if ($res) {
                    $this->status  = 0;
                    $this->message = 'token过期';
                    $this->__destruct();
                } else {
                    $this->status  = 0;
                    $this->message = 'token错误';
                    $this->__destruct();
                }
            }
        }
    }

    /**
     * 析构方法
     */
    public function __destruct()
    {
        if(!is_null($this->status)) {
            $header = [];
            $result = [
                'status' => $this->status,
                'msg'    => $this->message,
                'time'   => Request::instance()->server('REQUEST_TIME'),
                'data'   => $this->data
            ];
            $type = 'json';
            $response = Response::create($result, $type)->header($header);
            throw new HttpResponseException($response);
        }
    }
}