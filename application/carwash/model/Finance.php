<?php

namespace app\carwash\model;
use think\Model;
use think\Db;

class Finance extends Model
{
    /**
     * 手续费比例显示
    */
    public function procedureRatio(){
        return Db::table('dp_cash_scale')->order('id desc')->find();
    }

    /**
     * 新增手续费比例
     * */ 
    public function addRatio($data = ''){
        $result["create_time"] = time();
        $result['fee'] = $data['fee'] ? $data['fee'] : config('app.commission_rate');
        // 启动事务
        Db::startTrans();
        try{
            if(!empty($data['id'])){
                Db::table('dp_cash_scale')->where('id',$data['id'])->update($result); 
            }
            // 提交事务
            Db::commit();    
            return list($this->status,$this->message) = [1,"操作成功!"];
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return list($this->status,$this->message) = [1,"操作成功!"];
        }
    }

    /**
     * 银行卡列表
     */
    public function bankCardList(){
        return Db::table('dp_bank_card')->where("is_delete != 1")->paginate()->each(function($item, $key){
            $item['img'] = get_file_path($item['img']);//转换id为图片路径
            return $item;
        }); 
    }

    /**
     * 删除银行卡
     * @$data["id"] = 卡id
     */
    public function delCard($data){
        // 删除时判断是否有商家
        $result = Db::name('cash_account')->where('bank_card_id='.$data['id'].' and is_delete=0')->find();
        if($result){
            return list($this->status,$this->message) = [0,"请先修改正在使用该银行的商家!"];
        }
        // 启动事务
        Db::startTrans();
        try{
            // 删除银行
            Db::table('dp_bank_card')->where('id',$data["id"])->update(['is_delete'=>1]);
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
     * 编辑银行
     * @$data["id"] = 银行id
     */
    public function editCard($data){
        return Db::table('dp_bank_card')->where('id',$data["id"])->find();
    }

    /**
     * 新增/保存银行
     * $content array
     */
    public function addCard($content){
        if(!empty($content)){
            if(!empty($content["status"])){// 是否启用
                $content["status"] = 1;
            }else{
                $content["status"] = 0;
            }
            $content["update_time"] = time();
            if(!empty($content["id"])){// 保存编辑
                // 启动事务
                Db::startTrans();
                try{
                    Db::table('dp_bank_card')->where('id', $content["id"])->update($content);
                    // 提交事务
                    Db::commit();    
                    return list($this->status,$this->message) = [1,"编辑成功!"];
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return list($this->status,$this->message) = [0,"编辑失败!"];
                }
            }else{//新增银行
                $content["create_time"] = time();
                // 启动事务
                Db::startTrans();
                try{
                    Db::table('dp_bank_card')->insert($content);
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
     * 提现记录列表
     * $map 搜索参数 
     */
    public function finanList($map){
        return Db::table('dp_seller_cash')->alias('sc')
                ->join('dp_seller s','s.id = sc.seller_id','left')
                ->join('dp_cash_account ca','sc.cash_account_id = ca.id','left')
                ->join('dp_seller_reject sr','sc.id = sr.relevant_id','left')
                ->where($map)
                ->field("sc.*,s.sellername,s.shopkeeper,s.contactphone,ca.account_type,ca.account,ca.account_name,ca.bank_card_id,sr.reject_reason,ca.create_time")
                ->order("sc.cash_status asc")
                ->paginate()->each(function($item, $key){
                    // 一.对 未结算的订单 算手续费和应打款金额
                    if($item["cash_status"] == 1){
                        // 1.查询 商家表 中该商家是否有额外的比例配置
                        $ratio = Db::table('dp_seller')->where('id',$item["seller_id"])->field("fee")->find();
                        if(!empty((float)$ratio["fee"])){
                            // 按照单独配置的商家比例算 , 商家的比例已经是小数点了
                            $item["cash_fee"] = ((float)$item["cash_price"] * (float)$ratio["fee"]);
                        }else{
                            // 按照后台配置的比例算
                            $scale = Db::table('dp_cash_scale')->field("fee")->find();
                            $item["cash_fee"] = ((float)$item["cash_price"] * (float)$scale["fee"] * 0.01);
                        } 
                        $item["cash_fee"] = round($item["cash_fee"], 2);
                        $item["fact_cash_price"] = $item["cash_price"] - $item["cash_fee"];
                    }
                    // 二.对 已打款成功的订单不再显示之前的驳回原因
                    if($item["cash_status"] == 3){
                        $item["reject_reason"] = "";
                    }
                    // 三.如果 账号类型 是银行卡,通过bank_card_id 更新 开户行
                    if($item['account_type'] == 3){
                        $bank = Db::name('bank_card')->where('id',$item['bank_card_id'])->field('name')->find();
                        $item['bank'] = $bank['name'];
                    }
                    return $item;
                }); 
    }

    /**
     * 导出数据
     */
    public function finanExcel(){
        $lists =  Db::table('dp_seller_cash')
                    ->alias('sc')
                    ->join('dp_seller s','s.id = sc.seller_id','left')
                    ->join('dp_cash_account ca','sc.cash_account_id = ca.id','left')
                    ->join('dp_seller_reject sr','sc.id = sr.relevant_id','left')
                    ->field("sc.*,s.sellername,s.shopkeeper,s.contactphone,ca.account_type,ca.account,ca.account_name,ca.bank,sr.reject_reason,ca.create_time")
                    ->order("sc.cash_status asc")
                    ->select();
        foreach($lists as &$list){
            // 提现方式
            switch ($list["account_type"])
            {
            case 1:
                $list["account_type"] = "支付宝";
            break;  
            case 2:
                $list["account_type"] = "微信";
            break;
            case 3:
                $list["account_type"] = "银行卡";
            break;
            default:
            }
            // 提现状态
            switch ($list["cash_status"])
            {
            case 1:
                $list["cash_status"] = "未处理";
            break;  
            case 2:
                $list["cash_status"] = "已驳回";
            break;
            case 3:
                $list["cash_status"] = "已打款";
            break;
            default:
            }
            $list["create_time"] = date("Y-m-d H:i:s",$list["create_time"]);
            if(!empty($list["make_time"])){
                $list["make_time"] = date("Y-m-d H:i:s",$list["make_time"]);
            }
            // 对 未结算的订单 算手续费和应打款金额
            if($list["cash_status"] == 1){
                // 1.查询 商家表 中该商家是否有额外的比例配置
                $ratio = Db::table('dp_seller')->where('id',$list["seller_id"])->field("fee")->find();
                if(!empty((float)$ratio["fee"])){
                    // 按照单独配置的商家比例算 , 商家的比例已经是小数点了
                    $list["cash_fee"] = ((float)$list["cash_price"] * (float)$ratio["fee"]);
                }else{
                    // 按照后台配置的比例算
                    $scale = Db::table('dp_cash_scale')->field("fee")->find();
                    $list["cash_fee"] = ((float)$list["cash_price"] * (float)$scale["fee"] * 0.01);
                } 
                $list["fact_cash_price"] = $list["cash_price"] - $list["cash_fee"];
            }
        }
        return $lists;
    }

    /**
     * 驳回原因
     */
    public function reject($data){
        $times = time();
        if(!empty($data)){
            if($data["cash_status"]==2){
                return list($this->status,$this->message) = [0,"该订单已驳回!"];
            }
            // 驳回表数据
            $dp_seller_reject = [
                'seller_id' => $data["seller_id"], 'relevant_id' => $data["id"],
                'reject_reason' => $data["reject_reason"], 'remake' => '',
                'reject_type' => 1,'create_time' => $times
            ];
            // 提现表数据
            $dp_seller_cash = [
                'cash_status' => 2,'cash_fee' => $data["cash_fee"],
                'fact_cash_price' => $data["fact_cash_price"],'cash_time'=>$times
            ];
            // 商家流水/商家收支记录表的数据
            $dp_seller_balance =[
                'seller_id' => $data["seller_id"], 'price' =>  $data["cash_price"],
                'is_balance' => 1, 'create_time' =>  $times, 'cash_account_id' => $data["id"]
            ];
            // 消息中心
            $msg = [
                'title' => '提现驳回',
                'content' => '尊敬的店主,您于'.date("Y-m-d H:i:s",$times).'发起的提现被驳回,驳回原因为:'.$data["reject_reason"],
                'create_time' => $times, 'seller_id' => $data["seller_id"],'type' => 12
            ];
            // 启动事务
            Db::startTrans();
            try{
                // 1. 写入 商家驳回原因表
                Db::table('dp_seller_reject')->insert($dp_seller_reject);
                // 2. 修改 商家提现表状态和写入提现金额,手续费,驳回时间
                Db::table('dp_seller_cash')->where("id=".$data["id"])->update($dp_seller_cash);
                // 3.商家收支记录 打入 进账的 驳回的金额,驳回时间
                Db::table('dp_seller_balance')->insert($dp_seller_balance);
                // 4.提现驳回写入到 消息中心
                Db::name('seller_message')->insert($msg);
                // 提交事务
                Db::commit();    
                return list($this->status,$this->message) = [1,"驳回成功!"];
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return list($this->status,$this->message) = [0,"驳回失败!"];
            }
        }else{
            return list($this->status,$this->message) = [0,"驳回失败!"];
        }
    }

    /**
     * 打款
     */
    public function remit($data){
        $times = time();
        if(!empty($data)){
            // 商家流水/商家收支记录表的数据
            $dp_seller_balance =[
                'seller_id' => $data["seller_id"], 'price' =>  $data["cash_price"],
                'is_balance' => 2, 'create_time' =>  $times, 'cash_account_id' => $data["id"]
            ];
            // 提现表数据
            $dp_seller_cash = [
                'cash_status' => 3,'cash_fee' => $data["cash_fee"],
                'fact_cash_price' => $data["fact_cash_price"],'make_time'=>$times
            ];
            // 消息中心
            $msg = [
                'title' => '提现到账',
                'content' => '尊敬的店主,您于'.date("Y-m-d H:i:s",$times).'发起的提现已打款,请知晓~',
                'create_time' => $times, 'seller_id' => $data["seller_id"],'type' => 11
            ];
            // 启动事务
            Db::startTrans();
            try{
                // 1.判断该提现状态之前是否为已驳回,若为则 商家收支流水表需要写入 商家id,出账金额,类型:出账,出账时间,提现id.
                // (备注:若不为已驳回,则不做变动,因为在商家端申请提现时接口已经扣除了金额,当驳回时会返还扣除的金额)
                if($data["cash_status"]==2){
                    Db::table('dp_seller_balance')->insert($dp_seller_balance);
                }
                // 2.提现表更新 手续费,应打款金额,修改处理状态,添加打款时间
                Db::table('dp_seller_cash')->where("id=".$data["id"])->update($dp_seller_cash);
                // 3.提现打款写入到 消息中心
                Db::name('seller_message')->insert($msg);
                // 提交事务
                Db::commit();   
                return list($this->status,$this->message) = [1,"打款确认成功!"]; 
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return list($this->status,$this->message) = [0,"网络不稳定! 打款确认失败!"];
            }
        }else{
            return list($this->status,$this->message) = [0,"打款确认失败!"];
        }
        
    }
}
