<?php
namespace app\carwash\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;

class Index extends Admin
{
    /**
     * 后台首页 统计数据
     */
    public function index()
    {
        $countUserNum = model('PlatformCount')->countUserNum();//获取平台用户总数
        $countSellerNum = model('PlatformCount')->countSellerNum();//获取平台加盟的商家总数
        $countToDoSeller = model('PlatformCount')->countToDoSeller();//获取平台待审核的商家总数
        $countToDoService = model('PlatformCount')->countToDoService();//获取平台待审核的服务
        $countSellerCasheNum = model('PlatformCount')->countSellerCashNum();//获取平台总提现金额
        $countSellerConsumeNum = model('PlatformCount')->countSellerConsumeNum();//获取平台总消费金额
        $countCashFee = model('PlatformCount')->countCashFee();//获取平台总提现手续费
        $countCashToDoFee = model('PlatformCount')->countCashToDoFee();//待处理提现请求个数
        //组装数据
        $PlatformCount = [
            'countUserNum'          => $countUserNum, //获取平台用户总数
            'countSellerNum'        => $countSellerNum, //获取平台加盟的商家总数
            'countToDoSeller'        => $countToDoSeller, //获取平台待审核的商家总数
            'countToDoService'        => $countToDoService, //获取平台待审核的服务
            'countSellerCasheNum'   => sprintf("%01.2f", $countSellerCasheNum[0]['cashprice']), //获取平台总提现金额
            'countSellerConsumeNum' => sprintf("%01.2f", $countSellerConsumeNum[0]['consumeprice']), //获取平台总消费金额
            'countCashFee'          => sprintf("%01.2f", $countCashFee[0]['sumcashfee']), //获取平台总提现手续费
            'countCashToDoFee'      => $countCashToDoFee //待处理提现请求个数
        ];
        $this->assign('title','平台首页');
        $this->assign('PlatformCount',$PlatformCount);
        return $this->fetch();
    }

}