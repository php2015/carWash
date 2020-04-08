<?php

namespace form\upload;

class Builder
{
    /**
     * 上传图片
     * @param array $config
     * [
     *          'title' =>  '图片上传',
     *          'size'  => '1048576',     //图片大小
     *          'width'    =>  '690',   //长
     *          'height'    =>  '300',      //高
     *          'preview_width' =>  '450',      //预览框长
     *          'preview_height'    =>  '300',  //预览框高
     *          'type'          =>  ['jpg','png','jpeg'],      //限制上传类型
     *          'elements'      =>  true,           //是否保存原图
     *          'number'        =>  '5',             //上传图片数量限制
     *          'temp'          =>  'upload/temp/',              //原图缓存路径
     *          'crop'          =>  'upload/crop/',              //截图保存路径
     *          'thumb'         =>  'upload/thumb/',              //压缩保存路径
     *          'write'         =>  'upload/write/',              //补白保存路径
     *          'cut'           =>  'upload/cut/',              //切片保存路径
     *          'preview'       =>  'upload/preview/',           //预览图片保存路径 点击确定都会删除'
     *          'cut_size'      =>  ['100','50','10'],              //切片尺寸 可设置 单位%
     *          'path'          =>  'http://localhost/DolphinPHPV1.3.0/public/',  //网站静态文件路径
     *
     * ]
     * @return mixed
     */


    public $config = [
        'title' =>  '图片上传',
        'size'  => '1048576',     //图片大小
        'width'    =>  '690',   //长
        'height'    =>  '300',      //高
        'preview_width' =>  '450',      //预览框长
        'preview_height'    =>  '300',  //预览框高
        'type'          =>  ['jpg','png','jpeg'],      //限制上传类型
        'elements'      =>  true,           //是否保存原图
        'number'        =>  '5',             //上传图片数量限制
        'temp'          =>  'upload/temp/',              //原图缓存路径
        'crop'          =>  'upload/crop/',              //截图保存路径
        'thumb'         =>  'upload/thumb/',              //压缩保存路径
        'write'         =>  'upload/write/',              //补白保存路径
        'cut'           =>  'upload/cut/',              //切片保存路径
        'preview'       =>  'upload/preview/',           //预览图片保存路径 点击确定都会删除'
        'cut_size'      =>  ['100','50','10'],              //切片尺寸 可设置 单位%
        'path'          =>  'http://192.168.0.25/DolphinPHPV1.3.0/public/',  //网站静态文件路径
    ];

    public $new_config = [];

    /**
     * @param $name  提交input name值
     * @param $data  配置信息
     * @param $pic_array     调用时将要显示的图片传入
     * @return mixed
     */
    public function item($name,$data,$pic_array=[])
    {
        $config = $data['config'];
        if(count($config) > 0){
            $default_config = $this->config;
            $this->new_config = $config;

            foreach($default_config as $key=>$value){
                if($key == 'size'   ||
                    $key == 'width'  ||
                    $key == 'height' ||
                    $key == 'preview_width'  ||
                    $key == 'preview_height' ||
                    $key == 'number'){
                    if(empty($this->new_config[$key]) ||
                        !is_numeric($this->new_config[$key])){
                        $this->new_config[$key] = $value;
                    }
                }elseif($key == 'cut_size'){

                    if(!array_key_exists($key,$this->new_config) || count($this->new_config[$key]) == 0 ){        //未配置切片比例

                        $this->new_config[$key] = $value;


                    }else{

                        foreach($this->new_config[$key] as $B => $A){
                            if(!is_numeric($A) || $A > 100 || $A<0){
                                $this->new_config[$key] = $value;
                            }
                        }
                    }
                }else{
                    if(empty($this->new_config[$key])){
                        $this->new_config[$key] = $value;
                    }
                }
            }
        }else{
            $this->new_config = $this->config;
        }

        $data['path'] = json_encode($pic_array);
        $data['name'] = $name;
        $data['config'] = $this->new_config;

        return $data;
    }

    /**
     * @var array 需要加载的js
     */

    public $js = [
        '__LIBS__/upload-lib/js/plugin.js',
        //'__LIBS__/upload-lib/js/public.js',
        '__LIBS__/upload-lib/js/ui.js',
        '__LIBS__/upload-lib/js/spark-md5.min.js',
    ];

    /**
     * @var array 需要加载的css
     */

    public $css = [
        '__LIBS__/upload-lib/css/uploadPlugin_htmleaf-demo.css',
        '__LIBS__/upload-lib/css/uploadPlugin_pretty.min.css',
        '__LIBS__/upload-lib/css/uploadPlugin_public.css',
        '__LIBS__/upload-lib/css/uploadPlugin_radio.css',
        '__LIBS__/upload-lib/css/uploadPlugin_style.css',
    ];


}