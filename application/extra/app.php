<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/6
 * Time: 18:21
 */
use think\Request;
return [
    'integral'=>1,//权益卡
    'times'   =>2,//次数卡
    'qrCode_expire_time'   =>60, //二维码过期时间
    'payMent_input_times'  =>5,  //密码输入错误次数4,3,2,1,0
    'errPayPwd_input_times'=>4,  //可输入的错误次数
    'payMent_expire_time'  =>0,  //支付密码密码输入错误间隔时间
    'message_expire_time'  =>60, //短信过期时间
    'captcha'=>[
        'codeSet'   => '23456789wertyupkjhgfdsazxcvbnm', //验证码字符集合
        'expire'    => 1800,                             //有效时间
        'fontSize'  => 18,                               //字体大小
        'useCurve'  => false,                            //是否混淆曲线
        'useNoise'  => false,                            //关闭杂点
        'imageH'    => 50,
        'imageW'    => 130,
        'length'    => 4,
        'reset'     => true,                             //验证成功之后重置验证码
    ],
    'uploads'=>[
        'config'=>[
            'title'         =>  '图片上传',
            'size'          => '1048576',               //图片大小
            'width'         =>  '200',                  //长  690
            'height'        =>  '200',                  //高  300
            'type'          =>  ['jpg','png','jpeg'],   //限制上传类型
            'elements'      =>  true,                   //是否保存原图
            'number'        =>  '3',                    //上传图片数量限制,按照业务逻辑=>单独限制数量
            'temp'          =>  'upload/temp/',         //原图缓存路径
            'crop'          =>  'upload/crop/',         //截图保存路径
            'thumb'         =>  'upload/thumb/',        //压缩保存路径
            'write'         =>  'upload/write/',        //补白保存路径
            'cut'           =>  'upload/cut/',          //切片保存路径
            'preview'       =>  'upload/preview/',      //预览图片保存路径 点击确定都会删除'
            'cut_size'      =>  [100],                  //切片尺寸 可设置 如[100,50,25]单位%
            'path'          =>  Request::instance()->domain() . '/',  //网站静态文件路径
        ]
    ],
    'input_paypwd_status' =>1001,                        //支付密码输入错误5次状态码
    'commission_rate'   =>5,                             //默认手续费比例

];