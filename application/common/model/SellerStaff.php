<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/13
 * Time: 15:18
 */

namespace app\common\model;

use think\Db;
use think\Model;
use think\helper\Hash;

/***
 * 商家员工表模型
 * Class Seller
 * @package app\common\model
 * @property integer id             商家员工id
 * @property integer seller_id      商家id
 * @property integer seller_position_id 员工职位id
 * @property string  staffname      员工姓名
 * @property string  mobile         电话
 * @property string  password       密码
 * @property integer create_time    创建时间
 * @property integer update_time    更新时间
 * @property integer is_disable     是否停用[0不停用|1停用]
 */
class SellerStaff extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /**
     * 查看职位id下的员工的个数
     * @param position_id 职位id
     */
    public function positionEmployee($position_id)
    {
        $map['seller_position_id'] = $position_id;
        $result = $this->where($map)->count('id');
        return $result ? $result : 0;
    }

    /**
     * 重置员工密码
     * @params seller_id 商家id
     * @params employee_id 员工id
     */
    public function resetPassword(array $params){
        return $this->where("seller_id=".$params["seller_id"]." and id=".$params["employee_id"])->update(['password' => $params["password"]]);
    }

    /**
     * 验证该商店是否存在该员工
     * @param seller_id 商家id
     * @param employee_id 员工id
     */
    public function existEmployee(array $params){
        $result = $this->where("seller_id=".$params["seller_id"]." and id=".$params["employee_id"])->find();
        return $result ? 1 : 0;
    }

    /**
     * 删除员工
     * @param seller_id 商家id
     * @param employee_id 员工id
     */
    public function delEmployee(array $params){
        return $this->where("seller_id=".$params["seller_id"]." and id=".$params["employee_id"])->delete();
    }

    /**
     *  检查电话是否唯一
     * @param employee_id 员工id
     * @param phone 员工手机
     */
    public function employeePhone(array $params){
        $result = $this->where("mobile",$params["phone"])->field('id')->find();
        return $result ? $result : [];
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
        $data = [];
        if(empty($params["employee_id"])){//新增
            $data = [
                'seller_id' => $params["seller_id"],
                'staffname' => $params["name"],
                'mobile' => $params["phone"],
                'password' => Hash::make(config("sundrys.password")),
                'seller_position_id' => $params["position_id"],
                'create_time' =>time()
            ];
            return $this->insert($data);
        }else{//保存编辑
            $data = [
                'seller_position_id' => $params["position_id"],
                'staffname' => $params["name"],
                'mobile' => $params["phone"],
                'update_time'=>time()
            ];
            return $this->where("seller_id=".$params["seller_id"]." and id=".$params["employee_id"])->update($data);
        }
    }

    /**
     *  判断是否已存在职位 || 查看员工信息
     * @param seller_id 商家id
     * @param employee_id 员工id
     */
    public function editEmployee(array $params){
        $result = "";
        if(!empty($params["employee_id"])){//查看该员工信息
            $position = Db::name('seller_position')->where("seller_id = ".$params["seller_id"])->field('id as position_id,position')->select();

            $result = $this->alias('ss')
            ->join('dp_seller_position sp','ss.seller_position_id = sp.id')
            ->where("ss.seller_id=".$params["seller_id"]." and ss.id=".$params["employee_id"])
            ->field('ss.id as staffid,ss.staffname,ss.mobile,sp.position as position_name,sp.id as position_id,ss.create_time')
            ->find();
            if($result == []){
                return [];
            }
            $result["password"] = config("sundrys.password");
            $result["position_list"] = $position;
        }
        return $result ? $result : [];
    }

    /**
     * 员工列表
     * chenxin
     * @param seller_id 商家id
     */
    public function employeeList(array $params){
        $result = $this->alias('ss')
                ->join('dp_seller_position sp','ss.seller_position_id = sp.id')
                ->where("ss.seller_id =".$params['seller_id']." and ss.is_shopkeeper != 1")
                ->field('ss.id,ss.staffname,ss.mobile,sp.position,sp.id as position_id,ss.create_time')
                ->select();
        return $result ? $result : [];
    }

    /***
     * 登录|查询手机号是否存在
     * @param $mobile
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStaffMobile($mobile)
    {
        return $this
            ->field('ss.*,s.sellername,sp.position,s.vmphone')
            ->alias('ss')
            ->join('dp_seller s','ss.seller_id = s.id','left')
            ->join('dp_seller_position sp','ss.seller_position_id = sp.id','left')
            ->where('ss.mobile',$mobile)
            ->find();
    }

    /***
     * 根据商家id获取店主id
     * @param $sellerId
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStaffId($sellerId)
    {
        $where['is_disabled'] = 0; //是否停用,0不停用|1停用
        $where['is_shopkeeper'] = 1; //是否是店主,0不是,1是
        $where['seller_id'] = $sellerId;
        return $this->field('id')->where($where)->find();
    }
    /***
     * 新增商家员工
     * @param $params
     * @return int
     */
    public function addStaff($params)
    {
        $this->save($params);
        return $this->id;
    }

    /****
     * 获取商家员工列表
     * @param $sellerId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStaffList($sellerId)
    {
        $where['ss.seller_id'] = $sellerId;
        $field = "ss.id,CONCAT(sp.position,':',ss.staffname) as staffname";
        //$field = 'id,staffname';
        //return $this->field($field)->where($where)->select();
        return $this
            ->field($field)
            ->alias('ss')
            ->where($where)
            ->join('dp_seller_position sp','ss.seller_position_id = sp.id')
            ->select();
    }

    /**
     * 验证原密码是否正确
     * @param seller_ud 商家id
     */
    public function correctPass(array $params)
    {
        // 商家员工表   查询  该店主  原密码
        $result = $this->alias('ss')
                ->join('dp_seller_position sp','ss.seller_position_id = sp.id')
                ->where("ss.seller_id=".$params["seller_id"]." and sp.role_node like '".config('sundrys.sellerrole')."'")
                ->field("ss.password")->find();
        return $result ? $result : 0;
    }

    /**
     * 修改密码
     * @param seller_ud 商家id
     * @param new_pass 输入的密码
     */
    public function changePassword(array $params)
    {
        return  $this->alias('ss')
                ->join('dp_seller_position sp','ss.seller_position_id = sp.id')
                ->where("ss.seller_id=".$params["seller_id"]." and sp.role_node like '".config('sundrys.sellerrole')."'")
                ->update(['password' => $params["new_pass"]]);
    }
}