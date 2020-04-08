<?php
namespace app\common\logic;
use app\common\model\SellerPosition as SellerPositionModel;
use app\common\model\SellerStaff as SellerStaffModel;

class Management extends Base{
    protected $SellerPositionModel = null;
    protected $SellerStaffModel = null;

    public function __construct(){
        parent::__construct();
        $this->SellerPositionModel = new SellerPositionModel;
        $this->SellerStaffModel = new SellerStaffModel;
    }

    /**
     * 职位列表
     * @param seller_id 商家id
     * */ 
    public function positionList(array $params){
        $menu = getAllMenu();//获取所有菜单;
        $result = $this->SellerPositionModel->positionList($params);
        if(!empty($result)){
            //把权限接点替换成菜单名称
            foreach($result as &$val){
                $data = '';//节点替换的菜单名称容器
                $role_menu = explode(",",$val["role_node"]);
                foreach($menu as $vals){
                    if(in_array($vals['menu_id'], $role_menu)){
                        $data[] = $vals["menu_name"];
                    }
                }
                $val["role_menu"] = implode(",",$data);
            }
        }
        return $result;
    }

    /**
     * 显示编辑的职位
     * @params seller_id 商家id
     * @params position_id 职位id
     */
    public function editPosition(array $params){
        return $this->SellerPositionModel->editPosition($params);
    }


    /**
     * 新增/保存 职位
     * @param seller_id 商家id
     * @param position 职位名称
     * @param role_node 职能权限
     * @param position_id 职位id
     */
    public function savePosition(array $params){
        return $this->SellerPositionModel->savePosition($params);
    }

    /**
     * 显示编辑的权限职位信息
     * @param position_id 职位id
     * */ 
    public function positionInfo($params){
        $tmp = [];
        $menu = getAllMenu();//获取所有菜单;
        $result = $this->SellerPositionModel->positionInfo($params);
        $result = explode(",",$result['role_node']);
        if(!empty($result)){
            for($i=0,$len=count($result); $i<$len; $i++){
                $tmp[$i]["menu_id"] = (int)$result[$i];
                $tmp[$i]["menu_name"] = $menu[$i]["menu_name"];
            }
        }
        return $tmp;
    }

    /**
     * 显示权限列表
     */
    public function positionAllInfo(){
        $menu = getAllMenu();
        return $menu ? collection((array)$menu) : [];
    }

    /**
     * 删除 职位
     * @param position_id 职位id
     * */ 
    public function delPosition($params){
        return $this->SellerPositionModel->delPosition($params);
    }

    /**--------------------------------------------------------------------------------------------------------------------------------------------------------------- */

    /**
     * 员工列表
     * @param seller_id 商家id
     */
    public function employeeList(array $params){
        $result = $this->SellerStaffModel->employeeList($params);
        if(!empty($result)){
            foreach($result as &$val){
                $val["password"] = config("sundrys.password");
            }
        }
        return $result;
    }

    /**
     * 显示编辑的员工
     * @param seller_id 商家id
     * @param employee_id 员工id
     */
    public function editEmployee(array $params){
        return $this->SellerStaffModel->editEmployee($params);
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
        return $this->SellerStaffModel->saveEmployee($params);
    }

    /**
     * 检查电话是否唯一
     * @param phone 员工手机号
     * @param employee_id 员工id(编辑时需要核实电话)
     */
    public function employeePhone(array $params){
        $result = $this->SellerStaffModel->employeePhone($params);
        if(!empty($params['employee_id']) && !empty($result)){//编辑时检查查到的电话 是否 等于 该员工的电话
            if($params['employee_id'] == $result['id']){//若等于,则通过
                $result = 0;
            }else{//若不等,则驳回
                $result = 1;
            }
        }else if(!empty($result)){//新增时 电话存在
            $result = 1;
        }else{//新增电话不存在
            $result = 0;
        }
        return $result ? $result : 0;
    }

    /**
     * 删除员工
     * @params seller_id 商家id
     * @params employee_id 员工id
     */
    public function delEmployee(array $params){
        return $this->SellerStaffModel->delEmployee($params);
    }

    /**
     * 验证该商店是否存在该员工
     * @param seller_id 商家id
     * @param employee_id 员工id
     */
    public function existEmployee(array $params){
        return $this->SellerStaffModel->existEmployee($params);
    }

    /**
     * 重置员工密码
     * @param seller_id 商家id
     * @param employee_id 员工id
     */
    public function resetPassword(array $params){
        return $this->SellerStaffModel->resetPassword($params);
    }
    

}