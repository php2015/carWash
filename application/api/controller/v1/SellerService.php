<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/14
 * Time: 15:58
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\SellerService as SellerServiceService;
/***
 * 商家服务控制器
 * Class SellerService
 * @package app\api\controller\v1
 */
class SellerService extends Base
{
    /**
     * 商家端服务业务类
     * @var SellerServiceService|null
     */
    protected $sellerServiceService = null;

    /***
     * 重写构造函数
     * SellerService constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->sellerServiceService = new SellerServiceService();
    }

    /***
     * 获取当前商家的所有服务
     * @param $seller_id [商家id]
     */
    public function getAllService()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->sellerServiceService->getAllService($params['seller_id']);
        list($this->status,$this->message,$this->data) = [
            $this->sellerServiceService->status,
            $this->sellerServiceService->message,
            $this->sellerServiceService->data,
        ];
    }
    /***
     * 查看服务详情
     * @param $id [商家服务id]
     * @param $seller_id [商家id]
     */
    public function catServiceDetail()
    {
        $params = [
            'id' => input('id/d',0),
            'seller_id' => $this->sellerid,
        ];
        $this->sellerServiceService->catServiceDetail($params['id'],$params['seller_id']);
        list($this->status,$this->message,$this->data) = [
            $this->sellerServiceService->status,
            $this->sellerServiceService->message,
            $this->sellerServiceService->data,
        ];
    }
    /***
     * 新增服务时获取有子分类的营业项目
     */
    public function getBusinessType()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->sellerServiceService->getBusinessType($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerServiceService->status,
            $this->sellerServiceService->message,
            $this->sellerServiceService->data,
        ];
    }
    /***
     * 新增时获取服务级别
     */
    public function getBusinessLevel()
    {
        $params = [
            'parent_id' => input('id/d',0),
        ];
        $this->sellerServiceService->getBusinessLevel($params['parent_id']);
        list($this->status,$this->message,$this->data) = [
            $this->sellerServiceService->status,
            $this->sellerServiceService->message,
            $this->sellerServiceService->data,
        ];
    }
    /***
     * 新增服务
     */
    public function addService()
    {
        $params = [
            'seller_id' => $this->sellerid, //商家id
            'homepage_cate_parent_id' => input('homepage_cate_parent_id/d', 0),//服务类别
            'homepage_cate_id' => input('homepage_cate_id/d', 0),//服务级别
            'servicename' => input('servicename', '', 'trim'),//服务名称
            'serviceprice' => input('serviceprice', '', 'trim'),//服务价格
            'remark' => input('remark', '', 'trim'),//服务详情
            'is_timescard' => input('is_timescard/d',0),      //是否支持次卡
        ];
        $this->sellerServiceService->addService($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerServiceService->status,
            $this->sellerServiceService->message,
            $this->sellerServiceService->data,
        ];
    }
}