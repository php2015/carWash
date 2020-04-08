<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/17
 * Time: 15:09
 */

namespace app\common\service;


use \think\File;
use app\common\logic\Attachment as AttachmentLogic;
use think\Image;

/**
 * 文件类
 * Class Attachment
 * @package app\common\service
 */
class Attachment extends Base
{
    /**
     * @var AttachmentLogic|null 文件逻辑类
     */
    protected $attachmentLogic = null;

    /**
     * 构造方法
     * Attachment constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->attachmentLogic = new AttachmentLogic();
    }
    /**
     * 文件是否存在
     *
     * @param File $file
     * @throws \think\Exception
     */
    public function uploadImage(File $file)
    {
        // 文件是否存在
        if ($exists = $this->fileExists($file->hash('md5'))) {
            list($this->status, $this->message, $this->data) = [1, '上传成功', $exists];
            return;
        }
        // 文件大小限制
        if ($this->fileSizeLimit('images', $file->getInfo('size'))) {
            list($this->status, $this->message) = [0, '图片过大'];
            return;
        }
        // 文件类型限制
        $fileName = $file->getInfo('name');
        $fileExt = strtolower(substr($fileName, strrpos($fileName, '.') + 1));
        if ($fileExt == '') {
            list($this->status, $this->message) = [0, '获取文件信息失败！'];
        }
        if ($this->fileTypeLimit('images', $fileExt, $file->getMime())) {
            list($this->status, $this->message) = [0, '附件类型不正确！'];
            return;
        }
        // 保存文件
        if ($result = $this->upload($file, 'images', 'app')) {
            list($this->status, $this->message, $this->data) = [1, '上传成功', $result];
            return;
        }
        list($this->status, $this->message) = [0, '文件上传失败！'];
    }

    /**
     * 文件是否存在
     * @param string $md5 文件MD5
     * @return array|bool
     * @throws \think\exception\DbException
     */
    private function fileExists($md5) {
        // 判断附件是否已存在
        if ($filExists = $this->attachmentLogic->getAttachmentByMd5($md5)) {
            if ($filExists->driver == 'local') {
                $file_path = PUBLIC_PATH . $filExists->path;
            } else {
                $file_path = $filExists->path;
            }
            return ['id' => $filExists->id, 'path' => config('token.web_site_domain') . $file_path];
        }
        return false;
    }

    /**
     * 文件大小限制
     * @param string $dir
     * @param int $fileSize 文件大小
     * @return bool [true => 超过限制, false => 符合限制]
     */
    private function fileSizeLimit($dir = 'images', $fileSize)
    {
        // 附件大小限制
        $sizeLimit = $dir == 'images' ? config('upload_image_size') : config('upload_file_size');
        $sizeLimit = $sizeLimit * 1024;

        return ($sizeLimit > 0 && $fileSize > $sizeLimit);
    }

    /**
     * 文件类型限制
     *
     * @param string $dir
     * @param string $fileExt 文件后缀
     * @param string $mime 文件MIME
     * @return bool [true => 超过限制, false => 符合限制]
     */
    private function fileTypeLimit($dir = 'images', $fileExt, $mime)
    {
        // 附件类型限制
        $extLimit = $dir == 'images' ? config('upload_image_ext') : config('upload_file_ext');
        $extLimit = $extLimit != '' ? parse_attr($extLimit) : '';

        if ($mime == 'text/x-php' || $mime == 'text/html') {
            return true;
        }
        if (preg_grep("/php/i", $extLimit)) {
            return true;
        }
        if (!preg_grep("/$fileExt/i", $extLimit)) {
            return true;
        }

        return false;
    }

    /**
     * 保存文件
     *
     * @param File $file
     * @param string $dir 保存的目录:images,files,videos,voices
     * @param string $module 来自哪个模块
     * @return array|bool
     */
    private function upload($file, $dir = 'images', $module = 'file')
    {
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move(config('upload_path') . DS . $dir);
        if($info) {
            // 缩略图路径
            $thumb_path_name = '';
            // 图片宽度
            $img_width = '';
            // 图片高度
            $img_height = '';
            if ($dir == 'images') {
                $img = Image::open($info);
                $img_width = $img->width();
                $img_height = $img->height();
            }

            // 获取附件信息
            $file_info = [
                'uid'   => 0,
                'name'  => $file->getInfo('name'),
                'mime'  => $file->getInfo('type'),
                'path'  => 'uploads/' . $dir . '/' . str_replace('\\', '/', $info->getSaveName()),
                'ext'   => $info->getExtension(),
                'size'  => $info->getSize(),
                'md5'   => $info->hash('md5'),
                'sha1'  => $info->hash('sha1'),
                'thumb' => $thumb_path_name,
                'module'=> $module,
                'width' => $img_width,
                'height'=> $img_height,
                'driver'=> 'local'
            ];
            // 写入数据库
            if ($attachment = $this->attachmentLogic->create($file_info)) {
                if ($attachment->driver == 'local') {
                    $file_path = PUBLIC_PATH . $attachment->path;
                } else {
                    $file_path = $attachment->path;
                }

                return ['id' => $attachment->id, 'path' => config('token.web_site_domain') . $file_path];
            }
        }
        return false;
    }

}