<?php
namespace app\common\logic;
use app\common\model\UserMessage as UserMessageModel;
use app\common\model\UserBuycard as UserBuycardModel;
use app\common\model\User as UserModel;

class UserInfo extends Base{
    protected $UserMessageModel = null;
    protected $UserBuycardModel = null;
    protected $UserModel = null;

    public function __construct(){
        parent::__construct();
        $this->UserMessageModel = new UserMessageModel;
        $this->UserBuycardModel = new UserBuycardModel;
        $this->UserModel = new UserModel;
    }

    /**
     * 个人中心页
     * @param user_id 用户id
     */
    public function index($user_id)
    {
        // 1.获取用户的未读消息
        $unreadMsg = $this->UserMessageModel->unreadMsg($user_id);
        // 2.获取权益卡张数
        $qycard = $this->UserBuycardModel->getQyCard($user_id,'qy');
        // 3.获取次数卡张数
        $cscard = $this->UserBuycardModel->getQyCard($user_id,'cs');
        $result = ['unreadMsg' => $unreadMsg, 'qycard' => $qycard, 'cscard' => $cscard];
        return $result;
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
        $data = ['user_id'=>0, 'head_img'=>0, 'nickname'=>'', 'sex'=>0, 'birthday'=>0];
        $params = array_diff_assoc($params,$data);//返回不为空的键值
        return $this->UserModel->saveUserInfo($params);
    }

    /**
     * 显示 用户资料 
     * @param user_id 用户id
     */
    public function showUserInfo($user_id)
    {
        $data = [];
        $result = $this->UserModel->getUserInfo($user_id);
        if(!empty($result)){
            $data['head_img'] = ['id' => $result['head_img'],'path' => config('token.web_site_domain').get_file_path($result['head_img'])];
            $data['nickname'] = $result['nickname'];
            $data['sex'] = $result['sex'];
            $data['birthday'] = $result['birthday'];
        }
        return $data;
    }

}