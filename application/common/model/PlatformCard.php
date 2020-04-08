<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/27
 * Time: 11:42
 */

namespace app\common\model;


use think\Model;

/***
 * 用户卡表模型
 * Class PlatformCard
 * @package app\common\model
 * @property integer id            平台卡id
 * @property string  cardname      卡名
 * @property string  total_value   总权益值|总次数
 * @property integer card_type     卡类型[1权益卡|次数卡]
 * @property integer period        使用周期
 * @property integer monthly_times 单月可消费次数
 * @property string  cash_pay_value 现金价值
 * @property integer sale_status    销售状态[0禁用|1启用]
 * @property integer create_time   发布时间
 */
class PlatformCard extends Model
{
    /***
     * 卡种类别列表
     * @param $card_type   [卡类型][1权益卡|2次数卡]
     * @param $sale_status [销售状态][0禁用|2启用]
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cardCategories($params)
    {
        $where['card_type'] = $params['card_type'];
        $where['sale_status'] = 1;
        $paginate = $params['paginate'];
        return $this->where($where)->page($paginate,10)->select();
    }

    /***
     * 获取指定卡的卡详情
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCardDetail($params)
    {
        $where['id'] = $params['card_id'];
        $field = "id,card_type,cardname,cash_pay_value,period,total_value,monthly_times,IF(card_type=1,'全部服务','部分服务') as service";
        return $this->field($field)->where($where)->find();
    }

    /***
     * 查询卡详情
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCardInfo($params)
    {
        $where['id'] = $params['card_id'];
        return $this->where($where)->find();
    }
}