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

namespace app\admin\controller;


use app\admin\model\Attachment as AttachmentModel;
use think\Image;
use think\File;
use think\Db;

/**
 * 图片插件核心控制器
 * @version 2.0.0
 * pang
 * @package app\admin\controller
 */
class Upload extends Admin
{

    /*插件配置信息*/
    protected $config = [];
    /*图片处理类 think\img*/
    protected $img = null;
    /*上传图片的基本信息*/
    protected $property = [
        'validate'  =>  true,
    ];
    /*获取图片信息类*/
    protected $SplFileInfo = null;
    /*图片处理方式 6 => 压缩   2 => 补白 3 => 截取*/
    protected $type = null;
    /*保存图片名*/
    protected $name = null;
    /*保存的图片id*/
    protected $id = '';




    /**
     * upload constructor.初始化
     */

    public function __construct()
    {

        /*读取配置信息*/
        $this->config = json_decode($_POST['config'],true);


        if(count($_FILES) != 0){  /*有文件上传时*/


            $file = $_FILES['file'];


            if($file['error'] == '0'){

                /*生成配置文件夹*/
                $this->makePath();

                /*生成新图片名*/
                $this->makeNewFileName($file);

                /*上传图片*/
                $this->doUpload($file);

            }else{

                $data['code'] = '-1';
                $data['msg'] = '没有上传的文件';
                echo json_encode($data);
                exit;

            }
        }elseif(array_key_exists('checked',$_POST)){  /*没有文件上传 是单选框选择事件*/

            $this->radioChange();


        }elseif(array_key_exists('pic_array',$_POST)){ /*没有文件上传 是获取预览图片*/

            $this->getPreview($_POST['pic_array']);
        }


    }


    /*
    * 根据配置创建文件夹
    */
    public function makePath(){
        //先检查文件夹是否存在
        $path[] = $this->config['temp'];
        $path[] = $this->config['crop'];
        $path[] = $this->config['thumb'];
        $path[] = $this->config['write'];
        $path[] = $this->config['preview'];
        $path[] = $this->config['cut'];
        foreach($this->config['cut_size'] as $item =>$value){
            $path[] = $this->config['cut'].$value.'/';
        }
        foreach($path as $key=>$value){
            if(!file_exists($value)){
                $res = mkdir($value,0777,true);
                if(!$res){
                    $data['code'] = '-1';
                    $data['msg'] = '创建配置文件夹失败,请手动创建';
                    echo json_encode($data);
                    exit;
                }
            }
        }
    }


    /**
     * 生成新文件名
     */

    public function makeNewFileName($file){
        //图片处理方式
        $this->type = $_POST['type'];
        /**
         * 更改文件名,以md5($file['name'].time())作为新文件名
         * 提取文件后缀
         */
        $getFile = explode('.',$file['name']);
        $file_type = end($getFile);


        $this->name = md5($file['name'].time()).'.'.$file_type;



    }


    /**
     * 检查已上传数量
     */

    public function checkNumber(){
        $number = $_POST['number'];
        if($number >= $this->config['number']){
            $data['code'] = '-1';
            $data['msg'] = '已达到最高数量'.$this->config['number'];
        }else{
            $data['code'] = 1;
            $data['msg'] = 'success';
        }
        echo json_encode($data);
        exit;


    }


    /**
     * 图片上传
     */

