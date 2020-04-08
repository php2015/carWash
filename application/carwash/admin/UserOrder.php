<?php
/**
 * 订单列表
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/5
 * Time: 18:54
 */

namespace app\carwash\admin;

use think\Db;
use think\Request;
use think\Controller;
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\exception\DbException;

class UserOrder extends Admin
{
    /***
     * 服务订单记录
     */
    public function orderRecord()
    {
        $buyType = [1=>'权益卡',2=>'次数卡'];
        $payStatus = [0=>'支付失败',1=>'支付成功',2=>'未支付'];
        $orderRecordSearch = $this->getMap();
        try{
            $orderRecord = model('UserOrder')->orderRecord($orderRecordSearch);
        }catch(\Exception $e){
            $this->error('暂无数据');
        }
        return ZBuilder::make('table')
            ->setTableName('user_order')
            ->setPageTitle('服务订单')
            ->setSearch(['b.mobile' => '手机号码','nickname' =>'用户名' , 'servicename' => '服务名称', 'catename'=>'所属类别','order_number'=>'交易单号','staffname'=>'订单处理人'])
            ->hideCheckbox()
            ->addColumns([ // 批量添加列
                ['id','ID'],
                ['nickname', '用户名'],
                ['mobile', '手机号码'],
                ['servicename', '服务名称'],
                ['catename', '商品详情'],
                ['serviceprice', '服务价格'],
                ['settlement_type', '支付类型', 'status', '', [''=>'未知',1 => '权益卡', 2=>'次数卡']],
                ['payprice', '支付金额'],
                ['create_time', '购买时间','datetime'],
                ['order_number', '交易单号'],
                ['staffname', '订单处理人'],
                ['pay_status', '支付状态', 'status', '', [0=>'支付失败',1 => '支付成功', 2=>'未支付']],
            ])
            ->addTopButton('custom', [
                'title' => '导出服务订单EXCEL',
                'icon'  => 'fa fa-fw fa-print',
                'href'  => url('exportOrderData')
            ])
            ->addTopSelect('a.settlement_type', '支付方式', $buyType)
            ->addTopSelect('a.pay_status', '支付状态', $payStatus)
            ->addTimeFilter('a.create_time', '', ['开始时间', '结束时间'])
            ->setColumnWidth('id', 30)
            ->setColumnWidth('create_time', 150)
            ->setColumnWidth('order_number', 150)
            ->setRowList($orderRecord) // 设置表格数据
            ->assign('empty_tips', '没有任何数据')
            ->fetch(); // 渲染页面
    }
    /***
     * 导出服务订单数据
     */
    public function exportOrderData()
    {
        $exportName = '订单记录';
        $exportOrderHeader = ['ID','用户名','手机号码','服务名称','商品详情','服务价格','支付类型','支付金额','购买时间','交易单号','订单处理人','支付状态'];
        try{
            $exportOrderData = model('UserOrder')->exportOrderData();
        }catch(\Exception $e){
            $this->error('服务器内部错误,导出失败');
        }
        try{
            excelExport($exportName,$exportOrderHeader,$exportOrderData);
        }catch(\Exception $e) {
            $this->error('服务器内部错误,导出失败');
        }
    }

    /***
     * 平台订单列表
     */
    public function platformList()
    {
        $buyStatus = [0=>'成功',1=>'失败'];
        $buyType = [1=>'支付宝',2=>'微信'];
        $cardType = [1=>'权益卡',2=>'次数卡'];
        $condition = $this->getMap();
        try{
            $platformList = model('UserOrder')->platformList($condition);
        }catch(\Exception $e){
            $this->error('获取失败');
        }
        return ZBuilder::make('table')
            ->setTableName('platform_card')
            ->setPageTitle('平台订单')
            ->setSearch(['cardname' => '卡种名称','mobile'=>'手机号码','card_number'=>'卡号','jiaoyi_number'=>'第三方交易号','number'=>'交易单号'])
            ->setPrimaryKey('id')
            ->hideCheckbox()
            ->addColumns([
                ['__INDEX__', 'ID'],
                ['nickname','用户名'],
                ['mobile','手机号码'],
                ['platform', '所属商家'],
                ['cardname', '商品名称'],
                ['card_type', '卡种类别', 'status', '',[1=>'权益卡', 2=>'次数卡']],
                ['cash_pay_value','卡种价格'],
                ['buy_price','支付价格'],
                ['buy_type','支付类型', 'status', '',[1=>'支付宝',2=>'微信']],
                ['jiaoyi_number','第三方交易号'],
                ['number','交易单号'],
                ['card_number','卡号'],
                ['create_time', '支付时间','datetime'],
                ['buy_status','支付状态','status', '',[0=>'成功',1=>'失败']],
            ])
            ->addTopButton('custom', [
                'title' => '导出平台订单EXCEL',
                'icon'  => 'fa fa-fw fa-print',
                'href'  => url('exportPlatformList')
            ])
            ->addTopSelect('ub.card_type', '卡种类型', $cardType)
            ->addTopSelect('buy_type', '支付类型', $buyType)
            ->addTopSelect('buy_status', '支付状态', $buyStatus)
            ->addTimeFilter('ub.create_time', '', ['开始时间', '结束时间'])
            ->setColumnWidth('__INDEX__', 50)
            ->setColumnWidth('nickname', 60)
            ->setColumnWidth('platform', 60)
            ->setColumnWidth('card_type', 60)
            ->setColumnWidth('buy_type', 60)
            ->setColumnWidth('buy_price', 60)
            ->setColumnWidth('buy_status', 60)
            ->setColumnWidth('cash_pay_value', 60)
            ->setColumnWidth('card_number', 120)
            ->setColumnWidth('create_time', 120)
            ->setColumnWidth('number', 120)
            ->setRowList($platformList)
            ->assign('empty_tips', '没有任何数据')
            ->fetch(); // 渲染页面
    }

    /****
     * 导出平台订单
     * @throws \Exception
     */
    public function exportPlatformList()
    {
        $exportName = '平台订单记录';
        $exportOrderHeader = ['ID','用户名','手机号码','所属商家','商品名称','卡种类别','卡种价格','支付金额','支付类型','第三方交易号','交易单号','卡号','支付时间','支付状态'];
        try{
            $exportOrderData = model('UserOrder')->exportPlatformList();
        }catch(\Exception $e){
           $this->error('服务器内部错误,导出失败');
        }
        try{
            excelExport($exportName,$exportOrderHeader,$exportOrderData);
        }catch(\Exception $e) {
            $this->error('服务器内部错误,导出失败');
        }
    }
}