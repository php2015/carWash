<?php
namespace app\common\logic;
use app\common\model\Information as InformationModel;

class UserNews extends Base{
    protected $InformationModel = null;

    public function __construct(){
        parent::__construct();
        $this->InformationModel = new InformationModel;
    }

    /**
     * 资讯分类
     */
    public function newsClass()
    {
        return $this->InformationModel->newsClass();
    }

    /**
     *  资讯列表 || 默认返回第一个分类下的50条数据
     *  @param class_id 资讯分类id
     *  @param page 页数
     */
    public function newsList($params)
    {
        $data = [];
        // 如果分类id为空的情况,默认显示分类排序第一的资讯
        if(empty($params['class_id'])){
            // 查询排序第一的资讯
            $newsClass = $this->InformationModel->newsClass();
            if(!empty($newsClass)){
                $params['class_id'] = $newsClass[0]['id'];
            }
        }
        // 根据分类id查询对应的列表
        if(!empty($params['class_id'])){
            $list = $this->InformationModel->newsList($params['class_id'],$params['page']);
            foreach($list as &$val){
                //转换图片路径
                $val['icon'] = config('token.web_site_domain').get_file_path($val['icon']);
                $data[] = $val;
            }
        }
        return $data;
    }

    /**
     * 资讯详情
     * @param id 资讯id
     */
    public function newsDetail($params)
    {
        $html = $this->InformationModel->newsDetail($params);
        $_IMG_HOST = Rtrim(config('token.web_site_domain'),'/');//去掉右边域名多余的/
        $html['detail'] = str_replace("src=\"/", "src=\"" . $_IMG_HOST . "/", $html['detail']);//替换所有的src路径
        return $html;
    }

}