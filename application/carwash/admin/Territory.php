<?php
namespace app\carwash\admin;
 
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;
 
class Territory extends Admin
{
    public function index(){
        $lists = Db::table('dp_homepage_area')->where("parent_id = 0 and is_delete !=1")->select();//查询以及城市
        return $this->assign('lists', $lists)
        ->fetch();
        
    }

    /**
     * 查看二级城市
     */
    public function secondCity(){
        if($this->request->isPost()){
            $data = request()->param();
            $result = model('Territory')->secondCity($data);
            return json_encode($result);
        }
    }

    /**
     * 编辑城市
     */
    public function editCity(){
        if($this->request->isPost()){
            $data = request()->param();
            $validate = validate('Consult');//校验数据
            $valrslt = $validate->scene('city')->check($data);
            if(!$valrslt){//校验不通过,抛出异常
                exception($validate->getError());
            }
            $result = model('Territory')->editCity($data);
            if($result[0] == 1){
                // 成功
                $this->success($result[1], 'Territory/index');
            }else{
                $this->error($result[1]);
            }
        }
        $info = Db::table('dp_homepage_area')->where("id = ".$_GET["id"])->find();//查询以及城市
        // 使用ZBuilder构建表单页面，并将页面标题设置为“添加”
        return ZBuilder::make('form')
            ->setPageTitle('编辑')
            ->addText('areaname', '城市名称')
            ->addHidden('id')
            ->setFormData($info)
            ->fetch();
    }

    /**
     * 新增二级城市
     */
    public function addCity(){
        if($this->request->isPost()){
            $data = request()->param();
            $area_code = addResstoIdCard($data["areaname"]);
            if($area_code == false){
                $this->error("获取不到区号,请检查该地区名称是否能用!");
            }else{
                $data["area_code"] = $area_code;
                // // 如果存在父级id,判断是否是父级的子节点
                // if(!empty($data["parent_id"])){
                //     $parent_code = Db::name('homepage_area')->where('id',$data["parent_id"])->field('area_code,areaname')->find();
                //     if(substr($parent_code["area_code"],0,3) == substr($area_code,0,3)){//地区id号匹配之后再写入(不能用前三位判断)
                //         $data["area_code"] = $area_code;
                //     }else{
                //         $this->error("请核实地区是否属于".$parent_code["areaname"]);
                //     }
                // }else{
                //     $data["area_code"] = $area_code;
                // }
            }
            $validate = validate('Consult');//校验数据
            $valrslt = $validate->scene('city')->check($data);
            if(!$valrslt){//校验不通过,抛出异常
                exception($validate->getError());
            }
            $result = model('Territory')->addCity($data);
            if($result[0] == 1){
                // 成功
                $this->success($result[1], 'Territory/index');
            }else{
                $this->error($result[1]);
            }
        }
        // 使用ZBuilder构建表单页面，并将页面标题设置为“添加”
        return ZBuilder::make('form')
        ->setPageTitle('新增')
        ->addHidden('parent_id', $_GET["id"])
        ->addText('areaname', '城市名称:')
        ->fetch();
    }

    /**
     * 删除城市
     */
    public function delcity(){
        if($this->request->isGet()){
            $data = $this->request->param();
            $result = model('Territory')->delcity($data);
            if($result[0] == 1){
                if(isset($result[2])){
                    $this->success($result[1], $result[2]);
                }
                // 删除成功
                $this->success($result[1], 'Territory/index');
            }else{
                $this->error($result[1]);
            }
        }
    }

    /**
     * 管理二级城市
     */
    public function manageCity(){
        if($this->request->isGet()){
            $data = $this->request->param();
            $lists = Db::table('dp_homepage_area')->where("parent_id=".$data["id"]." and is_delete !=1")->paginate();//查询以及城市
            // 使用ZBuilder构建数据表格
            return ZBuilder::make('table')
            ->setTableName('homepage_area')
            ->hideCheckbox()
            ->addColumns([
                ['id', 'ID'],
                ['areaname', '地域名', 'text.edit'],
                ['area_code', '区号', 'text.edit'],
                ['pinyin', '首字母拼音', 'text.edit'],
                ['right_button', '操作', 'btn']
            ])
            ->addRightButton('delete', [
                'title' => '删除',
                'icon'  => 'fa fa-fw fa-remove',
                'class' => 'btn btn-xs btn-default ajax-get confirm',
                'href'  => url('delcity', ['id' => '__id__','parent_id'=>'__parent_id__']),
                'data-title' => '真的要删除吗？'
            ]) // 添加授权按钮
            ->setRowList($lists) // 设置表格数据
            ->fetch();
        }
    }

