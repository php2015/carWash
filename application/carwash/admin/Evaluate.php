<?php
namespace app\carwash\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;

class Evaluate extends Admin
{
    /**
     * 评价列表
     */
    public function index()
    {
        // 获取查询条件
        $map = $this->getMap();
        // 读取评价数据
        $list = model('Evaluate')->evaList($map);
        /**
         * 筛选条件
         */
        $type = [1=>"差评",2=>"一般",3=>"好评"];
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setTableName('comment')
            ->hideCheckbox()
            ->setSearch(['u.nickname' => '用户名', 's.sellername' => '商家名']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['nickname', '用户名'],
                ['mobile', '手机号码'],
                ['sellername', '商家名称'],
                ['servicename', '商家服务'],
                ['comment_type', '评价类型', 'status', '', ['', '差评', '一般', '好评']],
                ['content', '评价内容'],
                ['create_time', '评价时间', 'datetime'],
                ['is_release', '状态', 'status', '', ['显示', '屏蔽']],
                ['is_release', '操作', 'switch']
            ])
            ->addTopSelect('comment_type', '评价类型', $type)
            ->setRowList($list) // 设置表格数据
            ->css('admin', 'common')
            ->setPageTips('切换状态之后,请刷新一下页面~')
            ->fetch(); // 渲染页面
    }

}