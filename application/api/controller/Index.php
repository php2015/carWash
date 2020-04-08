<?php


namespace app\api\controller;
/**
 * APP API入口文件
 * Class Index
 * @package app\app\controller
 */
class Index extends Base
{

    public function index()
    {

        $controller = $this->controller;
        $action = $this->action;
        $version = $this->version;
        list($big) = explode('.', $version);//大版本号
        $class_path = sprintf("\app\api\controller\%s\%s", "v{$big}", ucfirst($controller));
        if (!class_exists($class_path)) {
            $this->status = 0;
            $this->message = '控制器不存在';
            return;
        }
        $class = new $class_path;
        if (!method_exists($class, $action)) {
            $this->status = 0;
            $this->message = '方法不存在';
            return;
        }
        $class->$action();
    }
}
