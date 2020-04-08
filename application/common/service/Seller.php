<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/25
 * Time: 20:56
 */

namespace app\common\service;

use app\common\logic\Seller as SellerLogic;
use app\common\logic\UserIndex as UserIndexLogic;
class Seller extends Base
{
    /***
     * 用户端商家逻辑类
     * @var SellerLogic|null
     */
    protected $sellerLogic = null;

    /***
     * 用户搜索模型
     * @var null
     */
    protected $userIndexLogic = null;

    /**
     * 构造方法
     * SellerStaffLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerLogic = new SellerLogic();
        $this->userIndexLogic = new UserIndexLogic();
    }

    /***
     * 获取所有的商家
     * @param $latitude  [纬度]
     * @param $longitude [经度]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllBiz($params)
    {
        try {
            if(!empty($params['search'])){
                $searchArr = [];//定义搜索数据池
                $searchArr['user_id'] = $params['user_id'];
                $searchArr['keywords'] = $params['search'];
                $this->userIndexLogic->addSearch($searchArr);
            }
            if($params['orderAll'] == 1){
                if(!empty($params['orderComment'])){
                    if($params['orderComment'] == 'desc' || $params['orderComment'] == 'asc'){

                    } else {
                        list($this->status,$this->message) = [0,'参数类型错误'];
                        return;
                    }
                }
                if(!empty($params['orderRange'])) {
                    if ($params['orderRange'] == 'desc' || $params['orderRange'] == 'asc') {

                    } else {
                        list($this->status, $this->message) = [0, '参数类型错误'];
                        return;
                    }
                }
            }
            $getAllBiz = $this->sellerLogic->getAllBiz($params);
            $temArr = []; //临时数据池
            foreach($getAllBiz as $k=>$v){
                $temArr[$k]['id'] = $v['id'];
                if($v['range'] < 1000){
                    $temArr[$k]['range'] = $v['range'].'m';
                } else {
                    $temArr[$k]['range'] =  sprintf("%.1f",($v['range']/1000)).'km';
                }
                $temArr[$k]['address'] = $v['address'];
                $temArr[$k]['sellername'] = $v['sellername'];
                $temArr[$k]['totalComment'] = $v['totalComment'];
                $temArr[$k]['seller_pic3'] = config('token.web_site_domain') . get_file_path($v['seller_pic3']);
            }
            list($this->status, $this->message, $this->data) = [1, '获取成功', $temArr];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }

    /***
     * 获取指定分类下的所有的商家
     * @param $latitude  [纬度]
     * @param $longitude [经度]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllCateBiz($params)
    {
        try {
            if($params['orderAll'] == 1){
                if(!empty($params['orderComment'])){
                    if($params['orderComment'] == 'desc' || $params['orderComment'] == 'asc'){

                    } else {
                        list($this->status,$this->message) = [0,'参数类型错误'];
                        return;
                    }
                }
                if(!empty($params['orderRange'])) {
                    if ($params['orderRange'] == 'desc' || $params['orderRange'] == 'asc') {

                    } else {
                        list($this->status, $this->message) = [0, '参数类型错误'];
                        return;
                    }
                }
            }
            $getAllBiz = $this->sellerLogic->getAllCateBiz($params);
            $temArr = []; //临时数据池
            foreach($getAllBiz as $k=>$v){
                $temArr[$k]['id'] = $v['id'];
                if($v['range'] < 1000){
                    $temArr[$k]['range'] = $v['range'].'m';
                } else {
                    $temArr[$k]['range'] =  sprintf("%.1f",($v['range']/1000)).'km';
                }
                $temArr[$k]['address'] = $v['address'];
                $temArr[$k]['sellername'] = $v['sellername'];
                $temArr[$k]['totalComment'] = $v['totalComment'];
                $temArr[$k]['seller_pic3'] = config('token.web_site_domain') . get_file_path($v['seller_pic3']);
            }
            list($this->status, $this->message, $this->data) = [1, '获取成功', $temArr];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }
    /***
     * 获取商家详情
     * @param $params
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBizDetail($params)
    {
        try{
            $getBizDetail = $this->sellerLogic->getBizDetail($params);
            $strPic = $getBizDetail['seller_pic2'];
            $arrPic = explode(',',$strPic);
            $temPic = [];//店铺图片数据池
            foreach($arrPic as $k=>$v){
                $temPic[$k]['id'] = $v;
                $temPic[$k]['path'] = config('token.web_site_domain') . get_file_path($v);
            }
            $arrCateName = array_filter(explode(',',$getBizDetail['hccatename'])); //去除空格
            $arrCateId = array_filter(explode(',',$getBizDetail['homepage_cate_parent_id'])); //去除空格
            sort($arrCateId);
            $newCateArr = array_combine($arrCateId,$arrCateName);//键值
            $tmpCateName = [];//店铺服务类别数据池
            foreach($newCateArr as $k=>$v){
                $tmpCateName[$k]['id'] = $k;
                $tmpCateName[$k]['catename'] = $v;
            }
            $tmpCateName = array_values($tmpCateName);//去掉数组的键
            list($this->status,$this->message,$this->data) = [1, '获取成功',[
                'sellername'    => $getBizDetail['sellername'],  //店铺名
                'contactphone'  => $getBizDetail['contactphone'],//联系电话
                'address'       => $getBizDetail['address'],     //地址
                'catename'      => $tmpCateName,//服务类别
                'seller_pic2'   => $temPic,     //店铺图片
                'remark'        => $getBizDetail['remark'],
                'start_time'    => $getBizDetail['start_time'],
                'end_time'      => $getBizDetail['end_time'],
                'lon'           => $getBizDetail['lon'],
                'lat'           => $getBizDetail['lat'],
            ]];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'商家详情获取失败'];
        }
    }
    /***
     *  获取商家服务
     */
    public function getBizService($params)
    {
        try{
            $getBizService = $this->sellerLogic->getBizService($params);
            list($this->status,$this->message,$this->data) = [1,'商家服务获取成功',$getBizService];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'商家服务获取失败'];
        }
    }
    /***
     * 服务详情
     */
    public function bizServiceDetail($params)
    {
        try{
            $bizServiceDetail = $this->sellerLogic->bizServiceDetail($params);
            list($this->status,$this->message,$this->data) = [1,'商家服务详情获取成功',[
                'id'          => $bizServiceDetail['id'],
                'seller_id'   => $bizServiceDetail['seller_id'],
                'servicename' => $bizServiceDetail['servicename'],
                'serviceprice'=> $bizServiceDetail['serviceprice'],
                'remark'      => $bizServiceDetail['remark'],
                'start_time'  => $bizServiceDetail['start_time'],
                'end_time'    => $bizServiceDetail['end_time'],
                'catename'    => $bizServiceDetail['catename'],
                'sellername'  => $bizServiceDetail['sellername'],
                'address'     => $bizServiceDetail['address'],
                'seller_pic3' => config('token.web_site_domain') . get_file_path($bizServiceDetail['seller_pic3']),
            ]];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'商家服务详情获取失败'];
        }
    }

    /***
     * 商家端类别下的服务
     * @param $params
     */
    public function getCategoryBizService($params)
    {
        try{
            $getService = $this->sellerLogic->getCategoryBizService($params);
            list($this->status,$this->message,$this->data) = [1,'商家分类服务获取成功',$getService];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'商家分类服务获取失败'];
        }
    }
    /***
     * 查看用户是否收藏商家
     */
    public function isCollectionBiz($params)
    {
        try{
            $isCollectionBiz = $this->sellerLogic->isCollectionBiz($params);
            if(!empty($isCollectionBiz)){
                $collection = 1;//已收藏
                $collectionId = $isCollectionBiz['id'];
            } else {
                $isRemove = $this->sellerLogic->isCollect($params);//查询是否已在收藏列表中,但是被移除
                if(!empty($isRemove)){
                    $collection = 2;//未收藏,但之前收藏过
                    $collectionId = $isRemove['id'];
                } else {
                    $collection = 2;//从未收藏
                    $collectionId = 0;
                }
            }
            list($this->status,$this->message,$this->data) = [1,'获取成功',[
                'collect_id'=>$collectionId, //收藏id
                'is_collect'=>$collection,  //是否收藏,1已收藏,2未收藏
            ]];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }

    /***
     * 用户收藏或取消收藏
     * @param $params
     */
    public function CollectionBiz($params)
    {
        try{
            if($params['is_collect'] == 2){ //未收藏
                $isCollect = $this->sellerLogic->isCollect($params);//查询是否已在收藏列表中
                if(!empty($isCollect)){  //如果在收藏表中
                    $params['is_remove'] = 0;
                    $updateCollect = $this->sellerLogic->updateCollect($params);//更新is_remove为0
                    if($updateCollect){
                        list($this->status,$this->message,$this->data) = [1,'收藏成功',[
                            'collect_id'=>$params['collect_id'], //收藏id
                            'is_collect'=>1,  //是否收藏,1已收藏,2未收藏
                        ]];
                    } else {
                        list($this->status,$this->message) = [0,'收藏失败'];
                    }
                } else { //未在收藏表
                    $collectId = $this->sellerLogic->addCollect($params);//新增收藏
                    if($collectId){
                        list($this->status,$this->message,$this->data) = [1,'收藏成功',[
                            'collect_id'=>$collectId, //收藏id
                            'is_collect'=>1,  //是否收藏,1已收藏,2未收藏
                        ]];
                    } else {
                        list($this->status,$this->message) = [0,'收藏失败'];
                    }
                }
            } elseif($params['is_collect'] == 1){ //已收藏,取消收藏
                $params['is_remove'] = 1;
                $updateCollect = $this->sellerLogic->updateCollect($params);
                if($updateCollect){
                    list($this->status,$this->message,$this->data) = [1,'取消成功',[
                        'collect_id'=>$params['collect_id'], //收藏id
                        'is_collect'=>2,  //是否收藏,1已收藏,2未收藏
                    ]];
                } else {
                    list($this->status,$this->message) = [0,'取消失败'];
                }
            } else {
                list($this->status,$this->message) = [0,'操作失败'];
            }
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'操作失败'];
        }
    }
}