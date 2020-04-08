<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/14
 * Time: 11:18
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\SellerLoginTel as SellerLoginTelService;
class SellerLoginTel extends Base
{
    /***
     * 商家端登录页广告/客服业务类
     * @var SellerLoginTelService|null
     */
    protected $sellerLoginTelService = null;

    /***
     * 重写构造函数
     * SellerLoginTel constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->sellerLoginTelService = new SellerLoginTelService();
    }

    /***
     * 获取商家端登录页联系电话
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryContactPhone()
    {
        $this->sellerLoginTelService->queryContactPhone();
        list($this->status,$this->message,$this->data) = [
            $this->sellerLoginTelService->status,
            $this->sellerLoginTelService->message,
            $this->sellerLoginTelService->data,
        ];
    }
}