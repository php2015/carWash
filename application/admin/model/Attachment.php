<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Model;

/**
 * 附件模型
 * @package app\admin\model
 */
class Attachment extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_ATTACHMENT__';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 根据附件id获取路径
     * @param  string|array $id 附件id
     * @param  int $type 类型：0-补全目录，1-直接返回数据库记录的地址
     * @return string|array     路径
     */
    public function getFilePath($id = '', $type = 0)
    {
        if (is_array($id)) {
            $data_list = $this->where('id', 'in', $id)->select();
            $paths = [];
            foreach ($data_list as $key => $value) {
                if ($value['driver'] == 'local') {
                    $paths[$key] = ($type == 0 ? PUBLIC_PATH : '').$value['path'];
                } else {
                    $paths[$key] = $value['path'];
                }
            }
            return $paths;
        } else {
            $data = $this->where('id', $id)->find();
            if ($data) {
                if ($data['driver'] == 'local') {
                    return ($type == 0 ? PUBLIC_PATH : '').$data['path'];
                } else {
                    return $data['path'];
                }
            } else {
                return false;
            }
        }
    }

    /**
     * 根据图片id获取缩略图路径，如果缩略图不存在，则返回原图路径
     * @param string $id 图片id
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function getThumbPath($id = '')
    {
        $result = $this->where('id', $id)->field('path,driver,thumb')->find();
        if ($result) {
            if ($result['driver'] == 'local') {
                return $result['thumb'] != '' ? PUBLIC_PATH.$result['thumb'] : PUBLIC_PATH.$result['path'];
            } else {
                return $result['thumb'] != '' ? $result['thumb'] : $result['path'];
            }
        } else {
            return $result;
        }
    }

    /**
     * 根据附件id获取名称
     * @param  string $id 附件id
     * @return string     名称
     */
    public function getFileName($id = '')
    {
        return $this->where('id', $id)->value('name');
    }


    /**
     * 根据m5值,获取原图路径
     * @param string $md5 文件md5值
     * @return array 路径，文件名
     */

    public function getFileTempPath($md5){
        $data_list = $this->where('md5','eq',$md5)->find();
        if(count($data_list) > 0){
            return $data_list;
        }else{
            return false;
        }

    }

    /**
     * 修改原图路径
     */

    public function editPicPath($data,$id){
        $result = $this->where('id','eq',$id)->update($data);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 根据文件名 获取文件信息
     * @param string $name 文件名
     * @return array  文件信息
     */

    public function getFileInfo($name){
        $data_list = $this->where('name','eq',$name)->find();
        if(count($data_list) > 0){
            return $data_list;
        }else{
            return false;
        }
    }
}
