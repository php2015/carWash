<?php
/**
 * 首页服务类别
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/6
 * Time: 11:05
 */

namespace app\carwash\admin;

use think\Db;
use think\Request;
use think\Controller;
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\exception\DbException;

class SellerService extends Admin
{
    /***
     * 商家服务列表
     */
    public function sellerServiceList()
    {
        cookie('__forward__', $_SERVER['REQUEST_URI']);
        $condition = $this->getMap();
        $cardType = [0=>'权益卡',1=>'次数卡/次卡'];//所属卡种
        try{
            $cateTypes = model('SellerService')->getHomePageCate();
        }catch(\Exception $e){
            $this->error('类别获取失败');
        }
        $cateTypesArr = [];
        foreach($cateTypes as $k=>$v){
            $cateTypesArr[$v['catename']] = $v['catename'];
        }
        $cateType = $cateTypesArr;//所属类别

        try{
            $sellerList = model('Seller')->catAllSeller();
        }catch(\Exception $e){
            $this->error('商家获取失败');
        }
        $sellernameArr = [];
        foreach($sellerList as $k => $v){
            $sellernameArr[$v['sellername']] = $v['sellername'];
        }
        $sellername = $sellernameArr;//所属商家
        try{
            $sellerServiceList = model('SellerService')->sellerServiceList($condition);
        }catch(\Exception $e){
            $this->error('商家服务获取失败');
        }
        return ZBuilder::make('table')
            ->setPageTitle('商家服务列表')
            ->hideCheckbox()
            ->setTableName('seller_service')
            ->setSearch(['servicename' => '服务名称','sellername'=>'商户名'])
            ->addColumns([
                ['__INDEX__', 'ID'],
                ['servicename', '服务名称'],
                ['catename', '所属一级类别'],
                ['soncatename', '所属二级类别'],
                ['serviceprice', '服务价格'],
                ['sellername', '所属商家'],
                ['is_timescard', '是否支持次卡','status','',[0=>'不支持',1=>'支持']],
                ['create_time', '申请时间','datetime'],
                ['update_time', '审核时间','datetime'],
                ['is_release', '状态', 'status', '', [0=>'待处理', 1=>'审核通过',2=>'驳回']],
                ['right_button', '操作', 'btn']
            ])
            ->addRightButton('custom', [
                'title' => '修改服务状态',
                'icon'  => 'fa fa-fw fa-edit',
                'href'  => url('editServiceStatus', ['id' => '__id__'])
            ], [
                'area' => ['40%', '35%'],
                'title' => '审核服务'
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
                'data-title' => '确认要将当前商家的服务删除?'
            ])
            ->setRowList($sellerServiceList)
            ->addTopSelect('dp_seller_service.is_timescard', '所属卡种', $cardType)
            ->addTopSelect('dp_seller_service.catename', '所属类别', $cateType)
            ->addTopSelect('dp_seller_service.sellername', '所属商家', $sellername)
            ->addTimeFilter('dp_seller_service.create_time', '', ['开始时间', '结束时间'])
            ->assign('empty_tips', '没有任何数据')
            ->fetch();
    }

