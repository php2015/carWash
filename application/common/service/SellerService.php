<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/14
 * Time: 16:05
 */
namespace app\common\service;

use app\common\logic\SellerStore as SellerStoreLogic;
use app\common\logic\SellerService as SellerServiceLogic;

class SellerService extends Base
{
    /**
     * 商家服务逻辑类
     * @var SellerServiceLogic|null
     */
    protected $sellerServiceLogic = null;
    /***
     * 商家逻辑类
     * @var null
     */
    protected $sellerStoreLogic = null;
    /**
     * 构造方法
     * SellerStaffLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerStoreLogic = new SellerStoreLogic();
        $this->sellerServiceLogic = new SellerServiceLogic();
    }

    /***
     * 获取当前商家所有的服务
     * @param $sellerId
     */
    public function getAllService($sellerId)
    {
        try{
            $allService = $this->sellerServiceLogic->getAllService($sellerId);
            list($this->status,$this->message,$this->data) = [1, '获取成功',$allService];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }

    /***
     * 获取服务详情
     * @param $id
     * @param $sellerId
     */
    public function catServiceDetail($id,$sellerId)
    {
        try{
            $catDetail = $this->sellerServiceLogic->catServiceDetail($id,$sellerId);
            list($this->status,$this->message,$this->data) = [1,'获取成功',$catDetail];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }
    /***
     * 新增服务时获取有子分类的营业项目
     */
    public function getBusinessType($params)
    {
        try{
            $getBusiness = $this->sellerStoreLogic->getDoBusiness($params);
            if(empty($getBusiness)){
                list($this->status,$this->message) = [0,'暂无服务类别,请联系平台'];
                return;
            }
            list($this->status,$this->message,$this->data) = [1,'获取成功',$getBusiness];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }
    /***
     * 新增服务时获取服务级别
     */
    public function getBusinessLevel($parentId)
    {
        try{
            if($parentId == 0){
                list($this->status,$this->message) = [0,'参数错误'];
                return;
            }
            $getBusinessLevel = $this->sellerStoreLogic->getBusinessLevel($parentId);
            list($this->status,$this->message,$this->data) = [1,'获取成功',$getBusinessLevel];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }
    /***
     * 新增服务
     */
    public function addService($params)
    {
        try{
            $validate = validate('SellerService');
            if(!$validate->check($params,[],'addService')){
                list($this->status,$this->message) = [0,$validate->getError()];
                return;
            }
            $addService = $this->sellerServiceLogic->addService($params);
            if($addService){
                list($this->status,$this->message) = [1,'您的服务已经提交申请,待平台审核通过后,即可开始使用'];
            } else {
                list($this->status,$this->message) = [0,'新增服务失败'];
            }
        }catch(\Exception $e) {
            list($this->status,$this->message) = [0,'新增服务失败'];
        }
    }
}