    public function doUpload($file){

        /*先验证在上传前能够获取的文件信息*/
        $md5 = $_POST['md5']?$_POST['md5']:'';
        /*配置信息限制的文件格式*/
        $type_string = implode(',',$this->config['type']);
        /*将格式转换为MIME格式*/
        $type_array = $this->getMIME($this->config['type']);
        /*验证格式*/
        if(!in_array($file['type'],$type_array)){
            $data['code'] = '-1';
            $data['msg'] = '文件格式不正确,只能上传'.$type_string.'格式';
            echo json_encode($data);
            exit;
        }
        /*验证文件大小*/
        $size = $file['size'];
        if($size > $this->config['size']){
            $data['code'] = '-1';
            $data['msg'] = '文件大小超出限制,最大只能上传'.($this->config['size']/1048576).'MB';
            echo json_encode($data);
            exit;
        }
        /*通过MD5值获取文件信息*/
        if($md5){
            $check =  $this->checkMd5($md5);
        }else{
            $data['code'] = '-1';
            $data['msg'] = '未获取到文件md5,请检查js';
            echo json_encode($data);
            exit;
        }

        /*没有记录则上传*/
        if(!$check){

            /*文件保存路径$path*/
            $path = $this->config['temp'].$this->name;
            $res = move_uploaded_file($file['tmp_name'],$path);
            if(!$res){
                $data['code'] = '-1';
                $data['msg'] = '图片保存失败';
                echo json_encode($data);
                exit;
            }

            /*获取该图片信息*/
            $this->SplFileInfo = new \SplFileInfo($path);
            $this->img = new Image($this->SplFileInfo);

            $this->property['width'] = $this->img->width();
            $this->property['height'] = $this->img->height();
            $this->property['type'] = $this->img->type();
            $this->property['validate'] = 'true';

            $check_result = $this->checkConfig();

            /*图片文件未通过检测,删除该图片*/

            if($check_result != 1){
                unlink($path);
                echo json_encode($check_result);
                exit;
            }
            /*think\File 类获取文件sha1散列*/
            $get_File = new File($path);

            /*组装新增数组info*/
            $info['uid'] = session('user_auth.uid')?session('user_auth.uid'):'1';
            $info['name'] = $this->name;
            $info['path'] = $path;
            $info['mime'] = $file['type'];
            $info['ext'] = $this->img->type();
            $info['size'] = $size;
            $info['md5'] = $md5;
            $info['sha1'] = $get_File->hash('sha1');
            $info['create_time'] = time();
            $info['update_time'] = time();
            $info['status'] = 1;
            $info['width'] = $this->property['width'];
            $info['height'] = $this->property['height'];


            $add = AttachmentModel::create($info);
            if($add){
                $this->id = $add['id'];
            }else{
                $data['code'] = '-1';
                $data['msg'] = '插入数据失败';
                echo json_encode($data);
                exit;
            }
            /*在表中有记录*/
        }else{

            /*原图路径*/
            $path = $check['path'];
            /*原图不存在,执行上传*/
            if(!file_exists($path)){

                /*文件保存路径$path*/
                $path = $this->config['temp'].$this->name;
                $res = move_uploaded_file($file['tmp_name'],$path);
                if(!$res){
                    $data['code'] = '-1';
                    $data['msg'] = '图片保存失败';
                    echo json_encode($data);
                    exit;
                }
                /*获取原图片信息*/
                $this->SplFileInfo = new \SplFileInfo($path);
                $this->img = new Image($this->SplFileInfo);

                $this->property['width'] = $this->img->width();
                $this->property['height'] = $this->img->height();
                $this->property['type'] = $this->img->type();
                $this->property['validate'] = 'true';

                $check_result = $this->checkConfig();
                /*图片文件未通过检测,删除该图片*/

                if($check_result != 1){
                    unlink($path);
                    echo json_encode($check_result);
                    exit;
                }

                /*更新图片原图路径*/
                $info['name'] = $this->name;
                $info['path'] = $path;
                $info['update_time'] = time();

                $result = model('admin/attachment')->editPicPath($info,$check['id']);
                if(!$result){
                    $data['code'] = '-1';
                    $data['msg'] = '原图路径更新失败';
                    echo json_encode($data);
                    exit;
                }
                /*原图存在,获取信息*/
            }else{

                /*图名*/
                $this->name = $check['name'];
                $this->SplFileInfo = new \SplFileInfo($path);
                $this->img = new Image($this->SplFileInfo);


                $this->property['width'] = $check['width'];
                $this->property['height'] = $check['height'];
                $this->property['type'] = $check['ext'];

                $check_result = $this->checkConfig();
                /*图片文件未通过检测,删除该图片*/

                if($check_result != 1){
                    unlink($path);
                    echo json_encode($check_result);
                    exit;
                }

            }





        }



    }

    /**
     * 根据md5搜索文件
     * @param $md5 文件md5值
     * @return array|bool  文件信息|false
     */

    public function checkMd5($md5){
        $check = model('admin/attachment')->getFileTempPath($md5);

        if(file_exists($check['path'])){

            return $check;
        }else{

            return false;
        }
    }


    /**
     * 将后缀名转MIME
     */

