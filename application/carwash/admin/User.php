<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2018/8/31
 * Time: 17:36
 */
namespace app\carwash\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;

class User extends Admin
{
    /**
     * 用户管理首页
     * */ 
    public function index(){
        // 获取查询条件
        $map = $this->getMap();
        // 读取用户数据
        $users = model('User')->userList($map);
        // 导出按钮
        $btn_access = [
            'title' => '导出',
            'icon'  => 'fa fa-fw fa-key',
            'class' => 'btn btn-success',
            'href'  => url('userExcel')
        ];

        /**
         * 顶部筛选条件
         */
        $sex = ["0"=>"未知","1"=>"男","2"=>"女"];

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->hideCheckbox()
            ->setSearch(['id' => 'ID', 'nickname' => '用户名']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['nickname', '用户名'],
                ['head_img','头像','picture'],
                ['mobile', '手机号码'],
                ['sex', '性别', 'status', '', ['保密', '男', '女']],
                ['birthday', '出生日期', 'datetime'],
                ['create_time', '注册时间', 'datetime'],
                ['equity_card', '权益卡数', '', '暂无权益'],
                ['times_card', '次数卡数', '', '暂无次数'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopSelect('sex', '性别',$sex)
            ->addTimeFilter('dp_user.create_time', '', ['开始时间', '结束时间'])
            ->addRightButton('btn_access', ['title'=>'购买记录','href'  => url('history', ['uid' => '__id__'])], false, ['title' => 'true'])
            ->addRightButton('btn_access', ['title'=>'查看卡种','href'  => url('cards', ['uid' => '__id__'])], false, ['title' => 'true'])
            ->setRowList($users) // 设置表格数据
            ->setColumnWidth('right_button,birthday,create_time,mobile',200)
            ->css('admin', 'common')
            ->addTopButton('custom', $btn_access) // 添加导出按钮
            ->fetch(); // 渲染页面
    }

    /**
     * 用户购买记录
     */
    public function history(){
        // 获取查询条件
        $map = $this->getMap();
        // 获取排序
        $order = $this->getOrder();
        // 查看单个用户的购买记录
        if($this->request->isGet()){
            $data = $this->request->param();
            if(!empty($data["uid"])){
                $map["u.id"] = $data["uid"];
            }
        }
        // 读取用户购买记录
        $history =  model('User')->buyHistory($map);

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->hideCheckbox()
            ->setSearch(['u.id' => 'ID', 'u.nickname' => '用户名']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['nickname', '用户名'],
                ['cardname', '商品名称'],
                ['cash_pay_value', '商品价格'],
                ['buy_price', '支付金额'],
                ['number', '订单号'],
                ['card_number', '卡号'],
                ['buy_type', '结算方式', 'status', '', ['', '支付宝', '微信']],
                ['buy_status', '支付状态', 'status', '', ['成功', '失败']],
                ['create_time', '创建时间', 'datetime']
            ])
            ->setRowList($history) // 设置表格数据
            ->css('admin', 'common')
            ->fetch(); // 渲染页面
    }

    /***
     * 查看卡种
     */
    public function cards(){
        // 获取查询条件
        $map = $this->getMap();
        // 获取排序
        $order = $this->getOrder();
        // 查看单个用户的卡种
        if($this->request->isGet()){
            $data = $this->request->param();
            if(!empty($data["uid"])){
                $map["u.id"] = $data["uid"];
            }
        }
        // 读取用户购买记录
        $cards = model('User')->viewCards($map);

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->hideCheckbox()
            ->setSearch(['uc.card_number' => '卡号', 'pc.cardname' => '卡种名称']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['nickname', '用户名'],
                ['card_number', '卡号'],
                ['cardname', '卡种名称'],
                ['cash_pay_value', '卡种价格'],
                ['total_value', '卡种详情'],
                ['period', '使用期限'],
                ['buy_time', '购买时间', 'datetime'],
                ['expire_time', '到期时间', 'datetime'],
                ['balance_value', '卡种余额'],
                ['surplus_value', '当月剩余次数'],
                ['status', '状态', 'status', '', ['可使用', '已过期', '已过期']]
            ])
            ->setRowList($cards) // 设置表格数据
            ->setColumnWidth('card_number,buy_time,expire_time',150)
            ->css('admin', 'common')
            ->fetch(); // 渲染页面
    }

    /**
     * 导出用户全部数据
     * */ 
    public function userExcel() {
        // 读取用户数据
        $users = model('User')->userExcel();
        $data = [];//导出数据
        foreach($users as &$user){
            $count = 0;//统计次数卡张数
            $user["times_card"] = $count."张";//次数卡
            $user["equity_card"] = 0;//权益值
            $user["birthday"] = date("Y-m-d H:i:s",$user["birthday"]);//生日
            $user["create_time"] = date("Y-m-d H:i:s",$user["create_time"]);
            // 区分权益卡和次数卡类型 || 1.权益 2.次数
            if($user["card_type"] == 1){
                $user["equity_card"] = $user["buy_price"];
            }else if($user["card_type"] == 2){
                $count += 1;
                $user["times_card"] = $count."张";
            }
            // 性别判断
            if($user["sex"] == 1){
                $user["sex"] = "男";
            }else if($user["sex"] == 2){
                $user["sex"] = "女";
            }else{
                $user["sex"] = "未知";
            }
            $data[] = [$user["id"],$user["nickname"],$user["mobile"],$user["sex"],$user["birthday"],$user["create_time"],$user["equity_card"],$user["times_card"]];
        }
        $name='导出用户列表';
        $header=['ID','用户名','手机号码','性别','出生日期','注册时间','权益卡数','次数卡数'];
        excelExport($name,$header,$data);
    }

}