    /***
     * 编辑服务状态并写入消息通知
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function editServiceStatus($id)
    {
        if(request()->isPost()){
            $editStatus =request()->post('', null, 'trim');
            $serviceId = $editStatus['id'];
            $isRease = $editStatus['is_release'];
            //查询商家id,服务id,商家名称,服务名称并组装消息数据
            $writeInfo = model('SellerService')->queryWriteInfo($serviceId);
            $writeData['seller_id'] = $writeInfo['seller_id'];
            $writeData['seller_service_id'] = $writeInfo['seller_service_id'];
            $writeData['sellername'] = $writeInfo['sellername'];
            $writeData['servicename'] = $writeInfo['servicename'];
            $writeData['create_time'] = time();
            Db::startTrans();//开启事务,写入变更消息
            $updateStatus = model('SellerService')->updateServiceStatus($serviceId,$isRease);
            if($updateStatus){
                if($isRease == 0){
                    $title = '服务被驳回';
                    $type = 42;
                    $content = '尊敬的'.$writeInfo['sellername'].',您添加的服务:'.$writeInfo['servicename'].'。已被驳回,请知晓';
                } elseif ($isRease == 1){
                    $title = '服务审核通过';
                    $type = 41;
                    $content = '尊敬的'.$writeInfo['sellername'].',您提交的服务:'.$writeInfo['servicename'].'。审核已通过,请知晓';
                } elseif ($isRease == 2){
                    $title = '服务被驳回';
                    $type = 40;
                    $content = '尊敬的'.$writeInfo['sellername'].',您添加的服务:'.$writeInfo['servicename'].'。已被驳回,请知晓';
                }
                //写入商家消息表
                $writeData['title'] = $title;
                $writeData['type'] = $type;
                $writeData['content'] = $content;
                try{
                    $writeMessage = model('SellerService')->addServiceMessage($writeData);
                }catch(\Exception $e){
                    Db::rollback();
                    $this->error('服务状态变更失败', null, '_parent_reload');
                }
                if($writeMessage){
                    Db::commit();
                    $this->success('服务状态变更成功', null, '_parent_reload');
                } else {
                    Db::rollback();
                    $this->error('服务状态变更失败', null, '_parent_reload');
                }
            } else {
                Db::rollback();
                $this->error('服务状态变更失败', null, '_parent_reload');
            }
        }
        //获取服务状态
        $serviceStatus = model('SellerService')->getServiceStatus($id);
        return ZBuilder::make('form')
            ->setPageTitle('审核服务')
            ->addRadio('is_release', '服务状态', '', [0=>'待处理', 1=>'审核通过',2=>'驳回'], '', '','')
            ->addHidden('id',$id)
            ->setFormData($serviceStatus)
            ->submitConfirm()
            ->fetch();
    }

    /***
     * 编辑商家服务
     * @param $id
     * @throws \think\Exception
     */
    public function editSellerService($id)
    {
        if(request()->isPost()){
            $editPrice =request()->post('', null, 'trim');
            $editPriceData['serviceprice'] = $editPrice['serviceprice'];
            if(!preg_match('/^[0-9]+(.[0-9]{1,2})?$/',$editPriceData['serviceprice'])) return exception('请输入正确的服务价格');
            $editPriceData['update_time'] = time();
            try{
                $editPrice = model('SellerService')->updateSellerService($editPrice['id'],$editPriceData);
            }catch(\Exception $e){
                return exception('更新服务价格失败');
            }
            if($editPrice){
                action_log('dp_seller_service_edit', 'dp_seller_service', $editPrice['id'], UID, $editPrice['servicename']);
                $this->success('更新服务价格成功',cookie('__forward__'));
            } else {
                $this->error('更新服务价格失败');
            }
        }
        try{
            $editSellerService = model('SellerService')->editSellerService($id);
        }catch(\Exception $e){
            return exception('商家信息获取失败');
        }
        return ZBuilder::make('form')
            ->setPageTitle('编辑商家服务')
            ->addStatic('sellername', '商家名称')
            ->addStatic('servicename', '服务名称')
            ->addStatic('catename', '所属服务类别')
            ->addText('serviceprice', '服务价格')
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
     * @throws \Exception
     */
    public function delSellerService($id)
    {
       try{
           $delSellerService = model('SellerService')->delSellerService($id);
       }catch(\Exception $e){
           return exception('删除失败');
       }
       if($delSellerService){
           action_log('dp_seller_service_del', 'dp_seller_service', $id, UID, $id);
           $this->success('删除成功');
       } else {
           $this->error('删除失败');
       }
    }

    /***
     * 首页服务类别
     */
    public function showHomePageCate()
    {
        $searchCondition = $this->getMap();//搜索条件
        try{
            $queryAllCate = model('SellerService')->showPageCate($searchCondition);//对象转数组
        }catch(\Exception $e){
            $this->error('获取首页服务失败');
        }
        $searchStatus = [0=>'禁用',1=>'启用'];//设置顶部筛选
        return ZBuilder::make('table')
            ->setTableName('homepage_cate')
            ->setPageTitle('类别列表')
            ->setSearch(['catename' => '类别名称'])
            ->setPrimaryKey('id')
            ->addColumns([
                ['__INDEX__', 'ID'],
                ['catename', '类别名称'],
                ['parent_id', '是否顶级分类','status','',[0=>'是']],
                ['icon', 'ICON','picture'],
                ['order_num','排序','number'],
                ['create_time','新增时间','datetime'],
                ['is_enable', '状态', 'switch'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add') // 批量添加顶部按钮
            ->addTopButton('enable', ['field' => 'is_enable'])
            ->addTopButton('disable', ['field' => 'is_enable'])
            ->addTopButton('dels', [
                'title' => '删除',
                'icon'  => 'fa fa-fw fa-remove',
                'class' => 'btn btn-primary ajax-post confirm',
                'href'  => url('delHomePageCate',['id'=>'__id__'])
            ])
            ->addRightButton('editHomePageCate', [
                'title' => '编辑',
                'icon' => 'fa fa-fw fa-pencil',
                'href' => url('editHomePageCate', ['id' => '__id__'])
            ], [
                'area' => ['80%', '80%'],
                'title' => '编辑'
            ])
            ->addRightButton('del', [
                'title' => '删除',
                'icon'  => 'fa fa-fw fa-remove',
                'class' => 'btn btn-xs btn-default ajax-get confirm',
                'href'  => url('delHomePageCate', ['id' => '__id__']),
                'data-title' => '确认要将当前类别删除?'
            ])
            ->setRowList($queryAllCate) // 设置表格数据
            ->addTopSelect('is_enable', '状态', $searchStatus)
            ->setColumnWidth('__INDEX__', 50)
            ->assign('empty_tips', '没有任何数据')
            ->fetch(); // 渲染页面
    }

    /***
     * 新增首页服务类别
     */
    public function add()
    {
        if(request()->isPost()){
            $addHomePageCate =request()->post('', null, 'trim');
            $validateSellerService = validate('HomePageCate');
            $valiSellerService = $validateSellerService->check($addHomePageCate);
            if(!$valiSellerService){
                return exception($validateSellerService->getError());
            }
            $cateId = $addHomePageCate['id']; //开始组装拼接服务分类数据
            if($cateId == 0){ // 顶级分类
                if(empty($addHomePageCate['icon'])){
                    return exception('请上传类别图片');
                }
                $addHomePageCate['path']  = 0;
                $addHomePageCate['parent_id'] = 0;
                //unset($addHomePageCate['config']);
            } else {
                $cateParentid = model('SellerService')->getParentId($cateId);  // 获取父级 id
                $addHomePageCate['path'] = $cateParentid['path'].",".$cateParentid['id']; //拼接  cate_path
                $addHomePageCate['parent_id'] = $addHomePageCate['id']; // 子分类 cate_parent_id
            }
            unset($addHomePageCate['id']);
            $addHomePageCate['create_time'] = time();
            $addHomePageCate['is_delete'] = 0;
            try{
                $addSellerServiceId = model('SellerService')->addHomePageCate($addHomePageCate);
            }catch(\Exception $e){
                return exception('添加失败');
            }
            if($addSellerServiceId){
                action_log('dp_homepage_cate_add', 'dp_homepage_cate', $addSellerServiceId, UID, $addHomePageCate['catename']);
                $this->success('服务类别已添加','SellerService/showHomePageCate');
            } else {
                $this->error('服务类别添加失败');
            }
        }
        try{
            $getHomePageCate = model('SellerService')->getHomePageCate();//获取分类
        }catch(\Exception $e){
            $this->error('分类获取失败');
        }
        $temHomePageArr =  []; // 声明一个空数组
        $temHomePageArr['0'] = '顶级分类';
        foreach($getHomePageCate as $key=>$value) {
            $temHomePageArr[$value['id']] = $value['catename'];
        }
        //js判断是否是顶级分类,以判断是否显示图片上传
        $buttonJs = <<<EOF
            <script type="text/javascript">
              $(function(){
                 $('#id').change(function(){
                     var isHidden = $('#id').val();
                     if(0 != isHidden){
                        $('#triggerBtn').attr('style','display:none;');
                     } else {
                         $('#triggerBtn').attr('style','display:block;');
                     }
                  })    
              });
            </script>
EOF;
        return ZBuilder::make('form')
        ->setPageTitle('新增服务类别')
        ->addSelect('id', '选择服务分类[:请选择一项分类]', '', $temHomePageArr)
        ->addText('catename', '服务类别名称')
        ->addUpload('icon',$this->setUploadImgParams('类别ICON','1','690','300'))
        ->addNumber('order_num', '排序', '', '100', '0', '10000')//默认值为 100
        ->addRadio('is_enable', '状态', '', [1 => '启用', 0 => '禁用'])
        ->submitConfirm()
        ->setExtraJs($buttonJs)
        ->fetch();
    }

    /***
     * 编辑分类
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function edithomepagecate($id)
    {
        if(request()->isPost()){
            $editHomePageCate = request()->post('', null, 'trim');
            $validate = validate('HomePageCate');
            $editValidate = $validate->check($editHomePageCate);
            if(!$editValidate){
                return exception($validate->getError());
            }
            try{
                $updateHomePageCate = model('SellerService')->updateHomePageCate($id,$editHomePageCate);
            }catch(\Exception $e){
                $this->error('分类更新失败');
            }
            if($updateHomePageCate){
                action_log('dp_homepage_cate_update', 'dp_homepage_cate', $id, UID, $editHomePageCate['catename']);
                $this->success('分类更新成功','SellerService/showHomePageCate','_parent_reload');
            } else {
                $this->error('分类更新失败',null,'_parent_reload');
            }
        }
        try{
            $edithomepagecate = model('SellerService')->edithomepagecate($id);
        }catch(\Exception $e){
            $this->error('服务分类信息获取失败');
        }
        return ZBuilder::make('form')
            ->setPageTitle('编辑服务类别')
            ->addText('catename', '请输入服务类别名称')
            //->addFormItems([
            //    ['image', 'icon', '类别ICON', '', '', '', '', '', ['size' => '690,300']]
            //])
            ->addUpload('icon',$this->setUploadImgParams('类别ICON','1','690','300'),$edithomepagecate['icon'])
            ->addNumber('order_num', '排序', '', '100', '0', '10000')//默认值为 100
            ->addRadio('is_enable', '状态', '', [1 => '启用', 0 => '禁用'])
            ->submitConfirm()
            ->setFormData($edithomepagecate)
            ->fetch();
    }

    /***
     * 删除分类
     */
    public function delHomePageCate($id)
    {
        $ids = request()->param();
        $countArr = count($ids);
        if($countArr == 1){
            $strId = $ids['id'];
        } else {
            $strId = implode(',',$ids['ids']);
        }
        //删除之前,查询是否有服务关联分类,有则不删除,无则删除,
        //判断是一级分类还是二级分类
        //二级分类的话查询是否有服务,一级分类查询是否有商家,是否有子分类
        $isParentCate = model('SellerService')->isParentCate($strId);  //有值说明是父级分类,查询是否还有子分类
        if($isParentCate > 0){
            $this->error('还有子分类,请先删除子分类');
        } else {
            $isRelationSeller = model('SellerService')->isRelationSeller($strId);
            if($isRelationSeller > 0){
                $this->error('该分类已关联商家,不可删除');
            }
        }
        $queryIsRelatedServices = model('SellerService')->queryIsRelatedServices($strId);
        if($queryIsRelatedServices > 0){
            $this->error('此分类下有商家服务,不可删除');
        } else {
            try{
                $delHomePageCate = model('SellerService')->delHomePageCate($strId);
            }catch(\Exception $e){
                $this->error('删除失败');
            }
            if($delHomePageCate){
                action_log('dp_homepage_cate_del', 'dp_homepage_cate', $id, UID, $id);
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        }
    }
}