<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站：http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | 作者: 蔡伟明 <314013107@qq.com> 12
// +----------------------------------------------------------------------

// [ PHP版本检查 ]
header("Content-type: text/html; charset=utf-8");
if (version_compare(PHP_VERSION, '5.5', '<')) {
    die('PHP版本过低，最少需要PHP5.5，请升级PHP版本！');
}

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

// 检查是否安装
if(!is_file('../data/install.lock')){
    define('BIND_MODULE', 'install');
}

// 定义入口为admin
define('ENTRANCE', 'admin');

// +----------------------------------------------------------------------
// | 后台默认为关闭路由
// | 如果需要开启路由功能，请注释下面三句
// +----------------------------------------------------------------------
// 加载框架基础文件
require '../thinkphp/base.php';

// 关闭路由
\think\App::route(false);

// 执行应用
\think\App::run()->send();

// +----------------------------------------------------------------------
// | 默认为关闭路由
// | 如果需要开启路由，请取消以下注释
// +----------------------------------------------------------------------
// 加载框架引导文件
// require './thinkphp/start.php';