    public function getMIME($array){
        $check = ['gif'=>'image/gif','jpg' => 'image/jpeg','png'=>'image/png','jpeg'=>'image/jpeg'];
        foreach($array as $key=>&$value){
            if(array_key_exists($value,$check)){
                $value = $check[$value];
            }

        }
        return $array;



    }


    /**
     * 验证上传文件
     */
    public function checkConfig()
    {
        if($this->property['validate'] == 'true'){


            if($this->property['width'] < $this->config['width'] && $this->property['height'] < $this->config['height'] ){
                $data['code'] = '-1';
                $data['msg'] = '图片高度不能小于'.$this->config['height'].'宽度不能小于'.$this->config['width'];

                return $data;
            }

            if($this->property['width'] < $this->config['width']){
                $data['code'] = '-1';
                $data['msg'] = '图片宽度不能小于'.$this->config['width'];

                return $data;
            }
            if($this->property['height'] < $this->config['height']){
                $data['code'] = '-1';
                $data['msg'] = '图片高度不能小于'.$this->config['height'];

                return $data;
            }
            if($this->type != 2 && $this->type != 3 && $this->type != 6){
                $data['code'] = '-1';
                $data['msg'] = '无效的图片处理方式';

                return $data;
            }
            return '1';

        } else{
            return '1';
        }



    }


    /**
     * 图片处理方法
     * 处理过后的文件名格式  $assembly.'_'.$this->config['width'].'_'.$this->config['height'].'_'.$this->name
     * example  =>  thumb_690_300_XXX.png
     */

    public function imgProcess(){

        /*根据处理类型,获取保存文件夹$path*/
        if($this->type == 2){  //补白
            $path = $this->config['write'];
            $assembly = 'write';
        }
        if($this->type == 3){  //截取
            $path = $this->config['crop'];
            $assembly = 'crop';
        }
        if($this->type == 6){  //压缩
            $path = $this->config['thumb'];
            $assembly = 'thumb';
        }
        /*组装处理后的文件名*/
        $new_name = $assembly.'_'.$this->config['width'].'_'.$this->config['height'].'_'.$this->name;
        /*组装处理后的文件保存路径*/
        $new_path = $path.$new_name;
        /*若该文件不存在*/
        if(!file_exists($new_path)){
            $this->img->open($this->SplFileInfo);
            if($this->type == 2 ){   //补白

                if(($this->property['width']/$this->property['height']) > ($this->config['width']/$this->config['height'])){

                    $times = $this->property['width']/$this->config['width'];
                    $this->img->thumb($this->config['width'],$this->property['height']*$times,1);
                }else{

                    $times = $this->property['height']/$this->config['height'];
                    $this->img->thumb($this->property['width']*$times,$this->config['height'],1);
                }

            }
            if($this->type == 3){ //截取
                if(($this->property['width']/$this->property['height']) > ($this->config['width']/$this->config['height'])){


                    $times = $this->property['height']/$this->config['height'];
                    $this->img->thumb($this->property['width']*$times,$this->config['height'],1);


                }else{

                    $times = $this->property['width']/$this->config['width'];

                    $this->img->thumb($this->config['width'],$this->property['height']*$times,1);
                }


            }

            $this->img->thumb($this->config['width'],$this->config['height'],$this->type);



            /*保存处理后的图片*/
            $res = $this->img->save($new_path);
            if(!$res){
                $data['code'] = '-1';
                $data['msg'] = '在处理图片文件时出错了';
                return $data;
            }
            /*若存在图片,则无需新生成*/
        }else{

        }
        /*使用处理后的图片生成预览图片*/
        /*组装预览图片存储路径*/
        $preview_path = $this->config['preview'].$new_name;
        /*查看预览图片是否存在*/
        if(!file_exists($preview_path)){
            $preview_SplFileInfo = new \SplFileInfo($new_path);
            $preview_img = new Image($preview_SplFileInfo);


            if(($this->config['width']/$this->config['height']) > ($this->config['preview_width']/$this->config['preview_height'])){
                $new_times = $this->config['width']/$this->config['preview_width'];

                $preview_img->thumb($this->config['preview_width'],$this->config['height']/$new_times,1);
            }else{
                $new_times = $this->config['height']/$this->config['preview_height'];
                $preview_img->thumb($this->config['width']/$new_times,$this->config['preview_height'],1);
            }
            $res = $preview_img->save($preview_path);
            if(!$res){
                $data['code'] = '-1';
                $data['msg'] = '在处理预览图片文件时出错了';
                return $data;
            }
        }else{

        }

        $data['code'] = 1;
        $data['msg'] = '';
        $data['path'] = $this->config['path'].$preview_path;  /*预览图路径*/
        $data['temp_path'] = $this->name; /*原图名*/
        return $data;


    }


