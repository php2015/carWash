<?php
namespace app\carwash\admin;
 
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;
use app\carwash\model\SellerService;
use app\carwash\model\PlatformCard;
 
class Advert extends Admin
{
    /**
     * 广告分类
     */
    public function index()
    {
        // 获取查询条件
        $map = $this->getMap();
        $list = model('Advert')->advType($map);
        $btn_access = [
            'title' => '删除分类',
            'icon'  => 'fa fa-fw fa-remove',
            'class' => 'btn btn-xs btn-default ajax-get confirm',
            'href'  => url('delClass', ['id' => '__id__']),
            'data-title' => '真的要删除吗？',
            'data-tips' => '若确认将删除该分类下所有广告'
        ];
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setTableName('homepage_carouselcate')
            ->hideCheckbox()
            ->setSearch(['id' => 'ID']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['name', '分类名称', 'textarea.edit'],
                ['order_num', '咨询排序', 'textarea.edit'],
                ['is_rease', '启用状态', 'switch'],
                ['create_time', '创建时间', 'datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addRightButton('btn_access', $btn_access)
            ->addTopButton('add') // 新增分类
            ->setRowList($list) // 设置表格数据
            ->css('admin', 'common')
            ->fetch(); // 渲染页面
    }
 
    /**
     * 删除分类
     * @param $data["id"] =>分类id
     * */ 
    public function delClass(){
        if($this->request->isGet()){
            $data = $this->request->param();
            $result = model('Advert')->delClass($data);
            if($result[0] == 1){
                // 删除成功
                $this->success($result[1], 'Advert/index');
            }else{
                $this->error($result[1]);
            }
        }
    }
 
    /**
     * 新增分类
     * */
    public function add(){
        // 提交
        if(request()->isPost()){
            $addClass = request()->post('', null, 'trim');
            $consultValidate = validate('Consult');//校验数据
            $addConsultValite = $consultValidate->scene('classify')->check($addClass);
            if(!$addConsultValite){//校验不通过,抛出异常
                exception($consultValidate->getError());
            }
            $result = model('Advert')->addClass($addClass);
            if($result[0] == 1){
                // 新增成功
                $this->success($result[1], 'Advert/index');
            }else{
                $this->error($result[1]);
            }
        }
        // 使用ZBuilder构建表单页面，并将页面标题设置为“添加”
        return ZBuilder::make('form')
            ->setPageTitle('添加')
            ->setPageTips('新增广告分类')
            ->addText('name', '广告分类名称')
            ->addNumber('order_num', '分类排序')
            ->addSwitch('is_rease', '是否启用', '', '1')
            ->fetch();
    }
 
    /**
     * 广告列表
     */
    public function advList(){
        // 获取查询条件
        $map = $this->getMap();
        $order = $this->getOrder();
        $list = model('Advert')->advList($map,$order);
        /**
         * 筛选条件
         */
        $classify = Db::table('dp_homepage_carouselcate')->where("is_rease = 1 and is_delete !=1")->column('id,name');
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setTableName('homepage_carousel')
            ->hideCheckbox()
            ->setSearch(['i.id' => 'ID']) // 设置搜索参数
            ->addOrder('order_num') // 添加排序
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['location', '图片位置', 'status', '', ['', '商家端', '用户端']],
                ['picture', '封面图', 'img_url'],
                ['name', '分类名称'],
                ['order_num', '排序值'],
                ['is_release', '启用状态', 'switch'],
                ['link_type', '链接方式', 'status', '', ['内联', '外联']],
                ['linkurl', '链接地址'],
                ['right_button', '操作', 'btn']
            ])
            ->hideColumn('homepage_carouselcate_id')
            ->addTopSelect('homepage_carouselcate_id', '分类名称',$classify)
            ->addRightButton('btn_access', [
                'title' => '编辑广告',
                'icon'  => 'fa fa-fw fa-pencil',
                'href'  => url('editAdv', ['id' => '__id__'])
            ])
            ->addRightButton('btn_access', [
                'title' => '删除广告',
                'icon'  => 'fa fa-fw fa-remove',
                'class' => 'btn btn-xs btn-default ajax-get confirm',
                'href'  => url('delAdvert', ['id' => '__id__']),
                'data-title' => '确定要删除广告吗?'
            ])
            ->addTopButton('btn_access', [
                'title' => '新增广告',
                'icon'  => 'fa fa-fw fa-plus',
                'href'  => url('addAdvert')
            ])
            ->setRowList($list) // 设置表格数据
            ->setColumnWidth('linkurl',200)
            ->css('admin', 'common')
            ->fetch(); // 渲染页面
    }
 
