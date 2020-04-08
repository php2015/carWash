<?php

namespace app\common\validate;

use think\Validate;

/**
 * 职位,员工,设置功能的验证器
 * Class Management
 * @package app\common\validate
 */
class Management extends Validate
{
    //定义验证规则
    protected $rule = [
        'seller_id|商家id' => 'require|number',
        // 新增/保存 职位
        'position|职位名称' =>  'require|max:25',
        'role_node|职能权限' => 'require',
        // 显示编辑 职位
        'position_id|职位id' => 'require',
        // 编辑 员工
        'employee_id|员工id' => 'require',
        // 新增/保存 员工
        'name|员工名称' =>  'require|max:25',
        'phone|员工手机号' => 'require|number|length:11|checkMobilePattern',
        // 修改密码验证
        'old_pass'    =>    'require',
        'new_pass'    =>    'require',
        // 提现id验证
        'cash_account_id'   =>  'require|number',
        // 提现账户列表类型
        'type'   =>  'require|number',
        // 新增账号
        'account|账号'   =>  'require|length:1,25',
        'mobile|手机号'   =>  'require|number|length:11|checkMobilePattern',
        'account_name|持卡人姓名'   =>  'require',
        'bank_id|开户行(后台银行卡表id)'   =>  'require|number',
        'idcard|身份证号'   =>  ['/(^\d(15)$)|((^\d{18}$))|(^\d{17}(\d|X|x)$)/'],
        'status|状态'   =>  'require|number',
        // 获取 账号 编辑信息
        'id|商家提现账号表id'   =>  'require|number',
        // 提现金额
        'cash_price'    => 'require|number|min:1',
        // 用户订单id
        'user_order_id' =>  'require|number',
    ];

    //定义验证提示
    protected $message = [
        'seller_id.require' => '请传入商家id!',
        'seller_id.number' => '商家id必须为数字!',
        // 新增/保存 职位
        'position.require' => '职位名称不能为空!',
        'position.max' => '职位名称不能超过25个汉字!',
        'role_node.require' => '至少选择一项职能权限!',
        'position_id.require' => '请传入职位id!',
        'employee_id.require' => '请传入员工id!',
        // 新增/保存 员工
        'name.require' => '请填写员工姓名!',
        'name.max' => '请填写2-16个汉字字符!',
        'phone.require' => '请填写员工手机号!',
        'phone.number' => '请输入正确的手机号!',
        'phone.length' => '请输入11位的手机号!',
        'phone.checkMobilePattern' => '手机号格式错误!',
        // 修改密码验证
        'old_pass.require'    =>    '原密码必填!',
        'new_pass.require'    =>    '新密码必填!',
        // 提现id验证
        'cash_account_id.require' => '请传入提现id!',
        'cash_account_id.number' => '提现id必须为数字!',
         // 提现账户列表类型
        'type.require' => '请传入类型!',
        'type.number' => '类型必须为数字!',
        // 新增账号
        'account.require' => '请传入账号!',
        'account.length' => '限制输入25位!',
        'mobile.require' => '请传入手机号!',
        'mobile.number' => '手机号必须为数字!',
        'mobile.length' => '手机号必须为11位!',
        'mobile.checkMobilePattern' => '手机号格式错误!',
        'account_name.require' => '持卡人不能为空!',
        'bank_id.require' => '请传入开户行!',
        'bank_id.number' => '开户行id必须为数字!',
        'idcard' => '非法身份证号，请仔细核实',
        'status.require' => '请传入状态!',
        'status.number' => '状态必须为数字!',
        // 获取 账号 编辑信息
        'id.require' => '请传入账号id!',
        'id.number' => '账号必须为数字!',
        // 提现金额
        'cash_price.require' => '提现金额不能为空!',
        'cash_price.number' => '提现金额必须为数字!',
        'cash_price.min' => '提现金额必须大于1!',
        // 用户订单id
        'user_order_id.require' => '用户订单id不能为空!',
        'user_order_id.number' => '用户订单id必须为数字!',
    ];

    //定义验证场景
    protected $scene = [
        // 查看职位列表
        'positionList' => ['seller_id'],
        // 新增/保存 职位
        'savePosition'  => ['position','role_node','seller_id'],

        // 新增员工
        'addEmployee'   =>  ['seller_id','name','phone'],
        // 显示编辑的员工
        'editEmployee'  =>['seller_id','employee_id'],
        // 保存编辑 员工
        'saveEmployee'  => ['seller_id','position_id','employee_id'],
        // 修改密码验证
        'changePassword' => ['old_pass','new_pass','seller_id'],
        // 提现详情
        'spDetails' => ['cash_account_id'],
        // 提现账号列表
        'accountList' => ['seller_id','type'],
        // 新增银行账号
        'addBankAcount' => ['type','bank_id','account','idcard','mobile','account_name','status'],
        // 新增微信或支付宝账号
        'addAcount' => ['type','account','mobile','account_name','status'],
        // 获取 账号 编辑信息
        'editAccountInfo' => ['id'],
        // 提现金额
        'withdrawCash'  => ['cash_account_id','seller_id','cash_price'],
        // 验证用户订单id
        'user_order_id' => ['user_order_id'],
        //删除职位
        'delPosition'   =>  ['position_id'],
    ];

    /**
     * 验证手机号码格式
     * @param $value
     * @return bool
     */
    public function checkMobilePattern($value, $rule, $data)
    {
        $preg = '/^(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/';
        return preg_match($preg, $value) ? true : "手机号码格式填写错误,请重新填写";
    }
}