    /**
     * 平台客服列表
     */
    public function servlist(){
        // 读取用户数据
        $lists = Db::table('dp_contactus')->where("is_delete != 1")->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->hideCheckbox()
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['name', '客服名称'],
                ['phone', '联系电话'],
                ['create_time', '新增时间','datetime'],
                ['status', '状态', 'status','', ['不启用', '启用']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButton('add', ['href' => url('addEditserv')])
            ->addRightButton('edit', ['href' => url('addEditserv', ['id' => '__id__'])])
            ->addRightButton('delete', ['href' => url('delserv', ['id' => '__id__']),'data-title' => '真的要删除吗？'])
            ->setRowList($lists) // 设置表格数据
            ->css('admin', 'common')
            ->fetch(); // 渲染页面
    }

    /**
     * 删除客服
     */
    public function delserv(){
        if($this->request->isGet()){
            $data = $this->request->param();
            $result = model('Territory')->delserv($data);
            if($result[0] == 1){
                // 删除成功
                $this->success($result[1], 'Territory/servlist');
            }else{
                $this->error($result[1]);
            }
        }
    }

    /**
     * 编辑/新增客服
     */
    public function addEditserv(){
        if(request()->isPost()){
            $content = request()->post('', null, 'trim');
            //校验数据
            $validate = validate('Consult');
            $valrslt = $validate->scene('service')->check($content);
            if(!$valrslt){//校验不通过,抛出异常
                exception($validate->getError());
            }
            $result = model('Territory')->addEditserv($content);
            if($result[0] == 1){
                // 新增成功
                $this->success($result[1], 'Territory/servlist');
            }else{
                $this->error($result[1]);
            }
        }
        $data = $this->request->param();
        $data_list = [];
        if(!empty($data)){
            $data_list = Db::table('dp_contactus')->where("id=".$data["id"])->find();
        }
        return ZBuilder::make('form')
            ->addText('name', '客服名称')
            ->addNumber('phone', '电话')
            ->addSwitch('status', '是否启用')
            ->addHidden('id',0)
            ->setFormData($data_list)
            ->fetch();
    }

    /**
     * 服务协议列表
     */
    public function servAgreement(){
        // 读取用户数据
        $lists = Db::name('service_protocol')->where("is_delete != 1")->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->hideCheckbox()
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['protocol_type', '协议类型', 'status','', ['', '用户注册', '商家入驻','帮助协议','卡包使用说明','关于我们']],
                ['status', '状态', 'status','', ['不启用', '启用']],
                ['create_time', '添加时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButton('add', ['href' => url('operationServ')])
            ->addRightButton('edit', ['href' => url('operationServ', ['id' => '__id__'])])
            ->addRightButton('delete', ['href' => url('delServe', ['id' => '__id__']),'data-title' => '真的要删除吗？'])
            ->setRowList($lists) // 设置表格数据
            ->css('admin', 'common')
            ->fetch(); // 渲染页面
    }

    /**
     * 删除协议
     */
    public function delServe(){
        if($this->request->isGet()){
            $data = $this->request->param();
            $result = model('Territory')->delServe($data);
            if($result[0] == 1){
                // 删除成功
                $this->success($result[1], 'Territory/servAgreement');
            }else{
                $this->error($result[1]);
            }
        }
    }

    /**
     * 编辑/新增协议
     */
    public function operationServ(){
        if(request()->isPost()){
            $content = request()->post('', null, 'trim');
            $result = model('Territory')->operationServ($content);
            if($result[0] == 1){
                // 新增成功
                $this->success($result[1], 'Territory/servAgreement');
            }else{
                $this->error($result[1]);
            }
        }
        $data = $this->request->param();
        $data_list = [];
        if(!empty($data)){
            $data_list = Db::name('service_protocol')->where("id=".$data["id"])->find();
        }
        return ZBuilder::make('form')
            ->addSelect('protocol_type', '请选择服务类别', '', ['1' => '用户注册协议', '2' => '商家入驻协议', '3' => '帮助协议', '4'=>'卡包中心使用说明', '5'=>'关于我们'],1)
            ->addUeditor('content', '内容')
            ->addSwitch('status', '是否启用')
            ->addHidden('id',0)
            ->setFormData($data_list)
            ->fetch();
    }


}