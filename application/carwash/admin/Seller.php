<?php
/**
 * 总平台商家管理模块
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/8/31
 * Time: 16:39
 */
namespace app\carwash\admin;

use think\Db;
use think\Request;
use think\Controller;
use think\helper\Hash;
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;

class Seller extends Admin
{
    private $tableName = 'dp_seller';
    /**
     *  总平台商家首页信息
     */
    public function index()
    {
        cookie('__sellerIndex__', $_SERVER['REQUEST_URI']);
        $condition = $this->getMap();
        $recommendList = [0=>'未推荐',1=>'推荐'];//是否推荐
        $isReview = [0=>'待处理',1=>'已加盟'];//是否加盟
        $hccatename = model('SellerService')->getHomePageCate();//营业项目
        $hccatenameArr =  []; //组装营业项目的数据
        foreach ($hccatename as $k=>$v){
            $hccatenameArr[$v['catename']] = $v['catename'];
        }
        if(isset($condition['hccatename'])){ //封装营业项目的筛选
            $condition['hccatename'] = ['like','%'.$condition['hccatename'].'%'];
        }
        try{
            $queryAllSeller = model('Seller')->queryAll($condition);
        }catch(\Exception $e){
            $this->error('商家信息获取失败');
        }
        return ZBuilder::make('table')
            ->setTableName('seller')
            ->setPageTitle('商家列表')
            ->setSearch(['sellername' => '商户名', 'shopkeeper' => '店长', 'contactphone'=>'联系电话','vmphone'=>'业务经理','areaname'=>'省份'])
            ->setPrimaryKey('id')
            ->hideCheckbox()
            ->addColumns([
                ['id', 'ID'],
                ['sellername', '商户名'],
                ['shopkeeper', '店主姓名'],
                ['contactphone','联系电话'],
                ['staffnum', '员工数量'],
                ['hccatename', '营业项目'],
                ['areaname', '省份'],
                ['address', '详细地址'],
                ['lonlat', '地址经纬度'],
                ['yyetime', '营业时间'],
                ['nowbalance', '账户余额'],
                //['fee', '提现比例','text.edit'],
                ['vmphone','业务经理'],
                ['order_num','排序值','number'],
                ['is_recommend','首页推荐','switch'],
                ['create_time','创建时间','datetime'],
                ['update_time','加盟时间','datetime'],
                ['is_review','加盟状态','select',[0=>'待处理',1=>'已加盟']],
                ['is_disabled','是否下架','switch'],//状态
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add') // 批量添加顶部按钮
            ->addTopButton('custom', [
                'title' => '导出商家EXCEL',
                'icon'  => 'fa fa-fw fa-print',
                'href'  => url('exportSellerData')
            ])
            ->addRightButton('project', [
                'title' => '查看营业项目',
                'icon' => 'fa fa-fw fa-tripadvisor',
                'href' => url('showService', ['id' => '__id__'])
            ], [
                'area' => ['30%', '30%'],
                'title' => '查看营业项目'
            ])
            ->addRightButton('leibie', [
                'title' => '查看收款类别',
                'icon' => 'fa fa-fw fa-rmb',
                'href' => url('accountType', ['id' => '__id__'])
            ], [
                'area' => ['60%', '40%'],
                'title' => '查看收款类别'
            ])
            ->addRightButton('catsellerorder', [
                'title' => '查看商家订单',
                'icon'  => 'fa fa-fw fa-bar-chart',
                'href'  => url('catSellerOrder', ['id' => '__id__'])
            ])
            ->addRightButton('showsellerservice', [
                'title' => '查看商家服务',
                'icon'  => 'fa fa-fw fa-eye',
                'href'  => url('showSellerService', ['id' => '__id__'])
            ])
            ->addRightButton('editseller', [
                'title' => '编辑商家',
                'icon'  => 'fa fa-fw fa-pencil',
                'href'  => url('editSeller', ['id' => '__id__'])
            ])
            ->addRightButton('project', [
                'title' => '修改店长密码',
                'icon' => 'fa fa-fw fa-key',
                'href' => url('editShopownerPwd', ['id' => '__id__'])
            ], [
                'area' => ['40%', '40%'],
                'title' => '修改店长密码'
            ])
            ->addTopSelect('is_recommend', '首页推荐', $recommendList)
            ->addTopSelect('hccatename', '营业项目', $hccatenameArr)
            ->addTopSelect('is_review', '加盟状态', $isReview)
            ->setColumnWidth('right_button', 180)
            ->setRowList($queryAllSeller) // 设置表格数据
            ->assign('empty_tips', '没有任何数据')
            ->fetch(); // 渲染页面
    }

    /***
     * 编辑商家
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function editSeller($id)
    {
        if(request()->isPost()){
            $updateSellerData = request()->post('', null, 'trim');
            $updateSeller = $this->validateData($updateSellerData,'update');
            $updateSellerId = $updateSeller['id'];
            $updateSeller['update_time'] = time();
            unset($updateSeller['id']);//unset没有返回值,不可赋值给变量

            $comparePhone = model('Seller')->editSeller($id);
            if($comparePhone['contactphone'] != $updateSellerData['contactphone'] || $comparePhone['shopkeeper'] !=  $updateSellerData['shopkeeper']){ //如果商家联系方式或者店主名发生变化,则更改店主信息
                if($comparePhone['contactphone'] != $updateSellerData['contactphone']) {
                    $querySellerStaffMobile = model('Seller')->querySellerStaffMobile($updateSellerData['contactphone']);
                    if(!empty($querySellerStaffMobile)){
                        return exception('商家电话号码已存在');
                    }
                }
                //查询店主id
                $dianZhuId = model('Seller')->querySellerStaffId($comparePhone['contactphone']);
                if(empty($dianZhuId)){
                    return exception('店主信息查询失败');
                }
                Db::startTrans();
                $updateLoginMobile = model('Seller')->editShopownerInfo($dianZhuId['id'],$updateSellerData['contactphone'],$updateSellerData['shopkeeper']);
                if($updateLoginMobile){
                    $updateSellerResult = model('Seller')->updateSeller($updateSellerId,$updateSeller);
                    if($updateSellerResult){
                        Db::commit();
                        action_log($this->tableName . '_update', $this->tableName, $updateSellerId, UID, $updateSeller['sellername']);
                        $this->success('商户 '.$updateSeller['sellername'].' 信息已更新',cookie('__sellerIndex__'));
                    } else {
                        Db::rollback();
                        $this->error('商户 '.$updateSeller['sellername'].' 信息更新失败');
                    }
                } else {
                    Db::rollback();
                    $this->error('商户 '.$updateSeller['sellername'].' 信息更新失败');
                }

            } else {
                $updateSellerResult = model('Seller')->updateSeller($updateSellerId,$updateSeller);
                if($updateSellerResult){
                    action_log($this->tableName . '_update', $this->tableName, $updateSellerId, UID, $updateSeller['sellername']);
                    $this->success('商户 '.$updateSeller['sellername'].' 信息已更新',cookie('__sellerIndex__'));
                } else {
                    $this->error('商户 '.$updateSeller['sellername'].' 信息更新失败');
                }
            }
        }
        try{
            $editSeller = model('Seller')->editSeller($id);
        }catch(\Exception $e){
            $this->error('商家信息查询失败');
        }
        $provincesList = $this->getProvinces();//获取省份城市
        $getHomePageCateList = $this->getHomePageCate();//获取首页分类
        return ZBuilder::make('form')
            ->setPageTitle('编辑商家')
            ->addHidden('id')
            ->addText('sellername', '商户名称[:* 请输入商户名称]')
            ->addText('shopkeeper', '店主姓名[:* 请输入店主姓名]')
            ->addSelect('provinces_id', '省份城市[:请选择一项]', '', $provincesList)
            ->addTextarea('address', '详细地址[:*请输入详细地址,例: xx 省 xx 市 xx 区/县 xx 镇 xx 街道]')
            ->addCheckbox('homepage_cate_parent_id', '选择营业项目', '', $getHomePageCateList)
            ->addTime('start_time', '开始营业时间', '', '', 'HH:mm')
            ->addTime('end_time', '结束营业时间', '', '', 'HH:mm')
            ->addText('contactphone', '联系电话[:* 请输入联系电话]')
            ->addText('vmphone', '业务经理[:* 请输入业务经理]')
            //->addText('fee', '提现比例[:* 请输入提现比例]')
            //->addImage('seller_pic1', '营业执照', '', '', '', '', '', ['size' => '690,300'])
            //->addFormItems([
            //    ['images', 'seller_pic2', '店铺图片', '', '', '', '', '', ['size' => '690,300']]
            //])
            //->addImage('seller_pic3', '店铺介绍图', '', '', '', '', '', ['size' => '690,300'])
            ->addUpload('seller_pic1',$this->setUploadImgParams('*营业执照','1','690','300'),$editSeller['seller_pic1'])
            ->addUpload('seller_pic2',$this->setUploadImgParams('*店铺图片(需上传三张)','3','690','300'),$editSeller['seller_pic2'])
            ->addUpload('seller_pic3',$this->setUploadImgParams('*店铺介绍图','1','690','300'),$editSeller['seller_pic3'])
            ->addTextarea('remark', '备注[:最多150字]')
            ->addRadio('is_review', '状态', '', ['1' => '已加盟', '0' => '待处理 '])
            ->setFormData($editSeller)
            ->submitConfirm()
            ->fetch();
    }
    /***
     * 导出商家EXCEL
     */
    public function exportSellerData()
    {
        $exportName='商家列表';
        //设置表头
        $exportSellerHeader=['ID','营业项目id','商户名称','店主姓名','联系电话','员工数量','省份','详细地址','地址经纬度','营业时间','账户余额','业务经理','排序值','首页推荐','创建时间','加盟时间','加盟状态','是否下架','营业项目'];
        try{
            $exportSellerData = model('Seller')->exportSellerData();
            excelExport($exportName,$exportSellerHeader,$exportSellerData);
        }catch(\Exception $e){
            $this->error('服务器内部错误,导出失败');
        }
    }

    /***
     * 修改店长密码
     * @param $id
     * @throws \think\Exception
     */
    public function editShopownerPwd($id)
    {
        if(request()->isPost()){
            $pwd = request()->post('', null, 'trim');
            $validate = validate('ValidatePwd');
            if(!$validate->check($pwd)){
                return exception($validate->getError());
            }
            $positionId = model('Seller')->queryPositionId($pwd['id']); //查找职位id
            $hashPwd = Hash::make($pwd['password']);
                try{
                    $updateShopownerPwd = model('Seller')->editShopownerPwd($pwd['id'],$positionId['id'],$hashPwd);
                } catch(\Exception $e){
                    $this->error('密码修改失败' , null, ['_parent_reload' => 1]);
                }
                if($updateShopownerPwd){
                    action_log('dp_seller_staff_update', 'dp_seller_staff', $id, UID, $hashPwd);
                    $this->success('密码修改成功', null, ['_parent_reload' => 1]);
                } else {
                    $this->error('密码修改失败' , null, ['_parent_reload' => 1]);
                }

        }
        return ZBuilder::make('form')
            ->setPageTitle('修改店主密码')
            ->addHidden('id')
            ->addText('password', '修改店主密码[:* 请输入密码]')
            ->addText('password_confirm', '确认密码[:* 请输入密码]')
            ->addHidden('id',$id)
            ->submitConfirm()
            ->fetch();
    }

    /***
     * 查看账号类别
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function accountType($id)
    {
        //对应商家的提现账号列表
        $queryAccountType = model('Seller')->payType($id);
        return ZBuilder::make('table')
            ->setPageTitle('查看账号类别') // 设置页面标题
            ->hideCheckbox()
            ->addColumns([ // 批量添加列
                ['__INDEX__', '编号'],
                ['account_type', '账号类别', 'status', '', [0=>'未知',1 => '支付宝', 2=>'微信',3=>'银行卡']],
                ['account', '账号'],
                ['account_name', '持卡人姓名'],
                ['mobile', '持卡人手机号'],
            ])
            ->setRowList($queryAccountType) // 设置表格数据
            ->assign('empty_tips', '没有任何数据')
            ->fetch(); // 渲染页面
    }

    /***
     * 查看营业项目
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function showService($id)
    {
        try{
            $showService = model('Seller')->showService($id);
        }catch(\Exception $e){
            $this->error('营业项目获取失败');
        }
        return ZBuilder::make('table')
            ->setPageTitle('查看营业项目')
            ->hideCheckbox()
            ->addColumns([ // 批量添加列
                ['__INDEX__', '编号'],
                ['catename', '营业项目'],
            ])
            ->setRowList($showService) // 设置表格数据
            ->assign('empty_tips', '没有任何数据')
            ->fetch(); // 渲染页面
    }

    /***
     * 查看商家下面的服务
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function showSellerService($id)
    {
        cookie('__showSellerService__', $_SERVER['REQUEST_URI']);
        $condition = $this->getMap();
        try{
            $showSellerService = model('Seller')->showSellerService($id,$condition);
        }catch(\Exception $e){
            $this->error('服务获取失败');
        }
        $searchCard = [1=>'权益卡',2=>'次数卡'];//所属卡种
        $searchCate = $this->getHomePageCateName();
        return ZBuilder::make('table')
            ->setPageTitle('查看商家服务')
            ->hideCheckbox()
            ->setSearch(['servicename' => '服务名称'])
            ->addColumns([ // 批量添加列
                ['__INDEX__', '编号'],
                ['servicename', '服务名称'],
                ['catename', '所属类别'],
                ['serviceprice', '服务价格'],
                ['is_timescard', '是否支持次卡','status','',[0=>'不支持',1=>'支持']],
                ['create_time', '申请时间','datetime'],
                ['update_time', '审核时间','datetime'],
                ['settlement_type', '结算卡种', 'status', '', [''=>'暂无结算',1 => '次数卡', 2=>'权益卡']],
                ['servicetimes', '消费次数'],
                ['is_release', '状态', 'status', '', ['禁用', '启用']],
                ['right_button', '操作', 'btn']
            ])
            ->addRightButton('custom', [
                'title' => '编辑',
                'icon'  => 'fa fa-fw fa-pencil',
                'href'  => url('editSellerService', ['id' => '__id__'])
            ])
            ->addRightButton('custom', [
                'title' => '删除',
                'icon'  => 'fa fa-fw fa-remove',
                'class' => 'btn btn-xs btn-default ajax-get confirm',
                'href'  => url('delSellerService', ['id' => '__id__']),
                'data-title' => '真的要删除吗'
            ])
            ->setRowList($showSellerService)
            ->addTopSelect('settlement_type', '所属卡种', $searchCard)
            ->addTopSelect('catename', '所属类别', $searchCate)
            ->addTimeFilter('dp_seller_service.create_time', '', ['开始时间', '结束时间'])
            ->assign('empty_tips', '没有任何数据')
            ->fetch();
    }

    /***
     * 编辑商家服务
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function editSellerService($id)
    {
        if(request()->isPost()){

            $editSellerServiceData = request()->post('', null, 'trim');
            $reg = '/^[0-9]+(.[0-9]{1,2})?$/';//整数或者2位小数
            $servicePrice = $editSellerServiceData['serviceprice'];
            if(!preg_match($reg, $servicePrice)) exception('金额请输入正确的值');
            $updateSellerServiceData['serviceprice'] = $editSellerServiceData['serviceprice'];//金额
            $updateSellerServiceData['is_startrights'] = $editSellerServiceData['is_startrights'];//是否开启权益卡
            $updateSellerServiceData['is_timescard'] = $editSellerServiceData['is_timescard'];//是否支持次卡
            $updateSellerServiceData['is_release'] = $editSellerServiceData['is_release'];//是否启用
            $updateSellerServiceData['update_time'] = time();//更新时间
            $service_id = $editSellerServiceData['id']; //id
                try{
                    $updateSellerService = model('Seller')->updateSellerService($service_id,$updateSellerServiceData);
                }catch(\Exception $e){
                    $this->error('商家服务'.$editSellerServiceData['servicename'].'更新失败');
                }
                if($updateSellerService){
                    action_log('dp_seller_service_update', 'dp_seller_service', $service_id, UID, $editSellerServiceData['servicename']);
                    $this->success('商家服务'.$editSellerServiceData['servicename'].'已更新',cookie('__showSellerService__'));
                } else {
                    $this->error('商家服务'.$editSellerServiceData['servicename'].'更新失败');
                }
        }
        $editSellerService = model('Seller')->editSellerService($id);
        return ZBuilder::make('form')
        ->setPageTitle('编辑商家服务')
        ->addStatic('servicename', '服务名称')
        ->addStatic('catename', '服务类别')
        ->addText('serviceprice', '服务价格')
        ->addRadio('is_startrights', '是否开启权益卡', '', [1 => '开启', 0 => '关闭 '], '', '','disabled')
        ->addRadio('is_timescard', '是否支持次卡', '', [1 => '支持', 0 => '不支持 '], '', '','disabled')
        ->addRadio('is_release', '状态', '', [1 => '启用', 0 => '禁用'], '', '','disabled')
        ->addHidden('id')
        ->addHidden('servicename')
        ->setFormData($editSellerService)
        ->submitConfirm()
        ->fetch();
    }

    /***
     * 删除商家服务
     * @param $id
     */
    public function delSellerService($id)
    {
        try{
            $delSellerService = model('Seller')->delSellerService($id);
        }catch(\Exception $e){
            $this->error('删除失败');
        }
        if($delSellerService){
            action_log('dp_service_add', 'dp_service_add', $id, UID, $id);
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /***
     * 新增商家
     * @return mixed
     * @throws \think\Exception
     */
    public function add()
    {   
        //添加逻辑
        if(request()->isPost()){

            $addSeller = request()->post('', null, 'trim');
            if(!empty(model('Seller')->querySellerStaffMobile($addSeller['contactphone']))){
                return exception('商家联系电话号码已存在');
            }
            $addSeller = $this->validateData($addSeller,'add');
            Db::startTrans(); //开启事务,在添加商家成功之后,添加店主账号
                try{
                    $addSellerId = model('Seller')->add($addSeller); //返回插入的商家id
                }catch (\Exception $e){
                    Db::rollback();
                    $this->error('新增商家失败');
                }
            if($addSellerId){
                $addPosition = [];
                $addPosition['seller_id'] = $addSellerId;//商家id
                $addPosition['position'] = config('sundrys.shopowner');//职位名称
                $addPosition['role_node'] = config('sundrys.sellerrole');//权限节点
                $addPosition['create_time'] = time();
                    try{
                        $addPositionId = model('Seller')->addPosition($addPosition);
                    }catch(\Exception $e) {
                        Db::rollback();
                        $this->error('新增商家失败 生成店主失败');
                    }
                if($addPositionId){
                    //查询员工表联系电话是否唯一
                    if(!empty(model('Seller')->querySellerStaffMobile($addSeller['contactphone']))){
                        Db::rollback();
                        return exception('商家联系电话号码已存在');
                    }
                    $addStaff = [];
                    $addStaff['seller_id'] = $addSellerId;
                    $addStaff['seller_position_id'] = $addPositionId;
                    $addStaff['staffname'] = $addSeller['shopkeeper'];
                    $addStaff['mobile'] = $addSeller['contactphone'];
                    $addStaff['password'] = Hash::make(config('sundrys.password'));//默认密码
                    $addStaff['is_shopkeeper'] = 1;//是否是店长,0不是|1是
                    $addStaff['create_time'] = time();
                        try{
                            $addStaffId = model('Seller')->addStaff($addStaff);
                        }catch(\Exception $e){
                            Db::rollback();
                            $this->error('新增商家失败 店主生成失败');
                        }
                    if($addStaffId){
                        Db::commit();
                        $this->success('新增商家 '.$addSeller['sellername'].'成功','Seller/index');
                    } else {
                        Db::rollback();
                        $this->error('新增商家失败 店主生成失败');
                    }
                } else {
                    Db::rollback();
                    $this->error('新增商家失败 店主生成失败');
                }
            } else {
                Db::rollback();
                $this->error('新增商家失败');
            }
        }
        $provincesList = $this->getProvinces();//获取省份城市
        $getHomePageCateList = $this->getHomePageCate();//获取首页分类
        if(empty($provincesList) || empty($getHomePageCateList)){
            $this->error('请先添加省份城市或营业项目再添加商户');
        }
        //渲染页面
        return ZBuilder::make('form')
            ->setPageTitle('新增商家')
            ->addText('sellername', '商户名称[:* 请输入商户名称]')
            ->addText('shopkeeper', '店主姓名[:* 请输入店主姓名]')
            ->addSelect('provinces_id', '省份城市[:请选择一项]', '', $provincesList)
            ->addTextarea('address', '详细地址[:*请输入详细地址,例: xx 省 xx 市 xx 区/县 xx 镇 xx 街道]')
            ->addCheckbox('homepage_cate_parent_id', '选择营业项目', '', $getHomePageCateList)
            ->addTime('start_time', '开始营业时间', '', '', 'HH:mm')
            ->addTime('end_time', '结束营业时间', '', '', 'HH:mm')
            ->addText('contactphone', '联系电话[:* 请输入联系电话]')
            ->addText('vmphone', '业务经理[:* 请输入业务经理]')
            //->addText('fee', '提现比例[:* 请输入提现比例]')
            //->addImage('seller_pic1', '营业执照', '', '', '', '', '', ['size' => '690,300'])
            //->addFormItems([
            //    ['images', 'seller_pic2', '店铺图片', '', '', '', '', '', ['size' => '690,300']]
            //])
            //->addImage('seller_pic3', '店铺介绍图', '', '', '', '', '', ['size' => '690,300'])
            ->addUpload('seller_pic1',$this->setUploadImgParams("*营业执照",'1','690','300'))
            ->addUpload('seller_pic2',$this->setUploadImgParams("*店铺图片(需上传三张)",'3','690','300'))
            ->addUpload('seller_pic3',$this->setUploadImgParams('*店铺介绍图','1','690','300'))
            ->addTextarea('remark', '商家介绍[:最多150字]')
            ->addRadio('is_review', '状态', '', ['1' => '已加盟', '0' => '待处理 '])
            ->submitConfirm()
            ->fetch();
    }

    /***
     * 查看商家订单记录
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function catSellerOrder($id)
    {
        $orderRecordSearch = $this->getMap();
            try{
                $orderRecord = model('Seller')->orderRecord($id,$orderRecordSearch);
            }catch(\Exception $e){
                $this->error($e->getMessage());
            }
        return ZBuilder::make('table')
            ->setPageTitle('订单记录')
            ->setSearch(['nickname' =>'用户名' , 'servicename' => '服务名称', 'catename'=>'所属类别','order_number'=>'交易单号','staffname'=>'订单处理人'])
            ->hideCheckbox()
            ->addColumns([ // 批量添加列
                ['id','ID'],
                ['nickname', '用户名'],
                ['mobile', '手机号码'],
                ['servicename', '服务名称'],
                ['catename', '所属类别'],
                ['serviceprice', '服务价格'],
                ['settlement_type', '支付方式', 'status', '', [''=>'未知',1 => '次数卡', 2=>'权益卡']],
                ['payprice', '支付金额'],
                ['create_time', '购买时间','datetime'],
                ['order_number', '交易单号'],
                ['staffname', '订单处理人'],
                ['pay_status', '支付状态', 'status', '', [0=>'支付失败',1 => '支付成功', 2=>'未支付']],
            ])
            ->setColumnWidth('id', 30)
            ->setColumnWidth('create_time', 150)
            ->setColumnWidth('order_number', 150)
            ->setRowList($orderRecord) // 设置表格数据
            ->assign('empty_tips', '没有任何数据')
            ->fetch(); // 渲染页面
    }
    /***
     * 获取省份城市
     * @return mixed
     */
    public function getProvinces()
    {
        $provincesList =  []; //声明一个省份城市的空数组
            try {
                $getProvinces = model('Seller')->getProvinces();
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        foreach($getProvinces as $key=>$value){
            $provincesList[$value['id']] =  $value['areaname'];;
        }
        return $provincesList;
    }

    /***
     * 获取营业项目
     * @return array|bool
     */
    public function getHomePageCate()
    {
        $getHomePageCateList = []; //声明营业项目的空数组
        try{
            $getHomePageCate = model('Seller')->getHomePageCate();
        }catch(\Exception $e){
            return false;
        }
        foreach($getHomePageCate as $k=>$v){
            $getHomePageCateList[$v['id']] =  $v['catename'];;
        }
        return $getHomePageCateList;
    }
    /***
     * 获取营业项目,并将键改为值
     * @return array|bool
     */
    public function getHomePageCateName()
    {
        $getHomePageCateName = []; //声明营业项目的空数组
            try{
                $getHomePageCate = model('Seller')->getHomePageCate();
            }catch(\Exception $e){
                return false;
            }
        foreach($getHomePageCate as $k=>$v){
            $getHomePageCateName[$v['catename']] =  $v['catename'];;
        }
        return $getHomePageCateName;
    }
    /***
     * 组装校验商家数据
     * @param $addSeller
     * @throws \Exception
     */
    public function validateData($addSeller,$scene)
    {
        $addSeller['start_time'] = strtotime($addSeller['start_time']); //时间转换为时间戳
        $addSeller['end_time'] = strtotime($addSeller['end_time']); //时间转换为时间戳
        if(!isset($addSeller['homepage_cate_parent_id'])){
            return exception('请选择营业项目');
        }
        $addSeller['homepage_cate_parent_id'] = implode(',',$addSeller['homepage_cate_parent_id']);//营业项目转换为字符串
        $sellerPic2 = $addSeller['seller_pic2'];//校验店铺图片数量
        $arrsellerPic2 = explode(',',$sellerPic2);
        if(count($arrsellerPic2) !== 3){
            return exception('店铺图片限定上传三张');
        }
        $sellerValidate = validate('Seller');//校验数据
        $addSellerValite = $sellerValidate->check($addSeller,[],$scene);
        if(!$addSellerValite){
            return exception($sellerValidate->getError());
        }
        $addSeller['area_code'] = addResstoIdCard($addSeller['address']);
        if(false == $addSeller['area_code']){
            return exception('请填写正确的商家地址');
        }
        $addSeller['lonlat'] = addResstoLatLag($addSeller['address']);
        if(false == $addSeller['lonlat']){
            return exception('请填写正确的商家地址');
        }
        $addSeller['lon'] = explode(',',$addSeller['lonlat'])[0];//纬度
        $addSeller['lon_floor'] = intval(explode(',',$addSeller['lonlat'])[0]);//纬度精确值
        $addSeller['lat'] = explode(',',$addSeller['lonlat'])[1];//经度
        $addSeller['lat_floor'] = intval(explode(',',$addSeller['lonlat'])[1]);//经度精确值
        return $addSeller;
    }

    /***
     * 获取所有的商家
     */
    public function catAllSeller()
    {
        try{
            $catAllSeller = model('Seller')->catAllSeller();
        }catch(\Exception $e){
            return false;
        }
        $temArr =  []; // 声明一个空数组
        foreach($catAllSeller as $key=>$value){
            $temArr[$value['id']] =  $value['sellername'];
        }
        return $temArr;
    }

    /***
     * 获取开户行
     */
    public function bankOfDeposit()
    {
        try{
            $bankOfDeposit = model('Seller')->bankOfDeposit();
        }catch(\Exception $e){
            return false;
        }
        $bankArr =  []; // 声明一个空数组
        foreach($bankOfDeposit as $key=>$value){
            $bankArr[$value['id']] =  $value['name'];
        }
        return $bankArr;
    }

    /***
     * luma 校验银行卡是否正确
     * @param $card [银行卡号]
     * @return bool|string
     */
    public function validateBankNum($card)
    {
        if(empty($card)){
            return false;
        }
        $arr_no = str_split($card);
        $last_n = $arr_no[count($arr_no)-1];
        krsort($arr_no);
        $i = 1;
        $total = 0;
        foreach ($arr_no as $n){
            if($i%2==0){
                $ix = $n*2;
                if($ix>=10){
                    $nx = 1 + ($ix % 10);
                    $total += $nx;
                }else{
                    $total += $ix;
                }
            }else{
                $total += $n;
            }
            $i++;
        }
        $total -= $last_n;
        $total *= 9;
        return $last_n == ($total%10);
    }

    /***
     * 查询商家是否已有启用状态的账号存在
     */
    public function queryCashAccountIsExist($seller_id,$account_type)
    {
        try{
            $addBank = model('Seller')->queryCashAccountIsExist($seller_id,$account_type);
        }catch(\Exception $e) {
            return false;
        }
        if(count($addBank) == 1){
            return false;
        } else {
            return true;
        }
    }

    /***
     * 提现账号列表
     * @return mixed
     * @throws \think\Exception
     */
    public function CashAccountList()
    {
        cookie('__addCashAccount__', $_SERVER['REQUEST_URI']);
        $cashType = [1=>'支付宝',2=>'微信',3=>'银行卡'];
        $bankType = $bankOfDeposit = $this->bankOfDeposit();//银行类别
        $status = [0=>'禁用',1=>'启用'];
        $Search = $this->getMap();
        try{
            $CashAccountList = model('Seller')->CashAccountList($Search);
        }catch(\Exception $e) {
            $this->error('银行卡列表获取失败');
        }
        return ZBuilder::make('table')
            ->setTableName('cash_account')
            ->setPageTitle('提现账号列表')
            ->setSearch(['account'=>'卡号','sellername' => '商户名', 'shopkeeper' => '店主姓名', 'contactphone'=>'联系电话','account_name'=>'中国银行'])
            ->setPrimaryKey('id')
            ->addColumns([
                ['__INDEX__', 'ID'], //编号
                ['sellername', '商户名'],
                ['shopkeeper', '店主姓名'],
                ['idcard', '身份证'],
                ['account_name', '收款人姓名'],
                ['account_type', '账号类型','status','',[1=>'支付宝',2=>'微信',3=>'银行卡']],
                ['account','卡号'],
                ['name','开户行'],
                ['mobile','手机号码'],
                ['status','状态','switch'],//状态
                ['right_button', '操作', 'btn']
            ])
            ->addTopButton('custom', [
                'title' => '新增提现账户',
                'icon'  => 'fa fa-fw fa-plus-square',
                'href'  => url('addCashAccount') //新增提现账户
            ])
            ->addTopButton('delete', ['table' => 'dp_cash_account'])
            ->addRightButton('showsellerservice', [
                'title' => '编辑',
                'icon'  => 'fa fa-fw fa-pencil',
                'href'  => url('editCashAccount', ['id' => '__id__'])
            ])
            ->addRightButton('editseller', [
                'title' => '删除',
                'icon'  => 'fa fa-fw fa-remove',
                'class' => 'btn btn-xs btn-default ajax-get confirm',
                'href'  => url('delCashAccount', ['id' => '__id__']),
                'data-title' => '确认要将当前商家的提现账户删除?'
            ])
            ->setColumnWidth([
                '__INDEX__'  => 30,
                'sellername' => 150,
                'idcard'=>150,
                'account'=>150,
            ])
            ->addTopSelect('ca.account_type', '账号类型', $cashType)
            ->addTopSelect('ca.bank_card_id', '银行类别', $bankType)
            ->addTopSelect('ca.status', '状态', $status)
            ->setRowList($CashAccountList)
            ->assign('empty_tips', '没有任何数据')
            ->fetch();
    }

    /***
     * 新增提现账户 500268199807087564
     * 1支付宝,2微信,3银行卡
     */
    public function addCashAccount()
    {
        if(request()->isPost()){
            $addBankData = request()->post('', null, 'trim');
            if($addBankData['account_type'] == 3){
                $addBankData['account'] = $addBankData['account_3']; //银行卡
                $notice = '银行卡';
                if(empty($addBankData['bank_card_id']))  return exception('请选择开户行');
                $validateBankNum = $this->validateBankNum($addBankData['account']);
                if(false == $validateBankNum){ //校验银行卡号
                    return exception('请输入正确的银行卡号');
                }
            } else if($addBankData['account_type'] == 2) {
                $addBankData['account'] = $addBankData['account_2']; //微信
                $addBankData['mobile'] = $addBankData['wechat_mobile'];
                if(!preg_match('/^(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/', $addBankData['mobile'])) return exception('手机号码格式错误');
                $notice = '微信';
                unset($addBankData['bank_card_id']);//销毁银行卡id
            } else if($addBankData['account_type'] == 1) {
                $addBankData['account'] = $addBankData['account_1']; //支付宝
                $addBankData['mobile'] = $addBankData['alipay_mobile'];
                $notice = '支付宝';
                if(!preg_match('/^(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/', $addBankData['mobile'])) return exception('手机号码格式错误');
                unset($addBankData['bank_card_id']);//销毁银行卡id
            }
            unset($addBankData['account_1']);//去除额外的字段
            unset($addBankData['account_2']);
            unset($addBankData['account_3']);
            unset($addBankData['wechat_mobile']);
            unset($addBankData['alipay_mobile']);
            $addBankData['create_time'] = time();  //添加时间
            $validateAddBank = validate('SellerCashAccount'); //校验添加数据
            $validateAddBankData = $validateAddBank->check($addBankData);
            if(!$validateAddBankData){
                return exception($validateAddBank->getError());
            }
            if(false == $this->queryCashAccountIsExist($addBankData['seller_id'],$addBankData['account_type'])) $this->error('该商家已有'.$notice.'提现账号,请勿重复添加');
            try{
                $addCashAccountId = model('Seller')->addCashAccount($addBankData);
            }catch(\Exception $e) {
                $this->error($e->getMessage());
            }
            if($addCashAccountId){
                action_log('dp_cash_account_add', 'dp_cash_account', $addCashAccountId, UID, $addBankData['account']);
                $this->success($notice.'账号添加成功','Seller/CashAccountList');
            } else {
                $this->error($notice.'账号添加失败');
            }
        }
        $catAllSeller = $this->catAllSeller(); //获取所有商家
        $bankOfDeposit = $this->bankOfDeposit(); //获取所有后台支持的银行
        if(empty($catAllSeller) || count($catAllSeller) == 0) $this->error('暂无商家');
        if(false == $catAllSeller) $this->error('商家信息获取失败');
        if(empty($bankOfDeposit) || count($bankOfDeposit) == 0) $this->error('后台暂无配置银行,请先配置');
        if(false == $bankOfDeposit) $this->error('银行获取失败');
        return ZBuilder::make('form')
            ->setPageTitle('新增商家提现账号')
            ->addSelect('account_type', '账户类别[:请选择提现账号类别]', '', [1 => '支付宝', 2 => '微信', 3=>'银行卡'])
            ->addSelect('seller_id', '商户名称[:请选择商户名称]', '', $catAllSeller)
            ->addSelect('bank_card_id', '开户行[:请选择开户行]', '', $bankOfDeposit)
            ->addText('account_1', '支付宝账号')
            ->addText('account_2', '微信账号')
            ->addText('account_3', '银行卡账号')
            ->addText('idcard', '身份证账号')
            ->addText('wechat_mobile','提现手机号码[:请输入微信提现手机号码]')
            ->addText('alipay_mobile','提现手机号码[:请输入支付宝提现手机号码]')
            ->addText('account_name', '收款人姓名')
            ->addRadio('status', '状态', '', [1 => '启用', 0 => '禁用'])
            ->setTrigger('account_type', '3', 'bank_card_id,account_3,idcard') //银行卡,开户行
            ->setTrigger('account_type', '2', 'account_2,wechat_mobile') //微信
            ->setTrigger('account_type', '1', 'account_1,alipay_mobile') //支付宝
            ->submitConfirm()
            ->fetch();
    }

    /***
     * 删除提现账户
     * @param $id
     */
    public function delCashAccount($id =[])
    {
        try{
            $delCashAccount = model('Seller')->delCashAccount($id);
        }catch(\Exception $e) {
            $this->error('删除失败');
        }
        if($delCashAccount){
            action_log('dp_cash_account_del', 'dp_cash_account', $id, UID, $id);
            $this->success('账号已删除');
        } else {
            $this->error('删除失败');
        }
    }

    /***
     * 批量删除
     * @param array $ids
     * @return mixed|void
     */
    public function delete($ids=[])
    {
        $strId = implode(',',$ids);
        try{
            $delSelectCashAccount = model('Seller')->delSelectCashAccount($strId);
        }catch(\Exception $e){
            $this->error('删除失败');
        }
        if($delSelectCashAccount){
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /***
     * 编辑提现账户
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function editCashAccount($id)
    {
        if(request()->isPost()){
            $addBankData = request()->post('', null, 'trim');
            if($addBankData['account_type'] == 3){
                $addBankData['account'] = $addBankData['account_3']; //银行卡
                $notice = '银行卡';
                if(empty($addBankData['bank_card_id']))  return exception('请选择开户行');
                $validateBankNum = $this->validateBankNum($addBankData['account']);
                if(false == $validateBankNum){ //校验银行卡号
                    return exception('请输入正确的银行卡号');
                }
            } else if($addBankData['account_type'] == 2) {
                $addBankData['account'] = $addBankData['account_2']; //微信
                $addBankData['mobile'] = $addBankData['wechat_mobile'];
                if(!preg_match('/^(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/', $addBankData['mobile'])) return exception('手机号码格式错误');
                $notice = '微信';
                unset($addBankData['bank_card_id']);//销毁银行卡id
            } else if($addBankData['account_type'] == 1) {
                $addBankData['account'] = $addBankData['account_1']; //支付宝
                $addBankData['mobile'] = $addBankData['alipay_mobile'];
                $notice = '支付宝';
                if(!preg_match('/^(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/', $addBankData['mobile'])) return exception('手机号码格式错误');
                unset($addBankData['bank_card_id']);//销毁银行卡id
            }
            unset($addBankData['account_1']);//去除额外的字段
            unset($addBankData['account_2']);
            unset($addBankData['account_3']);
            unset($addBankData['wechat_mobile']);
            unset($addBankData['alipay_mobile']);
            $addBankData['create_time'] = time();  //添加时间
            $validateAddBank = validate('SellerCashAccount'); //校验添加数据
            $validateAddBankData = $validateAddBank->check($addBankData);
            if(!$validateAddBankData){
                return exception($validateAddBank->getError());
            }
            $updateId = $addBankData['id'];
            unset($addBankData['id']);
            try{
                $updateCashAccount = model('Seller')->updateCashAccount($updateId,$addBankData);
            }catch(\Exception $e) {
                $this->error('更新失败');
            }
            if($updateCashAccount){
                action_log('dp_cash_account_update', 'dp_cash_account', $updateId, UID, $addBankData['account']);
                $this->success($notice.'账号更新成功',cookie('__addCashAccount__'));
            } else {
                $this->error($notice.'账号更新失败');
            }
        }
        try{
            $editCashAccount = model('Seller')->editCashAccount($id);
        }catch(\Exception $e){
            $this->error('提现账号获取失败');
        }
        $catAllSeller = $this->catAllSeller(); //获取所有商家
        $bankOfDeposit = $this->bankOfDeposit(); //获取所有后台支持的银行
        return ZBuilder::make('form')
            ->setPageTitle('更新商家提现账号')
            ->addHidden('id')
            ->addSelect('account_type', '账户类别[:请选择提现账号类别]', '', [1 => '支付宝', 2 => '微信', 3=>'银行卡'])
            ->addSelect('seller_id', '商户名称[:请选择商户名称]', '', $catAllSeller)
            ->addSelect('bank_card_id', '开户行[:请选择开户行]', '', $bankOfDeposit)
            ->addText('account_1', '支付宝账号')
            ->addText('account_2', '微信账号')
            ->addText('account_3', '银行卡账号')
            ->addText('idcard', '身份证账号')
            ->addText('wechat_mobile','提现手机号码[:请输入微信提现手机号码]')
            ->addText('alipay_mobile','提现手机号码[:请输入支付宝提现手机号码]')
            ->addText('account_name', '收款人姓名')
            ->addRadio('status', '状态', '', [1 => '启用', 0 => '禁用'])
            ->setTrigger('account_type', '3', 'bank_card_id,account_3,idcard') //银行卡,开户行
            ->setTrigger('account_type', '2', 'account_2,wechat_mobile') //微信
            ->setTrigger('account_type', '1', 'account_1,alipay_mobile') //支付宝
            ->setFormData($editCashAccount)
            ->submitConfirm()
            ->fetch();
    }
}