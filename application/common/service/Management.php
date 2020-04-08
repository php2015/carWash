<?php
namespace app\common\service;

use app\common\logic\Management as ManagementLogic;
use app\common\model\SellerStaff as SellerStaffModel;
use think\exception\DbException;

class Management extends Base{
    protected $ManagementLogic = null;
    protected $SellerStaffModel = null;

    public function __construct(){
        parent::__construct();
        $this->ManagementLogic = new ManagementLogic;
        $this->SellerStaffModel = new SellerStaffModel;
    }

    /**
     * 职位列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @param seller_id 商家id
     */
    public function positionList(array $params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证商家id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->ManagementLogic->positionList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 新增/保存 职位
     * @param seller_id 商家id
     * @param position 职位名称
     * @param role_node 职能权限
     * @param position_id 职位id
     */
    public function savePosition(array $params){
        $validate = validate('Management');
        if (!$validate->check($params, [],'savePosition')) {
            $this->message = $validate->getError();
            return;
        }
        if(empty($params["position_id"])){//新增时验证是否已存在同名职位
            $exist = $this->ManagementLogic->editPosition($params);
            if(!empty($exist)){
                list($this->status, $this->message) = [0, "当前职位已存在,请重新输入!"];
                return;
            }
        }
        try{
            $this->ManagementLogic->savePosition($params);
            list($this->status, $this->message) = [1, "操作成功"];
        }catch(DbException $e){
            list($this->status, $this->message) = [0, "操作失败"];
        }
        return;
    }

    /**
     * 显示编辑的权限职位信息
     * @param position_id 职位id
     * */ 
    public function positionInfo($params){
        $data = $this->ManagementLogic->positionInfo($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 显示权限列表
     */
    public function positionAllInfo(){
        $data = $this->ManagementLogic->positionAllInfo();
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 删除 职位
     * @param position_id 职位id
     * */ 
    public function delPosition($params){
        $validate = validate('Management');
        if (!$validate->check($params, [],'delPosition')) {
            $this->message = $validate->getError();
            return;
        }
        $exist = $this->ManagementLogic->editPosition($params);
        if(empty($exist)){
            list($this->status, $this->message) = [0, "不存在该职位!"];
            return;
        }
        // 1.判断该职位下存在员工的个数
        $staff_exist = $this->SellerStaffModel->positionEmployee($params['position_id']);
        // 2.若>0则不能删除职位
        if($staff_exist > 0){
            list($this->status, $this->message) = [0, "请先删除职位下的员工!"];
            return;
        }
        try{
            $this->ManagementLogic->delPosition($params);
            list($this->status, $this->message) = [1, "删除成功"];
        }catch(DbException $e){
            list($this->status, $this->message) = [0, "删除失败"];
        }
        return;
    }
    /**--------------------------------------------------------------------------------------------------------------------------------------------------------------- */

    /**
     * 员工列表
     * @param seller_id 商家id
     */
    public function employeeList(array $params)
    {
        $validate = validate('Management');
        if (!$validate->check($params, [],'positionList')) {//验证商家id
            $this->message = $validate->getError();
            return;
        }
        $data = $this->ManagementLogic->employeeList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 显示编辑的员工
     * @params seller_id 商家id
     * @params employee_id 员工id
     */
    public function editEmployee(array $params){
        $validate = validate('Management');
        if (!$validate->check($params, [],'editEmployee')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->ManagementLogic->editEmployee($params);
        if(empty($data)){
            list($this->status, $this->message) = [0, "该员工不存在"];
            return;
        }
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

     /**
     * 新增/保存 员工
     * @params seller_id 商家id
     * 新增
     * @params name 员工名称
     * @params phone 员工手机号
     * @params position_id 员工职位id
     * 编辑保存
     * @params employee_id 员工id
     * @params position_id 员工职位id
     */
    public function saveEmployee(array $params){
        $validate = validate('Management');
        $data = "";
        // 检查电话
        $existphone = $this->ManagementLogic->employeePhone($params);
        if(!empty($existphone)){
            list($this->status, $this->message) = [0, "已存在该电话!"];
            return;
        }
        /**新增和编辑返回的账号(手机号),密码 */
        $data = ['phone'=>$params["phone"],'password'=>"a123456"];
        if(empty($params["employee_id"])){
            if (!$validate->check($params, [],'addEmployee')) {
                $this->message = $validate->getError();
                return;
            }
        }else{
            if (!$validate->check($params, [],'saveEmployee')) {
                $this->message = $validate->getError();
                return;
            }
            /**检查是否存在该员工 */
            $result = $this->ManagementLogic->editEmployee($params);
            if(empty($result)){
                list($this->status, $this->message) = [0, "该员工不存在"];
                return;
            }
        }  
       
        // 检查职位
        $exist = $this->ManagementLogic->editPosition($params);
        if(empty($exist)){
            list($this->status, $this->message) = [0, "该商店不存在该职位!"];
            return;
        }
        
        try{
            $this->ManagementLogic->saveEmployee($params);
            list($this->status, $this->message,$this->data) = [1, "操作成功",$data];
        }catch(DbException $e){
            list($this->status, $this->message) = [0, "操作失败"];
        }
        return;
    }

    /**
     * 删除员工
     * @param seller_id 商家id
     * @param employee_id 员工id
     */
    public function delEmployee(array $params){
        $validate = validate('Management');
        if (!$validate->check($params, [],'editEmployee')) {
            $this->message = $validate->getError();
            return;
        }
        $exist = $this->ManagementLogic->existEmployee($params);
        if(empty($exist)){
            list($this->status, $this->message) = [0, "该商店不存在删除的员工!"];
            return;
        }
        try{
            $this->ManagementLogic->delEmployee($params);
            list($this->status, $this->message) = [1, "删除成功"];
        }catch(DbException $e){
            list($this->status, $this->message) = [0, "删除失败"];
        }
        return;
    }

    /**
     * 重置员工密码
     * @params seller_id 商家id
     * @params employee_id 员工id
     */
    public function resetPassword(array $params){
        $validate = validate('Management');
        if (!$validate->check($params, [],'editEmployee')) {
            $this->message = $validate->getError();
            return;
        }
        $exist = $this->ManagementLogic->existEmployee($params);
        if(empty($exist)){
            list($this->status, $this->message) = [0, "该商店不存在该员工!"];
            return;
        }
        try{
            $this->ManagementLogic->resetPassword($params);
            list($this->status, $this->message) = [1, "重置密码成功"];
        }catch(DbException $e){
            list($this->status, $this->message) = [0, "重置密码失败"];
        }
        return;
    }

}