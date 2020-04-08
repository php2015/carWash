<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/17
 * Time: 10:24
 */

namespace app\common\service;

use think\Db;
use think\helper\Hash;
use app\common\logic\SellerStaff as SellerStaffLogic;  //商家员工
use app\common\logic\SellerStore as SellerStoreLogic;

/***
 * 商家店铺信息业务类
 * Class SellerStore
 * @package app\common\service
 */
class SellerStore extends Base
{
    /**
     * 商家店铺服务逻辑类
     * @var SellerStoreLogic|null
     */
    protected $sellerStoreLogic = null;
    /***
     * 商家员工逻辑类
     * @var null
     */
    protected $sellerStaff = null;
    /**
     * 构造方法
     * SellerStaffLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerStoreLogic = new SellerStoreLogic();
        $this->sellerStaffLogic = new SellerStaffLogic();
    }

    /***
     * 商家入驻
     * @param $params
     */
    public function SellerEnter()
    {
        try{
            $getProvince = $this->sellerStoreLogic->getProvince();
            $getBusiness = $this->sellerStoreLogic->getBusiness();
            if(empty($getProvince)){
                list($this->status,$this->message) = [0,'暂未添加省份,请联系平台'];
            }
            if(empty($getBusiness)){
                list($this->status,$this->message) = [0,'暂未添加营业项目,请联系平台'];
            }
            list($this->status,$this->message,$this->data) = [1,'获取成功',[
                'provinces_id'           => $getProvince,
                'homepage_cate_parent_id'=> $getBusiness,
            ]];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }

    /***
     * 商家入驻申请
     * @param $params
     */
    public function SellerEnterApply($params)
    {
        try{
            $lonLat = addResstoLatLag($params['address']);
            $areaCode = addResstoIdCard($params['address']);
            if(false == $lonLat || false == $areaCode){
                list($this->status,$this->message) = [0,'请填写正确的详细地址'];
                return;
            }

            $validate = validate('Store');
            if(!$validate->check($params,[],'apply')){
                list($this->status,$this->message) = [0,$validate->getError()];
                return;
            }
            $validateMobile = $this->sellerStaffLogic->getStaffMobile($params['contactphone']); //验证电话号码是否唯一
            if(!empty($validateMobile)){
                list($this->status,$this->message) = [0,'商家已入驻,请勿重复申请'];
                return;
            }
            $params['area_code'] = $areaCode;
            $params['lonlat'] = $lonLat;
            $params['lon'] = explode(',',$params['lonlat'])[0];//纬度
            $params['lon_floor'] = intval(explode(',',$params['lonlat'])[0]);//纬度精确值
            $params['lat'] = explode(',',$params['lonlat'])[1];//经度
            $params['lat_floor'] = intval(explode(',',$params['lonlat'])[1]);//经度精确值
            Db::startTrans();//开启事务
            $sellerId = $this->sellerStoreLogic->SellerEnterApply($params);
            if($sellerId){
                $addPosition = [];
                $addPosition['seller_id'] = $sellerId;//商家id
                $addPosition['position'] = config('sundrys.shopowner');//职位名称
                $addPosition['role_node'] = config('sundrys.sellerrole');//权限节点
                $addPosition['create_time'] = time();
                $positionId = $this->sellerStoreLogic->addPosition($addPosition);
                if($positionId){
                    $addStaff = [];
                    $addStaff['seller_id'] = $sellerId;
                    $addStaff['seller_position_id'] = $positionId;
                    $addStaff['staffname'] = $params['shopkeeper'];//店主姓名
                    $addStaff['mobile'] = $params['contactphone']; //联系电话
                    $addStaff['password'] = Hash::make(config('sundrys.password'));//默认密码
                    $addStaff['is_shopkeeper'] = 1;//是否是店长,0不是|1是
                    $addStaff['create_time'] = time();
                    $staffId = $this->sellerStoreLogic->addStaff($addStaff);
                    if($staffId){
                        Db::commit();
                        list($this->status,$this->message) = [1,'尊敬的'.$params['shopkeeper'].',您的申请已经提交,业务经理将在24小时内与你联系,请保持电话畅通'];
                    } else {
                        Db::rollback();
                        list($this->status,$this->message) = [0,'申请失败'];
                    }
                } else {
                    Db::rollback();
                    list($this->status,$this->message) = [0,'申请失败'];
                }
            } else {
                Db::rollback();
                list($this->status,$this->message) = [0,'申请失败'];
            }
        }catch(\Exception $e){
            Db::rollback();
            list($this->status,$this->message) = [0,'申请失败'];
        }
    }
    /***
     * 获取当前商家店铺信息
     * @param $sellerId
     */
    public function getStoreInfo($sellerId)
    {
        try{
            $sellerInfo = $this->sellerStoreLogic->getStoreInfo($sellerId);
            //$comments['seller_id'] = $sellerId;
            //$comments['type'] = 0;
            //$comments['page'] = 0;
            //$getStoreComment = $this->sellerStoreLogic->getStoreComment($comments);//获取当前店铺评论,默认十条数据
            //$commentCount = $this->sellerStoreLogic->SellerCommentCount($sellerId);//获取当前店铺的评论总数
            $strPic = $sellerInfo['seller_pic2'];
            $arrPic = explode(',',$strPic);
            $temPic = [];
            foreach($arrPic as $k=>$v){
                $temPic[$k]['id'] = $v;
                $temPic[$k]['path'] = config('token.web_site_domain') . get_file_path($v);
            }
            list($this->status,$this->message,$this->data) = [1, '获取成功',[
                'sellername'    => $sellerInfo['sellername'],  //店铺名
                'contactphone'  => $sellerInfo['contactphone'], //联系电话
                'address'       => $sellerInfo['address'],   //地址
                'start_time'    => $sellerInfo['start_time'],//开始营业时间
                'end_time'      => $sellerInfo['end_time'],  //结束营业时间
                'catename'      => str_replace(',', '/', $sellerInfo['catename']),//服务类别
                'seller_pic2'   => $temPic, //店铺图片
                'seller_pic3'   => ['id'=>$sellerInfo['seller_pic3'],'path'=>config('token.web_site_domain') . get_file_path($sellerInfo['seller_pic3'])],
                //'comment'       => $getStoreComment,
                //'commentCount'  => $commentCount,
            ]];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }

    /***
     * 获取店铺编辑信息
     * @param $sellerId
     */
    public function getEditStoreInfo($sellerId)
    {
        try{
            $getEditStoreInfo = $this->sellerStoreLogic->getStoreInfo($sellerId);
            $strPic = $getEditStoreInfo['seller_pic2'];
            $arrPic = explode(',',$strPic);
            $temPic = [];
            foreach($arrPic as $k=>$v){
                $temPic[$k]['id'] = $v;
                $temPic[$k]['path'] = config('token.web_site_domain') . get_file_path($v);
            }
            $temDescrPic = ['id'=>$getEditStoreInfo['seller_pic3'],'path'=>config('token.web_site_domain') . get_file_path($getEditStoreInfo['seller_pic3'])];
            list($this->status,$this->message,$this->data) = [1, '获取成功',[
                'sellername'    => $getEditStoreInfo['sellername'],  //店铺名
                'contactphone'  => $getEditStoreInfo['contactphone'], //联系电话
                'start_time'    => $getEditStoreInfo['start_time'],//开始营业时间
                'end_time'      => $getEditStoreInfo['end_time'],  //结束营业时间
                'catename'      => str_replace(',', '/', $getEditStoreInfo['catename']),//服务类别
                'seller_pic2'   => $temPic, //店铺图片
                'seller_pic3'   => $temDescrPic,//店铺介绍图
            ]];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }
    /***
     * 更新店铺信息
     * @param $params
     */
    public function updateStoreInfo($params)
    {
        try{
            $validate = validate('Store');
            if(!$validate->check($params,[],'update')){
                list($this->status,$this->message) = [0,$validate->getError()];
                return;
            }
            $sellerId = $params['seller_id'];
            unset($params['seller_id']);
            $updateStoreInfo = $this->sellerStoreLogic->updateStoreInfo($sellerId, $params);
            if($updateStoreInfo){
                list($this->status,$this->message) = [1,'更新成功'];
            } else {
                list($this->status,$this->message) = [0,'更新失败'];
            }
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'更新失败'];
        }
    }
}