    /**
     * 编辑广告
     * @param $data["id"] =>id
     */
    public function editAdv(){
        $config =  $this->setUploadImgParams('图片','1','690','300');
        if($this->request->isGet()){
            $list_class_id = [];//分类id
            $list_class_name = [];//分类名称
            // 获取编辑的信息
            $data = $this->request->param();
            $list = model('Advert')->editAdvert($data);
            $pic_array = $list['picture'];
            if(!empty($list["expire_time"])){
                $list["expire_time"] = date("Y-m-d H:i:s",$list["expire_time"]);
            }
            $classify = Db::table('dp_homepage_carouselcate')->where("is_delete != 1 and is_rease =1")->select();
            foreach($classify as $cls){
                $list_class_id[] = $cls["id"];
                $list_class_name[] = $cls["name"];
            }
            $list_class = array_combine($list_class_id,$list_class_name);//合并
            $location = ["1" => "商家端", '2'=>"用户端"];
 
            $js = <<<EOF
            <script type="text/javascript">
                $(function(){
                    var expire_time = $("#expire_time").val();
                    if(expire_time != "" && expire_time >0){
                        $("#times").val(expire_time);
                    }
                });
            </script>
EOF;
            // 内联参数
            $type = ['shop' => '商家信息', 'serve' => '服务信息', 'join' => '商家入驻', 'card' => '卡包中心'];
            $info_id = [];
            // 获取内联->选择对应商家或服务
            if($list["type"]=="serve"){
                $info_id = Db::name('homepage_cate')->where('is_enable =1 and is_delete=0 and parent_id = 0')->column('id,catename');
            }else if($list["type"]=="shop"){
                $info_id = Db::name('seller')->where("is_review = 1 and is_disabled !=1")->column('id,sellername');
            }else if($list["type"]=="card"){
                $info_id = Db::name('platform_card')->where("sale_status = 1")->column('id,cardname');
            }
            return ZBuilder::make('form')
                    ->addSelect('location', '图片位置','', $location)
                    ->addText('adname', '图片名称')
                    ->addSelect('homepage_carouselcate_id', '广告分类','', $list_class)
                    ->addUpload('picture',$config,$pic_array)
                    // ->addImage('picture', '图片', '请上传690*300的图片', '', '', '', '', ['size' => '690,300','ext'=>'jpg,png'])
                    ->addDate('times', '有效时间','不填则默认为永久', '', '')
                    ->addNumber('order_num', '排序')
                    ->addSwitch('is_release', '是否启用')
                    ->addSelect('link_type', '链接方式', '', [0 => '内联', 1 => '外联'])
                    ->addText('linkurl', '外联')
                    ->addLinkage('type', '选择跳转类型', '', $type, '', url('servtype'), 'info_id','type')
                    ->addSelect('info_id', '选择对应商家或服务','',$info_id)
                    ->setTrigger('link_type', '1', 'linkurl') //外联联显示方式
                    ->setTrigger('link_type', '0', 'type,info_id') //内联联显示方式
                    ->addHidden('id')
                    ->addHidden('expire_time')
                    ->setFormData($list)
                    ->setUrl(url('addAdvert'))
                    ->setExtraJs($js)
                    ->fetch();
        }
        
    }
 
