<?php
namespace app\carwash\admin;
 
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Request;
use think\Db;
 
class Consult extends Admin
{
    /**
     * 咨询分类
     */
    public function index()
    {
        // 获取查询条件
        $map = $this->getMap();
        $list = model('Consult')->consulType($map);
        $btn_access = [
            'title' => '删除分类',
            'icon'  => 'fa fa-fw fa-remove',
            'class' => 'btn btn-xs btn-default ajax-get confirm',
            'href'  => url('delClass', ['id' => '__id__']),
            'data-title' => '真的要删除吗？',
            'data-tips' => '若确认将删除该分类下所有资讯'
        ];
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setTableName('information_cate')
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
            $result = model('Consult')->addClass($addClass);
            if($result[0] == 1){
                // 新增成功
                $this->success($result[1], 'consult/index');
            }else{
                $this->error($result[1]);
            }
        }
        // 使用ZBuilder构建表单页面，并将页面标题设置为“添加”
        return ZBuilder::make('form')
            ->setPageTitle('添加')
            ->setPageTips('新增资讯分类')
            ->addText('name', '资讯分类名称')
            ->addNumber('order_num', '分类排序')
            ->addSwitch('is_rease', '是否启用', '', '1')
            ->fetch();
    }
 
    /**
     * 删除分类
     * @param $data["id"] =>资讯分类id
     * */ 
    public function delClass(){
        if($this->request->isGet()){
            $data = $this->request->param();
            $result = model('Consult')->delClass($data);
            if($result[0] == 1){
                // 删除成功
                $this->success($result[1], 'consult/index');
            }else{
                $this->error($result[1]);
            }
        }
    }
 
    /**
     * 资讯列表
     */
    public function consulist(){
        // 获取查询条件
        $map = $this->getMap();
        $order = $this->getOrder();
        $list = model('Consult')->consulist($map,$order);
        /**
         * 筛选条件
         */
        $classify = Db::table('dp_information_cate')->where("is_rease = 1 and is_delete !=1")->column('id,name');
        $is_release = [0=>"未发布",1=>"已发布"];
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setTableName('information_cate')
            ->hideCheckbox()
            ->setSearch(['i.id' => 'ID']) // 设置搜索参数
            ->addOrder('order_num') // 添加排序
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['title', '文章标题'],
                ['icon', '封面图', 'img_url'],
                ['name', '分类名称'],
                ['source', '来源'],
                ['order_num', '排序值'],
                ['create_time', '新增时间', 'datetime'],
                ['is_release', '发布状态', 'status', '', ['不发布', '已发布']],
                ['right_button', '操作', 'btn']
            ])
            ->hideColumn('information_cate_id')
            ->addTopSelect('information_cate_id', '分类名称',$classify)
            ->addTopSelect('is_release', '发布状态',$is_release)
            ->addRightButton('btn_access', [
                'title' => '编辑资讯',
                'icon'  => 'fa fa-fw fa-pencil',
                'href'  => url('editConsult', ['id' => '__id__'])
            ])
            ->addRightButton('btn_access', [
                'title' => '删除资讯',
                'icon'  => 'fa fa-fw fa-remove',
                'class' => 'btn btn-xs btn-default ajax-get confirm',
                'href'  => url('delConsult', ['id' => '__id__']),
                'data-title' => '真的要删除吗?'
            ])
            ->addTopButton('btn_access', [
                'title' => '新增资讯',
                'icon'  => 'fa fa-fw fa-plus',
                'href'  => url('addConsult')
            ])
            ->setRowList($list) // 设置表格数据
            ->css('admin', 'common')
            ->fetch(); // 渲染页面
    }
 
    /**
     * 删除资讯
     * @param $data["id"] =>资讯id
     */
    public function delConsult(){
        if($this->request->isGet()){
            $data = $this->request->param();
            $result = model('Consult')->delConsult($data);
            if($result[0] == 1){
                // 删除成功
                $this->success($result[1], 'consult/consulist');
            }else{
                $this->error($result[1]);
            }
        }
    }
 
    /**
     * 编辑资讯
     * @param $data["id"] =>资讯id
     */
    public function editConsult(){
        $config =  $this->setUploadImgParams('图片上传','1','690','300');
        if($this->request->isGet()){
            $list_class_id = [];//分类id
            $list_class_name = [];//分类名称
            // 获取编辑资讯的信息
            $data = $this->request->param();
            $list = model('Consult')->editConsult($data);
            $pic_array = $list['icon'];
            $classify = Db::table('dp_information_cate')->where("is_delete != 1 and is_rease =1")->select();
            foreach($classify as $cls){
                $list_class_id[] = $cls["id"];
                $list_class_name[] = $cls["name"];
            }
            $list_class = array_combine($list_class_id,$list_class_name);//合并
            return ZBuilder::make('form')
                    ->addText('title', '标题')
                    ->addSelect('information_cate_id', '选择分类','', $list_class)
                    ->addText('source', '资讯来源')
                    ->addUpload('icon',$config,$pic_array)
                    // ->addImage('icon', '图片', '请上传690*300的图片', '', '', '', '', ['size' => '690,300','ext'=>'jpg,png'])
                    ->addUeditor('detail', '详情')
                    ->addNumber('order_num', '排序')
                    ->addSwitch('is_release', '是否发布')
                    ->addHidden('id')
                    ->setFormData($list)
                    ->setUrl(url('addConsult'))
                    ->fetch();
        }
    }
 
    /**
     * 添加/保存资讯
     */
    public function addConsult(){
        $config =  $this->setUploadImgParams('封面图片*','1','690','300');
        if(request()->isPost()){
            $content = request()->post('', null, 'trim');
            $consultValidate = validate('Consult');//校验数据
            $addConsultValite = $consultValidate->scene('consult')->check($content);
            if(!$addConsultValite){
                exception($consultValidate->getError());//校验不通过,抛出异常
            }
            // halt($content);
            $result = model('Consult')->addConsult($content);
            if($result[0] == 1){
                // 新增成功
                $this->success($result[1], 'consult/consulist');
            }else{
                $this->error($result[1]);
            }
        }
        // 
        $list_class_id = [];//分类id
        $list_class_name = [];//分类名称
        $classify = Db::table('dp_information_cate')->where("is_delete != 1 and is_rease =1")->select();
        foreach($classify as $cls){
            $list_class_id[] = $cls["id"];
            $list_class_name[] = $cls["name"];
        }
        $list_class = array_combine($list_class_id,$list_class_name);//合并
        return ZBuilder::make('form')
                ->addText('title', '标题*')
                ->addSelect('information_cate_id', '选择分类*','', $list_class)
                ->addText('source', '资讯来源*')
                ->addUpload('icon',$config)
                // ->addImage('icon', '图片', '请上传690*300的图片', '', '', '', '', ['size' => '690,300','ext'=>'jpg,png'])
                ->addUeditor('detail', '详情*')
                ->addNumber('order_num', '排序*', '请输入1 - 100的数字')
                ->addSwitch('is_release', '是否发布')
                ->fetch();
    }
 
}