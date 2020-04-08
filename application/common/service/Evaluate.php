<?php
/**
 * Created by Visual Studio Code.
 * User: chenxin
 * Date: 2018/9/30
 * Time: 15:08
 */
namespace app\common\service;

use app\common\logic\Evaluate as EvaluateLogic;
use think\exception\DbException;

class Evaluate extends Base{
    protected $EvaluateLogic = null;

    public function __construct(){
        parent::__construct();
        $this->EvaluateLogic = new EvaluateLogic;
    }

    /**
     * 评价列表
     * @param seller_id 商家id
     * @param page 页数
     * @param type 查看评价类型 0全部 1差评 2一般 3好评
     */
    public function commentsList($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证商家id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->EvaluateLogic->commentsList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 商家端评价类型 数量
     * @param seller_id 商家id
     */
    public function commentsType($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证商家id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->EvaluateLogic->commentsType($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 我的订单 获取订单单条评价
     * @param user_order_id 用户订单id
     */
    public function orderComment($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [], 'user_order_id')) {//验证用户订单id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->EvaluateLogic->orderComment($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 商家回复评价
     * @param user_order_id 用户订单id
     * @param content 商家回复内容
     */
    public function sellerReply($params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [], 'user_order_id')) {//验证用户订单id
            $this->message = $validate->getError();
            return;
        }
        if(filterComment($params["content"]) == false){
            list($this->status, $this->message) = [0, "评论中有敏感词,请核对后提交~"];
            return;
        }
        $data = $this->EvaluateLogic->sellerReply($params);
        if(!empty($data)){
            list($this->status, $this->message) = [1, "评论成功"];
        }else{
            list($this->status, $this->message) = [0, "评论失败"];
        }
        return;
    }


}