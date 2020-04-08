<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/19
 * Time: 19:15
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\SellerQrCode as SellerQrCodeService;

/***
 * 商家端扫一扫结算控制器
 * Class SellerQrCode
 * @package app\api\controller\v1
 */
class SellerQrCode extends Base
{
    /**
     * 商家端服务业务类
     * @var SellerQrCodeService|null
     */
    protected $sellerQrCodeService = null;

    /***
     * 重写构造函数
     * SellerQrCode constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->sellerQrCodeService = new SellerQrCodeService();
    }

    /***
     * 获取当前商家的所有服务
     */
    public function getAllService()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->sellerQrCodeService->getAllService($params['seller_id']);
        list($this->status,$this->message,$this->data) = [
            $this->sellerQrCodeService->status,
            $this->sellerQrCodeService->message,
            $this->sellerQrCodeService->data,
        ];
    }

    /***
     * 18/09/28更新
     * 获取当前商家所有审核通过的服务
     */
    public function getAllInUseService()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->sellerQrCodeService->getAllInUseService($params['seller_id']);
        list($this->status,$this->message,$this->data) = [
            $this->sellerQrCodeService->status,
            $this->sellerQrCodeService->message,
            $this->sellerQrCodeService->data,
        ];
    }
    /***
     * 判断当前用户是否有卡
     */
    public function isOwnCard()
    {
        $params = [
            'seller_id' => $this->sellerid,           //商家id
            'qr_data'   => input('qr_data','','trim'),//二维码数据
        ];
        $this->sellerQrCodeService->isOwnCard($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerQrCodeService->status,
            $this->sellerQrCodeService->message,
            $this->sellerQrCodeService->data,
        ];
    }
    /***
     * 商家扫一扫收款流程
     */
    public function checkoutProcess()
    {
        //接收到的数据
        $params = [
            'seller_id'  => $this->sellerid,                      //商家id
            'sellername' => input('sellername','','trim'),        //商户名称
            'seller_service_id' => input('seller_service_id/d',0),//服务id
            'qr_data' => input('qr_data','','trim'),              //二维码数据
            'seller_staff_id' => $this->staffid,                  //员工id
        ];
        $this->sellerQrCodeService->checkoutProcess($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerQrCodeService->status,
            $this->sellerQrCodeService->message,
            $this->sellerQrCodeService->data,
        ];
    }
}