<?php
namespace app\common\service;
use app\common\logic\UserExpend as UserExpendLogic;
use app\common\model\Comment as CommentModel;

class UserExpend extends Base{
    protected $UserExpendLogic = null;
    protected $CommentModel = null;

    public function __construct(){
        parent::__construct();
        $this->UserExpendLogic = new UserExpendLogic;
        $this->CommentModel = new CommentModel;
    }

    /**
     * 用户消费记录 列表
     * @param user_id 用户id
     * @param page 页数
     */
    public function expendList($params){
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'msgList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserExpendLogic->expendList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 用户评价商家
     * @param comment_type 评价类型
     * @param user_order_id 订单id
     * @param content 评价内容
     */
    public function comment($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'comment')) {
            $this->message = $validate->getError();
            return;
        }
        // 判断评价内容是否存在屏蔽词,若存在则驳回
        if(filterComment($params['content']) == false){
            list($this->status, $this->message) = [0, "您的评论包含违禁字符，请重新输入"];
            return;
        }
        try{
            $this->UserExpendLogic->comment($params);
            $this->CommentModel->userCommentStatus($params['user_order_id']);
            list($this->status, $this->message) = [1, "评价成功"];
        }catch(Exception $e){
            list($this->status, $this->message) = [0, "评价失败"];
        }
        return;
    }

    /**
     * 消费订单详情
     * @param user_order_id 订单id
     * @param seller_id 商家id
     * @param lon 经度
     * @param lat 纬度
     */
    public function expdetail($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'expdetail')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserExpendLogic->expdetail($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

}