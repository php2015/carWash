<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/6
 * Time: 11:40
 */

namespace app\carwash\validate;


class HomePageCate extends Base
{
    //定义验证规则
    protected $rule = [
        'id|服务类别id'     => 'require',
        'catename|服务类别' => 'require|regChinese|max:20|unique:homepage_cate',
        'order_num|排序'    => 'require|gt:0',
        'is_enable|状态'    => 'require',
    ];

    //定义验证提示
    protected $message = [
        'id.require'          => '请选择服务类别',
        'catename.require'    => '服务名称不能为空',
        'catename.regChinese' => '服务名称只允许输入中文',
        'catename.max'        => '服务类别最多只能输入20个汉字',
        'order_num.require'   => '排序值不能为空',
        'order_num.gt'        => '排序值必须大于0',
        'is_enable.require'   => '请选择状态',

    ];
}