    /**
     * 单选框选择事件
     */

    public function radioChange(){
        /*获取图片处理方式*/
        $this->type = $_POST['checked']?$_POST['checked']:'';
        /*获取原图名*/
        $name = $_POST['temp_path']?$_POST['temp_path']:'';
        $this->name = $name;
        /*组装原图路径,先根据配置信息组装*/
        $path = $this->config['temp'].$name;
        if(!file_exists($path)){
            /*根据配置未发现原图,则搜索原图路径*/
            $result = model('admin/attachment')->getFileInfo($this->name);
            if(!$result || !file_exists($result['path'])){
                $data['code'] = '-1';
                $data['msg'] = '未搜索到原图';
                return $data;
            }

        }else{
            $this->SplFileInfo = new \SplFileInfo($path);
            $this->img = new Image($this->SplFileInfo);
            $this->property['width'] = $this->img->width();
            $this->property['height'] = $this->img->height();
        }
    }

    /**
     * 确定事件
     */

    public function process(){
        /*获取总文件数量*/
        $number = $_POST['number'];
        /*获取处理数组*/
        $data = json_decode($_POST['data'],true);

        if($number > $this->config['number']){
            $res['code'] = -1;
            $res['msg'] = '超过上传最大数量,最大数量为'.$this->config['number'];
            return $res;
        }else{
            $res['path'] = json_encode($this->save($data),true);
            $res['code'] = 1;
            $res['msg'] = '已成功保存图片';
            return $res;
        }


    }

    /**
     * 按要求保存,删除图片
     * @array $data
     */
    public function save($data){

        /*初始化return 数组*/
        $result = array();
        /*初始化attachment模型*/
        $attachment = model('admin/attachment');
        /*初始化图片路径检查数组*/
        $check_path_array = array();
        /*处理图片*/
        foreach($data as $key=>$value){

            $name = $this->config['width'].'_'.$this->config['height'].'_'.$value['name'];
            /*获取图片信息*/
            $file_info  = $attachment->getFileInfo($value['name']);

            if($value['type'] != 0){

                switch ($value['type'])
                {
                    case 2:
                        $save_path = $this->config['write'].'write_'.$name;
                        break;

                    case 3:
                        $save_path = $this->config['crop'].'crop_'.$name;
                        break;

                    case 6:
                        $save_path = $this->config['thumb'].'thumb_'.$name;
                        break;

                }
                /*图片切片,在切片时进行保存*/
                $this->cut($save_path,$value['name'],$value['type']);
                $result[$key]['elements'] = $this->config['path'].$save_path;
                /*根据宽高等参数,确定ID*/
                $find['pid'] = $file_info['id'];
                $find['width'] = $this->config['width'];
                $find['height'] = $this->config['height'];
                $find['type'] = $value['type'];
                $find['size'] = array('IN',$this->config['cut_size']);
                $id_array = Db::name('admin_pictures')->where($find)->field('id')->select();

                $result[$key]['id'] = implode(',',array_column($id_array,'id'));
                $result[$key]['width'] = $this->config['width'];
                $result[$key]['height'] = $this->config['height'];
                $result[$key]['cut_size'] = $this->config['cut_size'];
                $result[$key]['type'] = $value['type'];
                $check_path_array[] = $save_path;
                /*$value['type'] = 0  则表示该图片已上传,但用户最终关闭了该图片框 此处不作任何处理*/
            }else{

            }


        }
        $result = array_values($result);
        /*删除图片*/
        foreach($data as $item => $val){

            $name = $this->config['width'].'_'.$this->config['height'].'_'.$val['name'];;

            if($val['type'] == 0){  //用户上传过该图片,之后关闭了框体
                //该图片在本次操作中,没有保存任何的额外处理路径
                file_exists($this->config['crop'].'crop_'.$name)&&!in_array($this->config['crop'].'crop_'.$name,$check_path_array)?unlink($this->config['crop'].'crop_'.$name):'';
                file_exists($this->config['thumb'].'thumb_'.$name)&&!in_array($this->config['thumb'].'thumb_'.$name,$check_path_array)?unlink($this->config['thumb'].'thumb_'.$name):'';
                file_exists($this->config['write'].'write_'.$name)&&!in_array($this->config['write'].'write_'.$name,$check_path_array)?unlink($this->config['write'].'write_'.$name):'';

            }elseif($val['type'] == 2){
                file_exists($this->config['crop'].'crop_'.$name)&&!in_array($this->config['crop'].'crop_'.$name,$check_path_array)?unlink($this->config['crop'].'crop_'.$name):'';
                file_exists($this->config['thumb'].'thumb_'.$name)&&!in_array($this->config['thumb'].'thumb_'.$name,$check_path_array)?unlink($this->config['thumb'].'thumb_'.$name):'';
            }elseif($val['type'] == 3){
                file_exists($this->config['write'].'write_'.$name)&&!in_array($this->config['write'].'write_'.$name,$check_path_array)?unlink($this->config['write'].'write_'.$name):'';
                file_exists($this->config['thumb'].'thumb_'.$name)&&!in_array($this->config['thumb'].'thumb_'.$name,$check_path_array)?unlink($this->config['thumb'].'thumb_'.$name):'';
            }elseif($val['type'] == 6){
                file_exists($this->config['crop'].'crop_'.$name)&&!in_array($this->config['crop'].'crop_'.$name,$check_path_array)?unlink($this->config['crop'].'crop_'.$name):'';
                file_exists($this->config['write'].'write_'.$name)&&!in_array($this->config['write'].'write_'.$name,$check_path_array)?unlink($this->config['write'].'write_'.$name):'';
            }

        }

        /*删除预览图片*/
        $preview_path_array = scandir($this->config['preview']);
        foreach($preview_path_array as $key=>$value){
            @unlink($this->config['preview'].$value);
        }

        return $result;
    }


