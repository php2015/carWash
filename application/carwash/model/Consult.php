<?php
 
namespace app\carwash\model;
 
use think\Model;
use think\Db;
 
class Consult extends Model
{
    /**
     * @var bool 自动写入时间戳
     */
    protected $autoWriteTimestamp = true;
 
    /**
     * 咨询分类
     * @param $map 搜索条件
     * id
    */
    public function consulType($map){
        return Db::table('dp_information_cate')
                ->where($map)
                ->paginate();
    }
 
    /**
     * 新增分类
     * @param $map 搜索条件
     * id
    */
    public function addClass($addClass){
        if(!empty($addClass["is_rease"])){//是否启用
            $addClass["is_rease"] = 1;
        }else{
            $addClass["is_rease"] = 0;
        }
        $name = Db::table('dp_information_cate')->where("name like '".$addClass["name"]."'")->find();
        if(!empty($name)){
            return list($this->status,$this->message) = [0,"已有同名资讯!"];
        }
        // 启动事务
        Db::startTrans();
        try{
            $data = ['name' => $addClass["name"], 'order_num' => $addClass["order_num"], 'is_rease' => $addClass["is_rease"], 'create_time' => time()];
            Db::table('dp_information_cate')->insert($data);
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
     * 删除分类
     */
    public function delClass($data){
        // 启动事务
        Db::startTrans();
        try{
            $information_cate_id = Db::table('dp_information')->where('information_cate_id',$data["id"])->find();
            if(!empty($information_cate_id)){
                return list($this->status,$this->message) = [0,"请先删除分类下的资讯!"];
            }
            // 删除资讯
            Db::table('dp_information_cate')->where('id',$data["id"])->update(['is_delete'=>1]);
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
     * 资讯列表
     */
    public function consulist($map,$order){
        return  Db::table('dp_information')
                    ->alias('i')
                    ->join('dp_information_cate ic','i.information_cate_id = ic.id')
                    ->where('i.is_delete != 1')
                    ->where($map)
                    ->order($order)
                    ->field('i.*,ic.name')
                    ->paginate()->each(function($item, $key){
                        $item['icon'] = get_file_path($item['icon']);//转换id为图片路径
                        return $item;
                    });
    }
 
    /**
     * 删除资讯
     * @$data["id"] = 资讯id
     */
    public function delConsult($data){
        // 启动事务
        Db::startTrans();
        try{
            // 删除资讯
            Db::table('dp_information')->where('id',$data["id"])->update(['is_delete'=>1]);
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
     * 编辑资讯
     * @$data["id"] = 资讯id
     */
    public function editConsult($data){
        return Db::table('dp_information')->alias('i')
                ->join('dp_information_cate ic','i.information_cate_id = ic.id','left')
                ->where('i.id='.$data["id"])
                ->field("i.*,ic.name,ic.id as class_id")
                ->find(); 
    }
 
    /**
     * 新增/保存资讯
     * $content array
     */
    public function addConsult($content){
        if(!empty($content)){
            if(!empty($content["is_release"])){// 是否发布
                $content["is_release"] = 1;
            }else{
                $content["is_release"] = 0;
            }
            $data = [
                'title'  => $content["title"],
                'information_cate_id' => $content["information_cate_id"],
                'source'  => $content["source"],
                'icon' => $content["icon"],
                'detail'  => $content["detail"],
                'order_num' => $content["order_num"],
                'is_release' => $content["is_release"]
            ];
            if(!empty($content["id"])){// 保存编辑
                // 查询是否有相同的资讯名称
                $result = Db::name('information')->where("title like '".$data['title']."'"." and id !=".$content['id'])->field('id')->find();
                if($result){
                    return list($this->status,$this->message) = [0,"已有相同名称!"];
                }
                // 启动事务
                Db::startTrans();
                try{
                    Db::table('dp_information')->where('id', $content["id"])->update($data);
                    // 提交事务
                    Db::commit();    
                    return list($this->status,$this->message) = [1,"编辑成功!"];
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return list($this->status,$this->message) = [0,"编辑失败!"];
                }
            }else{//新增资讯
                // 查询是否有相同的资讯名称
                $result = Db::name('information')->where("title like '".$data['title']."'")->field('id')->find();
                if($result){
                    return list($this->status,$this->message) = [0,"已有相同名称!"];
                }
                // 启动事务
                Db::startTrans();
                try{
                    $data["create_time"] = time();
                    Db::table('dp_information')->insert($data);
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
 
 
}