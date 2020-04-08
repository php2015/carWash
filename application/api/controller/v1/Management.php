<?php
namespace app\api\controller\v1;
use think\helper\Hash;
use app\api\controller\Base;
use think\Request;
use app\common\service\Management as ManagementService;
use think\Db;
/**
 * 商家端 员工,职位管理模块接口类
 * Class Management
 * @package app\api\controller\v1
 */
class Management extends Base
{
    protected $ManagementService = null;

    function __construct(Request $request = null){
        $this->ManagementService = new ManagementService;
        parent::__construct($request);
    }

    /**
     * 职位列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @param seller_id 商家id
     */
    public function positionList()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->ManagementService->positionList($params);
        list($this->status, $this->message, $this->data) = [$this->ManagementService->status, $this->ManagementService->message, $this->ManagementService->data];
    }

    /**
     * 新增/保存 职位
     * @param seller_id 商家id
     * @param position 职位名称
     * @param role_node 职能权限
     * @param position_id 职位id
     */
    public function savePosition(){
        $params = [
            'seller_id' => $this->sellerid,
            'position' => input('position', '', 'trim'),
            'role_node' => input('role_node', '', 'trim'),
            'position_id' => input('position_id', '', 'trim'),
        ];
        $this->ManagementService->savePosition($params);
        list($this->status, $this->message, $this->data) = [$this->ManagementService->status, $this->ManagementService->message, $this->ManagementService->data];
    }

    /**
     * 显示编辑的权限职位信息
     * @param position_id 职位id
     * */ 
    public function positionInfo(){
        $params = [
            'position_id' => input('position_id', '', 'trim'),
        ];
        $this->ManagementService->positionInfo($params);
        list($this->status, $this->message, $this->data) = [$this->ManagementService->status, $this->ManagementService->message, $this->ManagementService->data];
    }

    /**
     * 显示权限列表
     */
    public function positionAllInfo(){
        $this->ManagementService->positionAllInfo();
        list($this->status, $this->message, $this->data) = [$this->ManagementService->status, $this->ManagementService->message, $this->ManagementService->data];
    }

    /**
     * 删除 职位
     * @param position_id 职位id
     * */ 
    public function delPosition(){
        $params = [
            'position_id' => input('position_id', '', 'trim'),
        ];
        $this->ManagementService->delPosition($params);
        list($this->status, $this->message, $this->data) = [$this->ManagementService->status, $this->ManagementService->message, $this->ManagementService->data];
    }

/**--------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    /**
     * 员工列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @param seller_id 商家id
     */
    public function employeeList()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->ManagementService->employeeList($params);
        list($this->status, $this->message, $this->data) = [$this->ManagementService->status, $this->ManagementService->message, $this->ManagementService->data];
    }

    /**
     * 显示编辑的员工信息
     * @param seller_id 商家id
     * @param employee_id 员工id
     */
    public function editEmployee(){
        $params = [
            'seller_id' => $this->sellerid,
            'employee_id' => input('staffid', '', 'trim'),
        ];
        $this->ManagementService->editEmployee($params);
        list($this->status, $this->message, $this->data) = [$this->ManagementService->status, $this->ManagementService->message, $this->ManagementService->data];
    }

    /**
     * 新增/保存 员工
     * @param seller_id 商家id
     * @param name 员工名称
     * @param phone 员工手机号
     * @param position_id 员工职位id
     * 编辑保存 新增参数
     * @param employee_id 员工id
     */
    public function saveEmployee(){
        $params = [
            'seller_id' => $this->sellerid,
            'employee_id' => input('staffid', '', 'trim'),
            'name' => input('name', '', 'trim'),
            'phone' => input('phone', '', 'trim'),
            'position_id' => input('position_id', '', 'trim'),
        ];
        $this->ManagementService->saveEmployee($params);
        list($this->status, $this->message, $this->data) = [$this->ManagementService->status, $this->ManagementService->message, $this->ManagementService->data];
    }

    /**
     * 删除员工
     * @param seller_id 商家id
     * @param employee_id 员工id
     */
    public function delEmployee(){
        $params = [
            'seller_id' => $this->sellerid,
            'employee_id' => input('staffid', '', 'trim'),
        ];
        $this->ManagementService->delEmployee($params);
        list($this->status, $this->message, $this->data) = [$this->ManagementService->status, $this->ManagementService->message, $this->ManagementService->data];
    }

    /**
     * 重置员工密码
     * @param seller_id 商家id
     * @param employee_id 员工id
     */
    public function resetPassword(){
        $params = [
            'seller_id' => $this->sellerid,
            'employee_id' => input('staffid', '', 'trim'),
            'password'      => Hash::make(config('sundrys.password'))
        ];
        $this->ManagementService->resetPassword($params);
        list($this->status, $this->message, $this->data) = [$this->ManagementService->status, $this->ManagementService->message, $this->ManagementService->data];
    }

}