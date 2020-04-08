<?php

namespace app\carwash\model;

use think\Model;
use think\Db;

class Territory extends Model
{
    //获取二级城市
    public function secondCity($data){
        return  Db::table('dp_homepage_area')->where('parent_id='.$data["id"]." and is_delete!=1")->select();
    }

    /**
     * 编辑城市
     */
    public function editCity($data){
        // 启动事务
        Db::startTrans();
        try{
            Db::table('dp_homepage_area')->where('id',$data["id"])->update([
                'areaname' => $data["areaname"],
                'area_code' => $data["area_code"]
                ]);
            // 提交事务
            Db::commit();  
            return list($this->status,$this->message) = [1,"编辑成功!"];
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return list($this->status,$this->message) = [0,"编辑失败!"];
        }
    }

    /**
     * 新增城市
     */
    public function addCity($data){
        $isset = Db::table('dp_homepage_area')->where("areaname like '".$data["areaname"]."' and is_delete != 1")->field('id')->find();
        if(!empty($isset)){
            return list($this->status,$this->message) = [0,"列表已存在!"];
        }
        $pinyin = getFirstCharter($data["areaname"]);
        $arr = [
            'area_code'=>$data["area_code"],
            'areaname'=>$data["areaname"],
            'pinyin'=>$pinyin,
            'create_time'=>time(),
            'parent_id'=>$data["parent_id"]
        ];
        // 启动事务
        Db::startTrans();
        try{
            Db::table('dp_homepage_area')->insert($arr);
            // 提交事务
            Db::commit();  
            return list($this->status,$this->message) = [1,"新增成功!"];
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return list($this->status,$this->message) = [0,"新增失败!"];
        }
    }

    /**
     * 删除城市
     */
    public function delcity($data){
        // 启动事务
        Db::startTrans();
        try{
            // 删除
            Db::table('dp_homepage_area')->where('id',$data["id"])->update(['is_delete'=>1]);
            Db::table('dp_homepage_area')->where('parent_id',$data["id"])->update(['is_delete'=>1]);
            // 提交事务
            Db::commit();
            if(!empty($data["parent_id"])){
                return list($this->status,$this->message) = [1,"删除成功!",'Territory/manageCity?id='.$data["parent_id"]];
            }
            return list($this->status,$this->message) = [1,"删除成功!"];
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return list($this->status,$this->message) = [0,"删除失败!"];
        }
    }

    /**
     * 删除客服
     */
    public function delserv($data){
        // 启动事务
        Db::startTrans();
        try{
            // 删除资讯
            Db::table('dp_contactus')->where('id',$data["id"])->update(['is_delete'=>1]);
            // 提交事务
            Db::commit();
            return list($this->status,$this->message) = [1,"删除成功!"];
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return list($this->status,$this->message) = [0,"删除失败!"];
        }
    }

    /**
     * 保存新增/编辑的客服
     */
    public function addEditserv($content){
        if(!empty($content)){
            if(!empty($content["status"])){// 是否发布
                $content["status"] = 1;
            }else{
                $content["status"] = 0;
            }
            $data = [
                'name'  => $content["name"],
                'phone' => $content["phone"],
                'status' => $content["status"]
            ];
            if(!empty($content["id"])){// 保存编辑
                // 启动事务
                Db::startTrans();
                try{
                    Db::table('dp_contactus')->where('id', $content["id"])->update($data);
                    // 提交事务
                    Db::commit();    
                    return list($this->status,$this->message) = [1,"编辑成功!"];
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return list($this->status,$this->message) = [0,"编辑失败!"];
                }
            }else{//新增客服
                $result = Db::name('contactus')->where('is_delete != 1')->find();
                if(!empty($result)){
                    return list($this->status,$this->message) = [0,"只能存在一个客服电话!"];
                }
                // 启动事务
                Db::startTrans();
                try{
                    $data["create_time"] = time();
                    Db::table('dp_contactus')->insert($data);
                    // 提交事务
                    Db::commit();    
                    return list($this->status,$this->message) = [1,"新增成功!"];
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return list($this->status,$this->message) = [0,"新增失败!"];
                }
            }
        }else{
            return list($this->status,$this->message) = [0,"操作失败!"];
        }
    }

    /**
     * 保存新增/编辑的服务协议
     */
    public function operationServ($content){
        if(!empty($content)){
            if(!empty($content["status"])){// 是否启用
                $content["status"] = 1;
            }else{
                $content["status"] = 0;
            }
            $data = [
                'protocol_type'  => $content["protocol_type"],
                'content' => $content["content"],
                'status' => $content["status"]
            ];
            if(!empty($content["id"])){// 保存编辑
                // 启动事务
                Db::startTrans();
                try{
                    $data["update_time"] = time();
                    Db::table('dp_service_protocol')->where('id', $content["id"])->update($data);
                    // 提交事务
                    Db::commit();    
                    return list($this->status,$this->message) = [1,"编辑成功!"];
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return list($this->status,$this->message) = [0,"编辑失败!"];
                }
            }else{//新增资讯
                // 查询是否已有 相同且启用未删除 的服务协议 
                $exist = Db::name('service_protocol')->where('protocol_type='.$content['protocol_type'].' and status=1 and is_delete=0')->field('id')->find();
                if(!empty($exist)){
                    return list($this->status,$this->message) = [0,"已有相同协议!"];
                }
                // 启动事务
                Db::startTrans();
                try{
                    $data["create_time"] = time();
                    Db::table('dp_service_protocol')->insert($data);
                    // 提交事务
                    Db::commit();    
                    return list($this->status,$this->message) = [1,"新增成功!"];
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return list($this->status,$this->message) = [0,"新增失败!"];
                }
            }
        }else{
            return list($this->status,$this->message) = [0,"操作失败!"];
        }
    }

    /**
     * 删除协议
     */
    public function delServe($data){
        // 启动事务
        Db::startTrans();
        try{
            // 删除资讯
            Db::table('dp_service_protocol')->where('id',$data["id"])->update(['is_delete'=>1]);
            // 提交事务
            Db::commit();
            return list($this->status,$this->message) = [1,"删除成功!"];
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return list($this->status,$this->message) = [0,"删除失败!"];
        }
    }


}