    /**
     * 最终保存图片切片
     */

    public function cut($path,$name,$type){

        if($type == 2){
            $assembly = 'write';
        }
        if($type ==3){
            $assembly = 'crop';
        }
        if($type == 6){
            $assembly = 'thumb';
        }

        $cut_size = $this->config['cut_size'];
        /*将处理过的图片作为新的资源*/
        $cut_SplFileInfo = new \SplFileInfo($path);
        $cut_img = new Image($cut_SplFileInfo);



        $cut_img->open($cut_SplFileInfo);

        foreach($cut_size as $key=>$value){
            /*每次准备生成切图时,检查文件名  切图文件名格式  example =>  50_thumb_690_300_XXX.jpg*/
            $new_path = $this->config['cut'].$value.'/'.$value.'_'.$assembly.'_'.$this->config['width'].'_'.$this->config['height'].'_'.$name;
            $width = $this->config['width']*$value/100;
            $height = $this->config['height']*$value/100;
            if(!file_exists($new_path)){

                $cut_img->thumb($width,$height,6);

                $cut_img->save($new_path);
                /*图片已存在则什么都不做*/
            }else{

            }
            /*生成图片过后,更新数据库*/

            /*先获取到该图片的ID*/
            $attachment = model('admin/attachment');
            $result = $attachment->getFileInfo($name);
            /*检查是否有记录*/
            if($result){
                $check = Db::name('admin_pictures')->where('pid','eq',$result['id'])->where('size','eq',$value)->where('type','eq',$type)->find();
                /*已有该切图的记录,则什么都不做*/
                if($check){

                }else{
                    $info['pid'] = $result['id'];
                    $info['path'] = $new_path;
                    $info['type'] = $type;
                    $info['size'] = $value;
                    $info['width'] = $this->config['width'];
                    $info['height'] = $this->config['height'];
                    $info['create_time'] = time();
                    Db::name('admin_pictures')->insert($info);
                }


            }else{
                $data['code'] = '-1';
                $data['msg'] = '未查询到图片ID,请尝试重新上传';
                echo json_encode($data);
                exit;
            }



        }



    }

    /**
     * 根据图片路径,定位原图并生成预览图片
     */

