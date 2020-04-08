<?php
/**
 * 陈鑫 Visual Studio
 */
namespace app\api\controller\v1;
use app\api\controller\Base;
use think\Request;
use app\common\service\UserNews as UserNewsService;
/**
 * 用户端资讯模块接口类
 * Class UserNews
 * @package app\api\controller\v1
 */
class UserNews extends Base
{
    protected $UserNewsService = null;

    function __construct(Request $request = null){
        $this->UserNewsService = new UserNewsService;
        parent::__construct($request);
    }

     /**
     * 资讯分类
     */
    public function newsClass()
    {
        $this->UserNewsService->newsClass();
        list($this->status, $this->message, $this->data) = [$this->UserNewsService->status, $this->UserNewsService->message, $this->UserNewsService->data];
    }

    /**
     * 资讯列表
     * @param class_id 资讯分类id
     * @param page 页数
     */
    public function newsList()
    {
        $params = [
            'class_id' => input('class_id', '', 'trim'),
            'page' => input('page', '', 'trim'),
        ];
        $this->UserNewsService->newsList($params);
        list($this->status, $this->message, $this->data) = [$this->UserNewsService->status, $this->UserNewsService->message, $this->UserNewsService->data];
    }

    /**
     * 资讯详情
     * @param id 资讯id
     */
    public function newsDetail()
    {
        $params = [
            'id' => input('id', '', 'trim'),
        ];
        $this->UserNewsService->newsDetail($params);
        list($this->status, $this->message, $this->data) = [$this->UserNewsService->status, $this->UserNewsService->message, $this->UserNewsService->data];
    }

}