<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/17
 * Time: 14:55
 */

namespace app\api\controller\v1;

use app\api\controller\Base;
use app\common\service\Attachment as AttachmentService;
use think\Request;

/***
 * 上传接口
 * Class UploadImage
 * @package app\api\controller\v1
 */
class Attachment extends Base
{

    /**
     * @var AttachmentService|null 文件业务类
     */
    protected $attachmentService = null;

    /***
     * 重写构造函数
     * Attachment constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->attachmentService = new AttachmentService();
    }

    /**
     * 上传图片
     * @throws \think\Exception
     */
    public function uploadImage()
    {
        // 临时取消执行时间限制
        set_time_limit(0);

        // 获取文件
        $file = $this->request->file('file');

        // 开始上传
        $this->attachmentService->uploadImage($file);

        list($this->status, $this->message, $this->data) = [
            $this->attachmentService->status,
            $this->attachmentService->message,
            $this->attachmentService->data
        ];
    }
}