    /**
     * 添加/保存广告
     */
    public function addAdvert(){
        $config =  $this->setUploadImgParams('图片','1','690','300');
        if(request()->isPost()){
            $content = request()->post('', null, 'trim');
            $validate = validate('Consult');//校验数据
            // 链接方式,on为外联,off为内联,如果是内联需要重新定义验证规则
            if(empty($content["link_type"])){
                $valrslt = $validate->scene('advert_inner')->check($content);
            }else{
                $valrslt = $validate->scene('advert')->check($content);
            }

            if(!$valrslt){
                exception($validate->getError());//校验不通过,抛出异常
            }
            $result = model('Advert')->addAdvert($content);
            if($result[0] == 1){
                // 新增成功
                $this->success($result[1], 'Advert/advList');
            }else{
                $this->error($result[1]);
            }
        }
        // 
        $list_class_id = [];//分类id
        $list_class_name = [];//分类名称
        $classify = Db::table('dp_homepage_carouselcate')->where("is_delete != 1 and is_rease =1")->select();
        foreach($classify as $cls){
            $list_class_id[] = $cls["id"];
            $list_class_name[] = $cls["name"];
        }
        $list_class = array_combine($list_class_id,$list_class_name);//合并
        $location = ['1' => '商家端', '2' => '用户端'];

        // 内联参数
        $type = ['shop' => '商家信息', 'serve' => '服务信息', 'join' => '商家入驻', 'card' => '卡包中心'];
        return ZBuilder::make('form')
                ->addSelect('location', '图片位置','', $location)
                ->addText('adname', '图片名称')
                ->addSelect('homepage_carouselcate_id', '广告分类','', $list_class)
                ->addUpload('picture',$config)
                // ->addImage('picture', '图片', '请上传690*300的图片', '', '', '', '', ['size' => '690,300','ext'=>'jpg,png'])
                ->addDate('times', '有效时间','不填则默认为永久', '', '')
                ->addNumber('order_num', '排序')
                ->addSwitch('is_release', '是否启用')
                ->addSelect('link_type', '链接方式', '', [0 => '内联', 1 => '外联'],1)
                ->addText('linkurl', '外联')
                ->addLinkage('type', '选择跳转类型', '', $type, '', url('servtype'), 'info_id','type')
                ->addSelect('info_id', '选择对应商家或服务')
                ->setTrigger('link_type', '1', 'linkurl') //外联联显示方式
                ->setTrigger('link_type', '0', 'type,info_id') //内联联显示方式
                ->fetch();
    }

    /**
     * 删除广告
     * @param $data["id"] =>广告id
     */
    public function delAdvert(){
        if($this->request->isGet()){
            $data = $this->request->param();
            $result = model('Advert')->delAdvert($data);
            if($result[0] == 1){
                // 删除成功
                $this->success($result[1], 'Advert/advList');
            }else{
                $this->error($result[1]);
            }
        }
    }

    // 根据类型获取商家信息id或者服务信息id
    public function servtype($type = '')
    {
        $arr['code'] = '1'; //判断状态
        $arr['msg'] = '请求成功'; //回传信息
        if($type == "shop"){//获取商家信息
            $seller = Db::table('dp_seller')->where("is_review = 1 and is_disabled !=1")->field('id,sellername')->select();//查询已加盟未下架的商家
            foreach($seller as $val){
                $arr['list'][] = ['key' => $val["id"], 'value'=>$val["sellername"]];
            }
        }else if($type == "serve"){//获取服务信息
            $seller = model('SellerService')->getHomePageCate();//查询已加盟未下架的商家
            foreach($seller as $val){
                $arr['list'][] = ['key' => $val["id"], 'value'=>$val["catename"]];
            }
        }else if($type == "card"){//获取卡包详情
            $seller = model('PlatformCard')->onSaleCard(1);//在售卡种 卡状态为启用状态的所有卡
            foreach($seller as $val){
                $arr['list'][] = ['key' => $val["id"], 'value'=>$val["cardname"]];
            }
        }
        return json($arr);
    }
}