    public function getPreview($pic_array){

        $array = json_decode($pic_array,true);



        $new_array = array();

        /*定位原图路径*/
        foreach($array as $key => &$value){
            $result = Db::name('admin_pictures')->where('id','eq',$value)->find();
            $result_temp = Db::name('admin_attachment')->where('id','eq',$result['pid'])->find();
            $new_array[$key]['type'] = $result['type'];
            $new_array[$key]['path'] = $result_temp['path'];

        }
        unset($result);

        $result = array();

        foreach($new_array as $E => $F){
            $result[] = $this->editImgProcess($F);
        }

        echo json_encode($result);
        exit;


    }


    /**
     * 编辑时 临时处理图片
     * @param array
     * [
     *  'path'=>'', 原图路径
     *  'type'=> '', 处理方式
     * ]
     * #return array|bool
     * [
     *  'path'=> '',预览图路径
     *  'temp_path'=> '', 原图路径
     *  'type'=> '',处理方式
     * ]
     */

    public function editImgProcess($array){

        //获取文件名
        $name_array = explode('/',$array['path']);
        $this->name = end($name_array);
        unset($name_array);

        if(file_exists($array['path'])){

            $this->SplFileInfo = new \SplFileInfo($array['path']);
            $this->img = new Image($this->SplFileInfo);
            $this->property['width'] = $this->img->width();
            $this->property['height'] = $this->img->height();

            if($array['type'] == 2){  //补白
                $path = $this->config['write'];
                $assembly = 'write';
            }
            if($array['type'] == 3){  //截取
                $path = $this->config['crop'];
                $assembly = 'crop';
            }
            if($array['type'] == 6){  //压缩
                $path = $this->config['thumb'];
                $assembly = 'thumb';
            }
            //先检查图片是否存在
            $new_path = $path.$assembly.'_'.$this->config['width'].'_'.$this->config['height'].'_'.$this->name;
            if(!file_exists($new_path)){
                $this->img->open($this->SplFileInfo);
                if($array['type'] == 2 ){   //补白

                    if(($this->property['width']/$this->property['height']) > ($this->config['width']/$this->config['height'])){

                        $times = $this->property['width']/$this->config['width'];
                        $this->img->thumb($this->config['width'],$this->property['height']*$times,1);
                    }else{

                        $times = $this->property['height']/$this->config['height'];
                        $this->img->thumb($this->property['width']*$times,$this->config['height'],1);
                    }

                }
                if($array['type'] == 3){ //截取
                    if(($this->property['width']/$this->property['height']) > ($this->config['width']/$this->config['height'])){


                        $times = $this->property['height']/$this->config['height'];
                        $this->img->thumb($this->property['width']*$times,$this->config['height'],1);


                    }else{

                        $times = $this->property['width']/$this->config['width'];

                        $this->img->thumb($this->config['width'],$this->property['height']*$times,1);
                    }


                }

                $this->img->thumb($this->config['width'],$this->config['height'],$array['type']);


                //保存操作后原图片

                $this->img->save($new_path);
            }



            //制作预览图片，将新生成的图片作为新的资源

            $preview_path = $this->config['preview'].$assembly.'_'.$this->config['width'].'_'.$this->config['height'].'_'.$this->name;
            //查看预览图片是否存在
            if(!file_exists($preview_path)){
                $preview_SplFileInfo = new \SplFileInfo($new_path);
                $preview_img = new Image($preview_SplFileInfo);


                if(($this->config['width']/$this->config['height']) > ($this->config['preview_width']/$this->config['preview_height'])){
                    $new_times = $this->config['width']/$this->config['preview_width'];

                    $preview_img->thumb($this->config['preview_width'],$this->config['height']/$new_times,1);
                }else{
                    $new_times = $this->config['height']/$this->config['preview_height'];
                    $preview_img->thumb($this->config['width']/$new_times,$this->config['preview_height'],1);
                }
                $preview_img->save($preview_path);
            }

        }else{
            return false;
        }
        $result['type'] = $array['type'];
        $result['temp_path'] = $this->name;
        $result['path'] = $this->config['path'].$preview_path;
        return $result;
    }


    public function newtest(){



        $res = $this->imgProcess();

        echo json_encode($res);
    }

    public function test(){

        $res = $this->process();
        echo json_encode($res);
    }





}