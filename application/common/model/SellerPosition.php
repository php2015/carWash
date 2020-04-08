<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/18
 * Time: 9:56
 */

namespace app\common\model;

use think\Model;

/***
 * 商家员工职位模型
 * Class SellerPosition
 * @package app\common\model
 * @property integer id            职位id
 * @property integer seller_id     商家id
 * @property string  position      职位名称
 * @property string  create_time   创建时间
 * @property string  role_node     权限节点
 * @property integer is_enable     是否启用[0启用|1禁用]
 */
class SellerPosition extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /**
     * 删除 职位
     * @param position_id 职位id
     * */ 
    public function delPosition($params){
        return $this->where("id=".$params["position_id"])->delete();
    }

    /**
     * 显示编辑的权限职位信息
     * @param position_id 职位id
     * */ 
    public function positionInfo($params){
        $result = $this->where("id=".$params["position_id"])->field('role_node')->find();
        return $result ? $result : [];
    }

    /**
     * 新增/保存 职位
     * @param seller_id 商家id
     * @param position 职位名称
     * @param role_node 职能权限
     * @param position_id 职位id
     */
    public function savePosition(array $params){
        if(!empty($params["position_id"])){//编辑
            $data = [
                'position' => $params["position"],
                'role_node' => $params["role_node"]
            ];
            return $this->where("seller_id=".$params["seller_id"]." and id = ".$params["position_id"])->update($data);
        }else{//新增 
            $data = [
                'seller_id' => $params["seller_id"],
                'position' => $params["position"],
                'role_node' => $params["role_node"],
                'create_time' =>time()
            ];
            return $this->insert($data);
        }
    }

    /**
     *  判断是否已存在职位 || 查看职位信息
     * @params seller_id 商家id
     * @params position_id 职位id
     */
    public function editPosition(array $params){
        $result = "";
        if(!empty($params["position"])){//验证是否存在该职位名称
            $result = $this->where("seller_id=".$params["seller_id"]." and position like '".$params["position"]."'")->find();
        }
        if(!empty($params["position_id"])){//查看该职位信息
            $result = $this->where("id='".$params["position_id"]."'")->find();
        }
        
        return $result ? $result : [];
    }

    /**
     * 职位列表
     * @param seller_id 商家id
     * */ 
    public function positionList(array $params){
        $result = $this->where("seller_id=".$params["seller_id"]." and position not like '".config('sundrys.shopowner')."'")
                ->field('id,position,create_time,role_node')
                ->select();//查询商家下的职位列表
        return $result ? $result : [];
    }

    /***
     * 新增职位
     * @param $params
     */
    public function addPosition($params)
    {
        $this->save($params);
        return $this->id;
    }
}