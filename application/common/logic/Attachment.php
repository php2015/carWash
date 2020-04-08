<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/17
 * Time: 15:11
 */

namespace app\common\logic;


use app\admin\model\Attachment as AttachmentModel;

/**
 * 文件逻辑层
 * Class Attachment
 * @package app\common\logic
 */
class Attachment extends Base
{
    /**
     * 文件模型
     * @var AttachmentModel|null
     */
    protected $attachmentModel = null;

    /**
     * 构造方法
     * Goods constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->attachmentModel = new AttachmentModel();
    }

    /**
     * 创建文件
     *
     * @param $data
     * @return AttachmentModel
     */
    public function create($data)
    {
        return $this->attachmentModel->create($data);
    }

    /**
     * 获取文件
     *
     * @param string $id 文件ID
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\Exception
     */
    public function getAttachmentById($id)
    {
        return $this->attachmentModel->find($id);
    }
    /**
     * 文件是否存在
     *
     * @param string $md5 文件MD5
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\exception\DbException
     */
    public function getAttachmentByMd5($md5)
    {
        return $this->attachmentModel->where('md5', $md5)->find();
    }
}