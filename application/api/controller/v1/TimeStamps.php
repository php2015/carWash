<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/29
 * Time: 12:49
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\TimeStamps as TimeStampsService;
/***
 * 获取服务器时间戳
 * Class TimeStamp
 * @package app\api\controller\v1
 */
class TimeStamps extends Base
{
    /***
     * 获取服务端时间戳
     * @var TimeStampsService|null
     */
    protected $timeStampsService = null;

    /***
     * 重写构造函数
     * SellerService constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->timeStampsService = new TimeStampsService();
    }

    /***
     * 获取时间戳
     */
    public function getTimeStamps()
    {
        $this->timeStampsService->getTimeStamps();
        list($this->status,$this->message,$this->data) = [
            $this->timeStampsService->status,
            $this->timeStampsService->message,
            $this->timeStampsService->data,
        ];
    }
}