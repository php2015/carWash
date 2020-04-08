<?php
 
namespace app\carwash\model;
 
use think\Model;
use think\Db;
 
class Advert extends Model
{
    /**
     * @var bool 自动写入时间戳
     */
    protected $autoWriteTimestamp = true;
 
    /**
     * 广告分类
     * @param $map 搜索条件
     * id
    */
    public function advType($map){
        return Db::table('dp_homepage_carouselcate')
                ->where($map)
                ->where("is_delete !=1")
                ->paginate();
    }
 
    /**
     * 删除分类
     */
    public function delClass($data){
        $class_id = Db::name('homepage_carouselcate')->where('id',$data["id"])->field('name')->find();
        $exist_homepage = Db::name('homepage_carousel')->where('homepage_carouselcate_id',$data["id"])->field('id')->find(); 
        if(!empty($exist_homepage)){
            return list($this->status,$this->message) = [0,"请先删除分类下的图片!"];
        }
        if(!empty($class_id) && $class_id['name'] == '用户端轮播图'){
            return list($this->status,$this->message) = [0,"该分类不能删除!"];
        }
        // 启动事务
        Db::startTrans();
        try{
            $homepage_carouselcate_id = Db::table('dp_homepage_carousel')->where('homepage_carouselcate_id',$data["id"])->find();
            if(!empty($homepage_carouselcate_id)){
                // 删除广告表该分类下的广告
                Db::table('dp_homepage_carousel')->where('homepage_carouselcate_id',$data["id"])->delete();
            }
            // 删除分类
            Db::table('dp_homepage_carouselcate')->where('id',$data["id"])->delete();
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
        // 启动事务
        Db::startTrans();
        try{
            $name = Db::table('dp_homepage_carouselcate')->where("name like '".$addClass["name"]."'")->find();
            if(!empty($name)){
                return list($this->status,$this->message) = [0,"已有同名广告分类!"];
            }
            $data = ['name' => $addClass["name"], 'order_num' => $addClass["order_num"], 'is_rease' => $addClass["is_rease"], 'create_time' => time()];
            Db::table('dp_homepage_carouselcate')->insert($data);
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
     * 广告列表
     */
    public function advList($map,$order){
        return  Db::table('dp_homepage_carousel')
                    ->alias('h')
                    ->join('dp_homepage_carouselcate hc','h.homepage_carouselcate_id = hc.id')
                    ->where('h.is_delete != 1')
                    ->where($map)
                    ->order($order)
                    ->field('h.*,hc.name')
                    ->paginate()->each(function($item, $key){
                        $item['picture'] = get_file_path($item['picture']);//转换id为图片路径
                        if($item['link_type'] == 0){//当内联时显示内联地址
                            $type = ['shop' => '商家信息', 'serve' => '服务信息', 'join' => '商家入驻', 'card' => '卡包中心'];
                            $item['linkurl'] = '首页 - '.$type[$item['type']].'页';
                        }
                        return $item;
                    });
    }
 
    /**
     * 编辑广告
     * @$data["id"] = 资讯id
     */
    public function editAdvert($data){
        return Db::table('dp_homepage_carousel')->where('id='.$data["id"])->find(); 
    }
 
    /**
     * 新增/保存广告
     * $content array
     */
    public function addAdvert($content){
        if(!empty($content)){
            $linkurl = $content["linkurl"] ? $content["linkurl"] : "";//外联
            $type = $content["type"] ? $content["type"] : "";//内联类型
            $info_id = $content["info_id"] ? $content["info_id"] : "";//内联信息id
            // 链接方式,on为外联,off为内联
            if(!empty($content["link_type"])){//外联
                $content["link_type"] = 1;
                $type = 'web';
            }else{//内联
                $content["link_type"] = 0;
            }
            // 是否发布
            if(!empty($content["is_release"])){
                $content["is_release"] = 1;
            }else{
                $content["is_release"] = 0;
            }

            if(!empty($content["times"])){
                $content["times"] = strtotime($content["times"]);
            }else{
                $content["times"] = 0;
            }
            $data = [
                'location'  => $content["location"],
                'adname' => $content["adname"],
                'homepage_carouselcate_id'  => $content["homepage_carouselcate_id"],
                'picture' => $content["picture"],
                'order_num'  => $content["order_num"],
                'is_release' => $content["is_release"],
                'linkurl' => $linkurl,
                'type' => $type,
                'info_id' => $info_id,
                'link_type' => $content["link_type"],
                'expire_time'   => $content["times"]
            ];
            if(!empty($content["id"])){// 保存编辑
                // 启动事务
                Db::startTrans();
                try{
                    Db::table('dp_homepage_carousel')->where('id', $content["id"])->update($data);
                    // 提交事务
                    Db::commit();    
                    return list($this->status,$this->message) = [1,"编辑成功!"];
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return list($this->status,$this->message) = [0,"编辑失败!"];
                }
            }else{//新增广告
                // 启动事务
                Db::startTrans();
                try{
                    $data["create_time"] = time();
                    Db::table('dp_homepage_carousel')->insert($data);
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
     * 删除广告
     * @$data["id"] = 广告id
     */
    public function delAdvert($data){
        // 启动事务
        Db::startTrans();
        try{
            // 删除广告
            Db::table('dp_homepage_carousel')->where('id',$data["id"])->update(['is_delete'=>1]);
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