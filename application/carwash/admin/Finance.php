<?php
namespace app\carwash\admin;
 
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;
 
class Finance extends Admin
{
    /**
     * 手续费比例控制
     */
    public function index(){
        if(request()->isPost()){
            $data = request()->post('', null, 'trim');
            $Validate = validate('Consult');//校验数据
            $addValidate = $Validate->scene('finance')->check($data);
            if(!$addValidate){
                exception($Validate->getError());//校验不通过,抛出异常
            }
            $result = model('Finance')->addRatio($data);
            if($result[0] == 1){
                // 新增成功
                $this->success($result[1], 'Finance/index');
            }else{
                $this->error($result[1]);
            }
        }
        $result = model('Finance')->procedureRatio();
        return ZBuilder::make('form')
            ->addHidden('id')
            // ->addText('amount', '提现最少金额')
            ->addNumber('fee', '提现手续费比例', '手续费比例单位：% ; 最大值:100% , 最小值:1% ; 默认5%', '5', '1', '100')
            ->setFormData($result)
            ->fetch();
    }

    /**
     * 银行卡列表
     */
    public function bankCardList(){
        $list = model('Finance')->bankCardList();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setTableName('bank_card') // 指定数据表名
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['name', '银行名称'],
                ['icon', '银行标识图','picture'],
                ['img', '银行背景图','img_url'],
                ['status', '启用状态', 'switch'],
                ['create_time', '创建时间', 'datetime'],
                ['update_time', '更新时间', 'datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButton('btn_access', [
                'title' => '新增',
                'icon'  => 'fa fa-fw fa-plus',
                'href'  => url('addCard')
            ])
            ->addRightButton('btn_access', [
                'title' => '编辑',
                'icon'  => 'fa fa-fw fa-pencil',
                'href'  => url('editCard', ['id' => '__id__'])
            ])
            ->addRightButton('btn_access', [
                'title' => '删除',
                'icon'  => 'fa fa-fw fa-remove',
                'class' => 'btn btn-xs btn-default ajax-get confirm',
                'href'  => url('delCard', ['id' => '__id__']),
                'data-title' => '真的要删除吗?',
                'data-tips' => '删除后商家端将无法选择该银行'
            ])
            ->setRowList($list) // 设置表格数据
            ->css('admin', 'common')
            ->fetch(); // 渲染页面
    }

    /**
     * 删除银行卡
     * @param $data["id"] =>卡id
     */
    public function delCard(){
        if($this->request->isGet()){
            $data = $this->request->param();
            $result = model('Finance')->delCard($data);
            if($result[0] == 1){
                // 删除成功
                $this->success($result[1], 'Finance/bankCardList');
            }else{
                $this->error($result[1]);
            }
        }
    }

    /**
     * 编辑银行
     * @param $data["id"] =>银行id
     */
    public function editCard(){
        if($this->request->isGet()){
            $data = $this->request->param();
            $result = model('Finance')->editCard($data);
            return ZBuilder::make('form')
                    ->addText('name', '名称')
                    ->addUpload('icon', $this->setUploadImgParams('银行标识图片','1','690','300'),$result['icon'])
                    ->addUpload('img', $this->setUploadImgParams('银行背景图片','1','690','300'),$result['img'])
                    ->addSwitch('status', '启用状态')
                    ->addHidden('id')
                    ->setFormData($result)
                    ->setUrl(url('addCard'))
                    ->fetch();
        }
    }

    /**
     * 添加/保存银行银行
     */
    public function addCard(){
        if(request()->isPost()){
            $content = request()->post('', null, 'trim');
            $Validate = validate('Consult');//校验数据
            $addValidate = $Validate->scene('bank_card')->check($content);
            if(!$addValidate){
                exception($Validate->getError());//校验不通过,抛出异常
            }
            $result = model('Finance')->addCard($content);
            if($result[0] == 1){
                // 新增成功
                $this->success($result[1], 'Finance/bankCardList');
            }else{
                $this->error($result[1]);
            }
        }
        return ZBuilder::make('form')
                    ->addText('name', '名称')
                    ->addUpload('icon', $this->setUploadImgParams('银行标识图片','1','690','300'))
                    ->addUpload('img', $this->setUploadImgParams('银行背景图片','1','690','300'))
                    ->addSwitch('status', '启用状态')
                    ->fetch();
    }

    /**
     * 提现记录列表
     */
    public function finanList(){
        // 获取查询条件
        $map = $this->getMap();
        $list = model('Finance')->finanList($map);
        // 筛选账户类型
        $account_type = ["1"=>"支付宝","2"=>"微信","3"=>"银行卡"];
        // 筛选提现状态
        $status = ["1"=>"未处理","2"=>"已驳回","3"=>"已打款"];

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
        ->setSearch(['sc.id' => 'ID','s.contactphone' => '联系方式','s.shopkeeper' => "店主姓名"]) // 设置搜索参数
        ->addColumns([ // 批量添加列
            ['id', 'ID'],
            ['sellername', '商户名称'],
            ['shopkeeper', '店主姓名'],
            ['contactphone', '联系方式'],
            ['nowbalance', '当前余额'],
            ['cash_price', '申请金额'],
            ['account_type', '账号类型', 'status', '', ['', '支付宝', '微信', '银行卡']],
            ['bank', '开户行'],
            ['account_name', '收款人'],
            ['account', '提现账号'],
            ['cash_fee', '手续费'],
            ['fact_cash_price', '应打款金额'],
            ['cash_status', '提现状态', 'status', '', ['', '未处理', '已驳回', '已打款']],
            ['create_time', '提现时间','datetime'],
            ['make_time', '打款时间','datetime'],
            ['reject_reason', '驳回原因'],
            ['right_button', '操作', 'btn']
        ])
        ->addTopButton('btn_access', [
            'title' => '导出',
            'icon'  => 'fa fa-fw fa-share',
            'class' => 'btn btn-success',
            'href'  => url('finanExcel')
        ])
        ->addTopButton('btn_access', [
            'title' => '批量打款',
            'icon'  => 'fa fa-fw fa-plus',
            'class' => 'btn btn-primary js-get',
            'href'  => url('batchRemit')
        ])
        ->addTopSelect('account_type', '账户类型',$account_type)
        ->addTopSelect('cash_status', '提现状态',$status)
        ->addRightButton('remit', [
            'title' => '打款',
            'icon'  => 'fa fa-fw fa-key',
            'class' => 'btn btn-xs btn-default ajax-get confirm',
            'href' => url('remit', [
                'id' => '__id__','cash_fee' => '__cash_fee__','fact_cash_price' => '__fact_cash_price__',
                'seller_id' => '__seller_id__','cash_price'=>'__cash_price__','cash_status'=>'__cash_status__'
            ]),
            'data-title' => '确认对该商家打款吗?'
        ], false, ['title' => 'true','icon'=>false])
        ->addRightButton('bohui', [
            'title' => '驳回',
            'href' => url('reject', [
                'id' => '__id__','cash_fee' => '__cash_fee__','fact_cash_price' => '__fact_cash_price__',
                'seller_id' => '__seller_id__','cash_price'=>'__cash_price__','cash_status'=>'__cash_status__'
            ])
        ],['icon'=>false], [
            'area' => ['50%', '40%'],
            'title' => '驳回'
        ])
        ->setRowList($list) // 设置表格数据
        ->replaceRightButton(['cash_status' => ['in', '2,3']], '', ['bohui'])//当驳回状态为2,即已驳回时则不显示驳回按钮
        ->replaceRightButton(['cash_status' => 3], '', ['remit'])//当驳回状态为2,即已驳回时则不显示驳回按钮
        ->setColumnWidth('sellername,contactphone,bank,account,cash_fee,fact_cash_price,create_time,make_time,reject_reason', 190)
        ->css('admin', 'common')
        ->fetch(); // 渲染页面
    }

    /**
     * 导出提现全部数据
     * */ 
    public function finanExcel() {
        // 读取数据
        $lists = model('Finance')->finanExcel();
        $data = [];//导出数据
        foreach($lists as &$list){
            $data[] = [$list["id"],$list["sellername"],$list["shopkeeper"],$list["contactphone"],$list["nowbalance"],$list["cash_price"],$list["account_type"],$list["bank"]
        ,$list["account_name"],$list["account"],$list["cash_fee"],$list["fact_cash_price"],$list["cash_status"],$list["create_time"],$list["make_time"],$list["reject_reason"]];
        }
        $name='导出提现列表';
        $header=['ID','商户名称','店主姓名','联系方式','当前余额','申请金额','账号类型','开户行','收款人','提现账号','手续费','应打款金额','提现状态','提现时间','到账时间','驳回原因'];
        excelExport($name,$header,$data);
    }

    /**
     * 驳回提现
     */
    public function reject(){
        if(request()->isPost()){
            $data = request()->post('', null, 'trim');
            if(!empty($data)){
                $result = model('Finance')->reject($data);
                if($result[0] == 1){
                    // 驳回成功
                    $this->success($result[1], 'Finance/finanList');
                }else{
                    $this->error($result[1]);
                }
            }else{
                $this->error("驳回原因不能为空!");
            }
        }
        $data = $this->request->param();
        if($data["cash_status"]==2){
            $this->error("该订单已驳回!");
        }
        $js = <<<EOF
        <script type="text/javascript">
            $(function(){
                $("#reject_reason").keyup(function(){
                    //字数长度限制
                    var num = 50;
                    //已输入
                    var length = document.getElementById("reject_reason").value.length;
                    if(length >= 50){
                        alert("已达到字数限制!");
                        document.getElementById("reject_reason").value = document.getElementById("reject_reason").value.substring(0,50);
                        var length = 50;
                    }
                    $(".length").text(length);
                    $(".limit").text(50-length);
                });
            });
        </script>
EOF;
        return ZBuilder::make('form')
            ->addTextarea('reject_reason', '请输入驳回原因:','字数限制:(<span class="length">0</span>/<span class="limit">50</span>)')
            ->addHidden('id','提现id')
            ->addHidden('seller_id','商家id')
            ->addHidden('cash_fee','手续费')
            ->addHidden('fact_cash_price','应打款金额')
            ->addHidden('cash_price','申请提现总额')
            ->addHidden('cash_status','提现状态')
            ->setFormData($data)
            ->setExtraJs($js)
            ->fetch();
    }

    /**
     * 打款
     */
    public function remit(){
        $data = $this->request->param();
            if(!empty($data)){
                $result = model('Finance')->remit($data);
            if($result[0] == 1){
                // 打款成功
                $this->success($result[1], 'Finance/finanList');
            }else{
                $this->error($result[1]);
            }
        }
    }

    /**
     * 批量打款
     */
    public function batchRemit(){
        $data = implode(",",request()->param());
        $data = explode(",",$data);
        for($i = 0;$i < count($data);$i++){
            $map = "sc.id=".$data[$i];
            // 查询该记录的信息
            $result = model('Finance')->finanList($map);
            foreach($result as $val){
                // 封装打款需要的数组
                $remit = [
                    'id' => $val["id"],'cash_fee' => $val["cash_fee"],'fact_cash_price' => $val["fact_cash_price"],
                    'seller_id' => $val["seller_id"],'cash_price'=>$val["cash_price"],'cash_status'=>$val["cash_status"]
                ];
            }
            // 打款
            $rslt = model('Finance')->remit($remit);
        }
        if($rslt[0] == 1){
            // 打款成功
            $this->success($rslt[1], 'Finance/finanList');
        }else{
            $this->error($rslt[1]);
        }
    }
}