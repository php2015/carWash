<?php
namespace app\common\logic;
use app\common\model\SellerMessage as SellerMessageModel;

class SellerMessage extends Base{
    protected $SellerMessageModel = null;

    public function __construct(){
        parent::__construct();
        $this->SellerMessageModel = new SellerMessageModel;
    }

    /**
     * 消息列表
     */
    public function msgList($params)
    {
        return $this->SellerMessageModel->msgList($params);
    }

    /**
     * 首页轮循 消息中心 显示
     * @param seller_id 商家id
     */
    public function roundMessage($params)
    {
        $data = "";
        $result = $this->SellerMessageModel->roundMessage($params);
        if(count($result) >= 2){// 如果订单数量大于2,则返回订单数量
            $data["create_time"] = 0;
            $data["servicename"] = "";
            $data["count"] = count($result);
        }else{
            foreach($result as $k=>$val){//如果小于,则返回订单数据
                $data["create_time"] = $val["create_time"];
                $data["servicename"] = $val["servicename"];
                $data["count"] = 1;
            }
        }
        return $data;
    }

    /**
     * 所有的未读消息
     * @param seller_id 商家id
     */
    public function unreadMessage($params)
    {
        $msg = $this->SellerMessageModel->unreadMessage($params);
        return count($msg);
    }

}