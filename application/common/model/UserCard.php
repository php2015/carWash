<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * User: chenxin
 * Date: 2018/9/19
 * Time: 20:48
 */
namespace app\common\model;

use think\Db;
use think\Model;

/***
 * 用户卡模型
 * Class UserCard
 * @package app\common\model
 * @property integer id               用户卡表id
 * @property string  card_number      卡号
 * @property integer user_id          用户id
 * @property integer platform_card_id 平台卡id
 * @property string  balance_value    用户卡余额|剩余次数
 * @property string  create_time      生效时间
 * @property integer expire_time      过期时间
 * @property integer status           消费状态[0正常|1消费完毕|2已过期]
 */
class UserCard extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 用户卡列表|cx
     * @param [user_id] 用户id
     * @param [card_type] 卡类型 ||1.权益 2.次数
     * @param [status] 卡状态 ||0.可使用 2.已失效
     * @param [page] 分页
     * @param $params
     * @return array|\think\Collection|\think\model\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cardList($params)
    {
        $map['user_id'] = $params['user_id'];
        $params['page'] = $params['page'] ? $params['page'] : 1;
        $map['pc.card_type'] = $params['card_type'];
        if($params['status'] > 0){
            $map['uc.status']  = ['>',0];
        }else{
            $map['uc.status'] = 0;
        }
        //卡id,卡类型(1权益2次数),使用期限,周期内消费次数(次卡才有),现金价值,卡总权益值/总次数,卡号,卡名称,卡状态
        $field = 'uc.id,pc.card_type,pc.period,pc.monthly_times,pc.cash_pay_value,pc.total_value,uc.card_number,pc.cardname,uc.status';
        $result = $this->alias('uc')
            ->join('dp_platform_card pc','uc.platform_card_id = pc.id')
            ->where($map)
            ->field($field)
            ->page($params['page'],10)
            ->order('uc.create_time desc')
            ->select();
        return $result ? $result : [];
    }

    /***
     * 用户权益卡总余额
     * @param [user_id] 用户id
     * @param $user_id
     * @return float|int
     */
    public function cardBalance($user_id)
    {
        $map['pc.card_type'] = 1;//权益卡
        $map['uc.status'] = 0;//正常使用
        $map['uc.user_id'] = $user_id;//用户id
        $result = $this->alias('uc')
            ->join('dp_platform_card pc','uc.platform_card_id = pc.id')
            ->where($map)
            ->sum('uc.balance_value');
        return $result ? $result : 0;
    }

    /***
     * 用户卡详情 cx
     * @param [card_id] 用户卡id
     * @param int $card_id
     * @return array|\think\Collection|\think\model\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cardInfo($card_id = 0)
    {
        $map['uc.id'] = $card_id;
        //卡id,卡类型(1权益2次数),使用期限,周期内消费次数(次卡才有),现金价值,卡总权益值/总次数,卡号,卡名称,当月剩余次数(用户卡才有),卡状态,卡购买时间,剩余余额/次数
        $field = 'uc.id,pc.card_type,uc.expire_time as period,pc.monthly_times,pc.cash_pay_value,
        pc.total_value,uc.card_number,pc.cardname,uc.month_balance_times,uc.status,
        uc.create_time,uc.balance_value';
        $result = $this->alias('uc')
            ->join('dp_platform_card pc','uc.platform_card_id = pc.id')
            ->where($map)
            ->field($field)
            ->find();
        return $result ? $result : [];
    }

    /***
     * 权益卡帮助协议 cx
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function helpProtocol()
    {
        $map['protocol_type'] = 3;
        $map['status'] = 1;//启用
        $map['is_delete'] = 0;//未删除
        $result = Db::name('service_protocol')
            ->where($map)
            ->field('content')
            ->find();
        return $result ? $result['content'] : [];
    }

    /***
     * ywdeng
     */
    /***
     * 获取当前用户所有可使用的权益卡 card_type =1
     * @param $userId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function canUseQyCard($userId)
    {
        $where['uc.user_id'] = $userId;
        $where['uc.status'] = 0;
        $where['uc.expire_time']  = ['>','unix_timestamp(now())'];
        $where['pc.card_type'] = 1;
        return $this
            ->field('uc.*')
            ->alias('uc')
            ->join('dp_platform_card pc','uc.platform_card_id = pc.id','left')
            ->where($where)
            ->order('uc.balance_value asc')
            ->select();
    }
    /***
     * 获取用户当前卡信息
     * @param $userId
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserCardInfo($userId)
    {

        $where['status'] = 0;
        $where['user_id'] = $userId;
        return $this->where($where)->find();
    }

    /***
     * 权益卡结算,获取卡名
     * @param $strId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryCardInfo($strId)
    {
        return $this
            ->field('uc.id,pc.cardname')
            ->alias('uc')
            ->join('dp_platform_card pc','uc.platform_card_id = pc.id','left')
            ->where('uc.id','in',$strId)
            ->where('pc.card_type',1)//权益卡
            ->select();
    }

    /***
     * 查询次数卡卡名
     * @param $userCardId
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryCardDetail($userCardId)
    {
        $where['uc.id'] = $userCardId;
        $where['pc.card_type'] =2;//次数卡
        return $this
            ->field('pc.cardname')
            ->alias('uc')
            ->join('dp_platform_card pc','uc.platform_card_id = pc.id','left')
            ->where($where)
            ->find();
    }
    /***
     * 获取平台次卡总使用次数和单月可使用次数
     * @param $cardId
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function totalPlatformCardCiShu($cardId)
    {
        $where['uc.id'] = $cardId; //用户卡id
        $where['pc.card_type'] = 2;//次卡
        $field = 'uc.id,uc.platform_card_id,pc.total_value,pc.monthly_times';
        return $this
            ->field($field)
            ->alias('uc')
            ->join('dp_platform_card pc','uc.platform_card_id = pc.id')
            ->where($where)
            ->find();
    }

    /***
     * 更新用户权益卡数值和状态
     * @param $params
     * @return array|false
     * @throws \Exception
     */
    public function deductUserIntegral($params)
    {
        return $this->saveAll($params);
    }

    /***
     * 更新用户次数卡使用次数
     * @param $userTimesCardId
     * @param $deductUserTimes
     * @return UserCard
     */
    public function deductUserTimes($userTimesCardId,$deductUserTimes)
    {
        $where['id'] = $userTimesCardId;
        return $this->where($where)->update($deductUserTimes);
    }

    /***
     * 新增用户卡
     * @param $params
     * @return mixed
     */
    public function addUserCard($params)
    {
        $this->save($params);
        return $this->id;
    }

    /***
     * 查询用户是否有可使用的卡,和下面的SQL一致,独立出来,便于后面修改以不影响其他地方使用
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isOwnCard($params,$cardType)
    {
        $where['uc.status'] = 0;
        $where['uc.user_id'] = $params['user_id'];
        $where['pc.card_type'] = $cardType;//1权益卡,次数卡
        $where['uc.expire_time']  = ['>','unix_timestamp(now())'];
        $field = "uc.id,uc.balance_value,pc.monthly_times,pc.card_type,pc.cardname";
        $subQuery = Db::table('dp_user_card')
            ->field($field)
            ->alias('uc')
            ->join('dp_platform_card pc','uc.platform_card_id = pc.id','left')
            ->where($where)
            ->buildSql();
        $time = 'create_time >='.strtotime(date('Y-m-01')).' and create_time <='.strtotime(date('Y-m-t 23:59:59'));
        $whereSon['user_id'] = $params['user_id'];
        $subQuerySon = Db::table('dp_user_card_statement')->where($whereSon)->where($time)->buildSql();
        $fieldSon = "mt.*,count(ucs.user_card_id) as useInMonth";
        return Db::table($subQuery . ' mt')
            ->field($fieldSon)
            ->join($subQuerySon . ' ucs','mt.id = ucs.user_card_id','left')
            ->group('mt.id')
            ->select();
    }

    /***
     * 此SQL已修改
     * 查询用户卡表,平台卡表,用户卡消费记录表,统计用户所有次卡当前月消费次数
     * 如果当前月剩余次数为零,则不予显示在付款列表,如果次卡总剩余次数为0,则不予显示在付款列表
     * 用户扫码获取当前用户所有的次数卡,列表显示用户当前拥有总次数大于0/当月剩余次数大于0的次数卡
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSettlementCard($params)
    {
        $where['uc.status'] = 0;
        $where['uc.user_id'] = $params['user_id'];
        $where['pc.card_type'] = 2;//1权益卡,次数卡
        $where['uc.expire_time']  = ['>','unix_timestamp(now())'];
        $field = "uc.id,uc.balance_value,pc.monthly_times,pc.card_type,pc.cardname";
        $subQuery = Db::table('dp_user_card')
                    ->field($field)
                    ->alias('uc')
                    ->join('dp_platform_card pc','uc.platform_card_id = pc.id','left')
                    ->where($where)
                    ->buildSql();
        $time = 'create_time >='.strtotime(date('Y-m-01')).' and create_time <='.strtotime(date('Y-m-t 23:59:59'));
        $whereSon['user_id'] = $params['user_id'];
        $subQuerySon = Db::table('dp_user_card_statement')->where($whereSon)->where($time)->buildSql();
        $fieldSon = "mt.*,count(ucs.user_card_id) as useInMonth";
        return Db::table($subQuery . ' mt')
            ->field($fieldSon)
            ->join($subQuerySon . ' ucs','mt.id = ucs.user_card_id','left')
            ->group('mt.id')
            ->select();
    }

}