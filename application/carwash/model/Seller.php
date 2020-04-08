<?php
/**
 * 总平台商家model
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/3
 * Time: 9:51
 */
namespace app\carwash\model;

use think\Db;
use think\Model;

class Seller extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 查找商户名称,店主姓名,
     * 联系电话,员工数量,营业项目,
     * 省份城市,详细地址,收款类别,
     * 收款账户,积分余额, 状态,
     * 业务经理,操作,每页20条
     * @param [搜索条件] $condition
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function queryAll($condition)
    {
//        select GROUP_CONCAT(hc.catename) as homepagecate,s.* from dp_homepage_cate hc,dp_seller s where FIND_IN_SET(hc.id,s.homepage_cate_id) GROUP BY s.id
        //商家表,商家员工表,商家服务表,商家提现账号表,商家收支流水表,区域表
//        return Db::name('seller')->field("a.id,a.sellername,a.shopkeeper,a.contactphone,a.vmphone,a.address,a.is_review,a.is_disabled,a.is_recommend,a.create_time,
//        a.update_time,a.order_num,a.lonlat,concat(TRUNCATE(a.fee * 100, 2),'%') as fee,CONCAT((SELECT FROM_UNIXTIME(a.start_time,'%H:%i')),'-',(SELECT FROM_UNIXTIME(a.end_time,'%H:%i'))) as yyetime,b.areaname,
//        IFNULL(d.nowbalance,0) as nowbalance,count(c.seller_id) as staffnum")
//                ->alias('a')
//                ->join('dp_seller_staff c','a.id = c.seller_id','left')
//                ->join('dp_homepage_area b','a.provinces_id = b.id','left')
//                ->join('dp_seller_cash d','a.id = d.seller_id','left')
//                ->where('b.is_delete = 0')
//                ->where($condition)
//                ->group('a.id')
//                ->paginate(20);
//        $subQuery = Db::name('homepage_cate')->alias('hc')->field('GROUP_CONCAT(hc.catename)')->where('FIND_IN_SET(hc.id,a.homepage_cate_parent_id)')->buildSql();
//        $subQueryTwo = Db::name('seller')->field("a.id,a.homepage_cate_parent_id,a.sellername,a.shopkeeper,a.contactphone,a.vmphone,a.address,a.is_review,a.is_disabled,a.is_recommend,a.create_time,
//        a.update_time,a.order_num,a.lonlat,concat(TRUNCATE(a.fee * 100, 2),'%') as fee,CONCAT((SELECT FROM_UNIXTIME(a.start_time,'%H:%i')),'-',(SELECT FROM_UNIXTIME(a.end_time,'%H:%i'))) as yyetime,b.areaname,
//        IFNULL(d.nowbalance,0) as nowbalance,count(a.id) as staffnum, {$subQuery} as hccatename")
//            ->alias('a')
//            ->join('dp_seller_staff c','a.id = c.seller_id','left')
//            ->join('dp_homepage_area b','a.provinces_id = b.id','left')
//            ->join('dp_seller_cash d','a.id = d.seller_id','left')
//            ->group('id')
//            ->buildSql();
//        return Db::table($subQueryTwo .' m')
//            ->where($condition)
//            ->paginate(20);

        $subQuery = Db::name('homepage_cate')->alias('hc')->field('GROUP_CONCAT(hc.catename)')->where('FIND_IN_SET(hc.id,a.homepage_cate_parent_id)')->buildSql();
        $subQueryTwo = Db::name('seller')->field("a.id,a.homepage_cate_parent_id,a.sellername,a.shopkeeper,a.provinces_id,a.contactphone,a.vmphone,a.address,a.is_review,a.is_disabled,a.is_recommend,a.create_time,
        a.update_time,a.order_num,a.lonlat,concat(TRUNCATE(a.fee * 100, 2),'%') as fee,CONCAT((SELECT FROM_UNIXTIME(a.start_time,'%H:%i')),'-',(SELECT FROM_UNIXTIME(a.end_time,'%H:%i'))) as yyetime,
        count(a.id) as staffnum, {$subQuery} as hccatename")
            ->alias('a')
            ->join('dp_seller_staff c','a.id = c.seller_id','left')
            ->group('id')
            ->buildSql();
        $subQueryFore = Db::name('seller_cash')->field('id,seller_id,nowbalance')->order('id desc')->buildSql();
        $subQueryFive = Db::table($subQueryFore .' sc')->group('sc.seller_id')->buildSql(); //查询取商家提现表最新一条数据
        $subQueryThree = Db::table($subQueryTwo .' n')
            ->field("n.*,b.areaname,IFNULL(d.nowbalance,0) as nowbalance")
            ->join('dp_homepage_area b','n.provinces_id = b.id','left')
            ->join($subQueryFive . ' d','n.id = d.seller_id','left')
            ->group('n.id')
            ->buildSql();
        return Db::table($subQueryThree .' m')
            ->where($condition)
            ->paginate();
    }

    /***
     * 导出商家列表
     * 商户名 店主姓名 联系电话 员工数量 省份 详细地址 地址经纬度 营业时间 账户余额 业务经理 排序值 首页推荐 创建时间 加盟时间 加盟状态 是否下架
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function exportSellerData()
    {

        $subQuery = Db::name('homepage_cate')->alias('hc')->field('GROUP_CONCAT(hc.catename)')->where('FIND_IN_SET(hc.id,a.homepage_cate_parent_id)')->buildSql();
        $subQueryTwo = Db::name('seller')->field("a.id,a.homepage_cate_parent_id,a.sellername,a.shopkeeper,a.provinces_id,a.contactphone,a.vmphone,a.address,a.is_review,a.is_disabled,a.is_recommend,a.create_time,
        a.update_time,a.start_time,a.end_time,a.order_num,a.lonlat,concat(TRUNCATE(a.fee * 100, 2),'%') as fee,CONCAT((SELECT FROM_UNIXTIME(a.start_time,'%H:%i')),'-',(SELECT FROM_UNIXTIME(a.end_time,'%H:%i'))) as yyetime,
        count(a.id) as staffnum, {$subQuery} as hccatename")
            ->alias('a')
            ->join('dp_seller_staff c','a.id = c.seller_id','left')
            ->group('id')
            ->buildSql();
        $subQueryFore = Db::name('seller_cash')->field('id,seller_id,nowbalance')->order('id desc')->buildSql();
        $subQueryFive = Db::table($subQueryFore .' sc')->group('sc.seller_id')->buildSql(); //查询取商家提现表最新一条数据
        return Db::table($subQueryTwo .' a')->field("a.id,a.homepage_cate_parent_id,a.sellername,a.shopkeeper,a.contactphone,a.staffnum,b.areaname,
        a.address,a.lonlat,CONCAT((SELECT FROM_UNIXTIME(a.start_time,'%H:%i')),'-',(SELECT FROM_UNIXTIME(a.end_time,'%H:%i'))) as yyetime,
        IFNULL(d.nowbalance,0) as nowbalance,a.vmphone,a.order_num,
        CASE WHEN a.is_recommend = 0 THEN '不推荐' WHEN a.is_recommend = 1 THEN '推荐' ELSE '未知' END AS is_recommend,
        (SELECT FROM_UNIXTIME(a.create_time,'%Y-%m-%d %H:%i:%S')) as create_time,
        (SELECT FROM_UNIXTIME(a.update_time,'%Y-%m-%d %H:%i:%S')) as update_time,
        CASE WHEN a.is_review = 0 THEN '待处理' WHEN a.is_review = 1 THEN '已加盟' ELSE '未知' END AS is_review,
        CASE WHEN a.is_disabled = 0 THEN '不下架' WHEN a.is_disabled = 1 THEN '下架' ELSE '未知' END AS is_disabled,
        a.hccatename")
            ->join('dp_homepage_area b','a.provinces_id = b.id','left')
            ->join($subQueryFive .' d','a.id = d.seller_id','left')
            ->group('a.id')
            ->select();
    }

    /***
     * 获取省份城市
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getProvinces()
    {
        return Db::name('homepage_area')
            ->where('is_release = 1 and is_delete = 0 and parent_id = 0')
            ->select();
    }
    
    /***
     * 获取营业项目
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getHomePageCate()
    {
        return Db::name('homepage_cate')
            ->where('is_enable = 1 and is_delete = 0 and parent_id =  0')
            ->select();
    }
    /***
     * 新增商家
     * @param array $data
     */
    public function add(array $data)
    {
        $this->save($data);
        return $this->id;//返回自增id
    }

    /***
     * 新增时添加职位
     * @param array $addPosition
     * @return string
     */
    public function addPosition(array $addPosition)
    {
        Db::name('seller_position')->insert($addPosition);
        return $positionId = Db::name('seller_position')->getLastInsID();
    }

    /***
     * 查询店主电话号码是否唯一,弃用
     * @param $phone
     * @return int|string
     */
    public function queryStaffPhone($phone)
    {
        return Db::name('seller_staff')->where('mobile',$phone)->count('id');
    }
    /***
     * 新增时添加员工
     * @param array $addStaff
     * @return string
     */
    public function addStaff(array $addStaff)
    {
        Db::name('seller_staff')->insert($addStaff);
        return $staffId = Db::name('seller_staff')->getLastInsID();
    }

    /***
     * 查询店长职位id
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryPositionId($id)
    {
        //return Db::name('seller_position')->where('seller_id',$id)->find();
        $where['ss.seller_id'] = $id;
        $where['ss.is_shopkeeper'] = 1;
        return Db::name('seller_staff')
            ->field('sp.id')
            ->alias('ss')
            ->join('dp_seller_position sp','ss.seller_id = sp.seller_id','left')
            ->where($where)
            ->find();
    }

    /***
     * 更新店主密码
     * @param $sellerId
     * @param $positionId
     * @param $pwd
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function editShopownerPwd($sellerId,$positionId,$pwd)
    {
        return Db::name('seller_staff')->where('seller_id = '.$sellerId.' and seller_position_id = '.$positionId)->update(['password'=>$pwd,'update_time'=>time()]);
    }

    /***
     * 查询店主id
     * @param $mobile
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function querySellerStaffId($mobile)
    {
        return Db::name('seller_staff')->where('mobile ='.$mobile)->find();
    }
    /***
     * 查询电话号码在商家员工表是否唯一
     * @param $mobile
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function querySellerStaffMobile($mobile)
    {
        return Db::name('seller_staff')->where('mobile = '.$mobile)->find();
    }
    /***
     * 更新店主登录账号
     * @param $sellerId
     * @param $mobile
     * @param $newMobile
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function editShopownerInfo($id,$newMobile,$newName)
    {
        return Db::name('seller_staff')->where('id = ' . $id)->update(['mobile'=>$newMobile,'staffname'=>$newName,'update_time'=>time()]);
    }
    /***
     * 更新商家信息
     * @param $updateSellerId
     * @param $updateSeller
     * @return Seller
     */
    public function updateSeller($updateSellerId,$updateSeller)
    {
        return $this->where('id',$updateSellerId)->update($updateSeller);
    }
    /***
     * 查询指定商家信息
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function editSeller($id)
    {
        return $this->where('id',$id)->find();
    }

    /***
     * 查看商家收款账号
     * @param $seller_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function payType($seller_id)
    {
        return Db::name('cash_account')->where('seller_id',$seller_id)->select();
    }

    /***
     * 查看营业项目
     * @param $seller_id
     * @return mixed
     */
    public function showService($seller_id)
    {
        return Db::query("select s.id,hc.catename from dp_seller s,dp_homepage_cate hc where FIND_IN_SET(hc.id,s.homepage_cate_parent_id) and s.id  = ".$seller_id);
    }

    /***
     * 查看商家订单
     * @param $id
     * @param $orderRecordSearch
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function orderRecord($id,$orderRecordSearch)
    {
        return  Db::name('user_order')->field("a.id,a.user_id,a.seller_id,a.seller_service_id,
        a.seller_staff_id,a.payprice,a.create_time,IF(a.pay_status = 2,'',a.order_number) as order_number,a.settlement_type,a.pay_status,
        b.nickname,b.mobile,c.servicename,c.serviceprice,c.homepage_cate_id,d.staffname,e.catename")
            ->alias('a')
            ->join('dp_user b','a.user_id = b.id')
            ->join('dp_seller_service c','a.seller_service_id = c.id')
            ->join('dp_seller_staff d','a.seller_staff_id = d.id')
            ->join('dp_homepage_cate e','c.homepage_cate_id = e.id') //所属二级分类
            ->where('a.seller_id',$id)
            ->where($orderRecordSearch)
            ->order('a.id  asc')
            ->paginate();
    }

    /***
     * 查看商家服务
     * is_delete 为0的所有商家服务
     * @param $seller_id
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function showSellerService($seller_id,$condition)
    {
        $subQuery = Db::name('seller_service')
            ->field('a.id,a.servicename,a.create_time,a.update_time,a.is_release,a.serviceprice,a.is_timescard,a.is_delete,b.catename')
            ->alias('a')
            ->join('dp_homepage_cate b','a.homepage_cate_parent_id = b.id','left')
            ->where('a.seller_id',$seller_id)
            ->buildSql();
        return Db::table($subQuery.' dp_seller_service')
                ->field('dp_seller_service.*,n.settlement_type,count(n.id) as servicetimes')
                ->join('dp_user_order n','dp_seller_service.id = n.seller_service_id and n.pay_status = 1 and n.is_valid = 0','left')
                ->group('n.seller_service_id,n.settlement_type')
                ->where('dp_seller_service.is_delete',0)
                ->where($condition)
                ->order('dp_seller_service.create_time desc')
                ->paginate();
    }

    /***
     * 删除商家服务
     * @param $id
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delSellerService($id)
    {
        return Db::name('seller_service')->where('id',$id)->update(['is_delete'=>1]);
    }
    /***
     * 编辑商家服务
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function editSellerService($id)
    {
        return Db::name('seller_service')->field('a.id,a.servicename,a.serviceprice,a.is_startrights,a.is_timescard,a.is_release,b.catename')
            ->alias('a')
            ->join('dp_homepage_cate b','a.homepage_cate_parent_id = b.id')
            ->where('a.id',$id)
            ->find();
    }

    /***
     * 更新商家服务
     * @param $service_id
     * @param $updateSellerServiceData
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function updateSellerService($service_id,$updateSellerServiceData)
    {
        return Db::name('seller_service')->where('id',$service_id)->update($updateSellerServiceData);
    }

    /***
     * 查询所有的商家
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function catAllSeller()
    {
        return $this->field('id,sellername')->where('is_review = 1 and is_disabled = 0')->select();
    }

    /***
     * 获取银行列表
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function bankOfDeposit()
    {
        return Db::name('bank_card')->field('id,name')->where('status = 1 and is_delete = 0')->select();
    }

    /***
     * 查询商家是否已有启用状态的账号存在
     * @param $seller_id
     * @param $account_type
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryCashAccountIsExist($seller_id,$account_type)
    {
        return Db::name('cash_account')->where('account_type = '.$account_type.' and seller_id ='.$seller_id.' and is_delete = 0')->select();
    }

    /***
     * 提现账号列表
     * @param $Search
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function CashAccountList($Search)
    {
        return Db::name('cash_account')
            ->field('ca.id,ca.idcard,ca.account_name,ca.account_type,ca.mobile,ca.account,ca.bank_card_id,ca.status,ca.is_delete,bc.name,s.sellername,s.shopkeeper,s.contactphone')
            ->alias('ca')
            ->join('dp_bank_card bc','ca.bank_card_id = bc.id','left')
            ->join('dp_seller s','ca.seller_id = s.id','left')
            ->where('ca.is_delete = 0')
            ->where($Search)
            ->order('ca.create_time desc')
            ->paginate();

    }
    /***
     * 添加提现账户
     * @param $addBankData
     * @return string
     */
    public function addCashAccount($addBankData)
    {
        Db::name('cash_account')->insert($addBankData);
        return $userId = Db::name('cash_account')->getLastInsID();
    }

    /***
     * 删除提现账号
     * @param $id
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delCashAccount($id)
    {
        return Db::name('cash_account')->where('id',$id)->update(['is_delete'=>1]);
    }

    /***
     * 批量更新
     * @param $id
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delSelectCashAccount($strId)
    {
        return Db::name('cash_account')->where('id','in',$strId)->update(['is_delete'=>1]);
    }

    /***
     * 获取编辑的提现账号信息
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function editCashAccount($id)
    {
        return Db::name('cash_account')
            ->field("id,account_type,seller_id,bank_card_id,idcard,account_name,status,
            IF(account_type = 1,account,account) as account_1,
            IF(account_type = 1,mobile,mobile) as alipay_mobile,
            IF(account_type = 2,account,account) as account_2,
            IF(account_type = 2,mobile,mobile) as wechat_mobile,
            IF(account_type = 3,account,account) as account_3
            ")
            ->where('id',$id)
            ->find();
    }

    /***
     * 更新
     * @param $updateId
     * @param $addBankData
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function updateCashAccount($updateId,$addBankData)
    {
        return Db::name('cash_account')->where('id',$updateId)->update($addBankData);
    }
}