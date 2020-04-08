<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/6
 * Time: 18:04
 */


namespace app\carwash\admin;

use think\Db;
use think\Request;
use think\Controller;
use app\carwash\admin\Seller;  //获取首页服务分类
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\exception\DbException;

class PlatformCard extends Admin
{
    private $tableName = 'dp_platform_card';

    /***
     * 在售卡种 状态为启用的卡
     */
    public function onSaleCard()
    {
        $condition = $this->getMap();
        $onSaleCardData = model('PlatformCard')->onSaleCard($condition);
        $cardType = [1=>'权益卡',2=>'次数卡'];//所属卡种
        return ZBuilder::make('table')
            ->setTableName('platform_card')
            ->setPageTitle('在售卡种')
            ->setSearch(['cardname' => '卡种名称'])
            ->setPrimaryKey('id')
            ->hideCheckbox()
            ->addColumns([
                ['__INDEX__', 'ID'],
                ['cardname', '卡种名称'],
                ['card_type', '卡种类别', 'status', '',[1=>'权益卡', 2=>'次数卡']],
                ['cash_pay_value','卡种价格'],
                ['total_value', '卡种详情'],
                ['period', '使用期限'],
                ['create_time', '新增时间','datetime'],
                ['monthly_times', '单月可使用次数'],
                ['sale_status', '状态','status',[0=>'禁用',1=>'启用']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add')
            ->addRightButton('buyHistory', [
                'title' => '购买记录',
                'icon'  => 'fa fa-fw fa-credit-card-alt',
                'href'  => url('buyHistory', ['id' => '__id__'])
            ])
            ->addRightButton('catCardInfo', [
                'title' => '查看卡信息',
                'icon'  => 'fa fa-fw fa-eye',
                'href'  => url('catCardInfo', ['id' => '__id__'])
            ])
            ->addTopSelect('card_type', '卡种类别', $cardType)
            ->setRowList($onSaleCardData)
            ->assign('empty_tips', '没有任何数据')
            ->fetch(); // 渲染页面
    }

    /***
     * 新增卡种
     * @return mixed
     * @throws \think\Exception
     */
    public function add()
    {
        if(request()->isPost()){
            $addPlatformCard = request()->post('', null, 'trim');
            //新增逻辑
            if($addPlatformCard['card_type'] == 1){ //权益卡
                if(!isset($addPlatformCard['total_rights'])) exception('请输入权益值数量');
                $addPlatformCard['total_value'] = $addPlatformCard['total_rights'];
                unset($addPlatformCard['total_rights']);
            }
            if($addPlatformCard['card_type'] == 2){ //次数卡
                if(!isset($addPlatformCard['total_times'])) exception('请输入次数卡数量');
                if(!isset($addPlatformCard['monthly_times'])) exception('请输入次数卡单月可使用次数');
                if($addPlatformCard['monthly_times'] > $addPlatformCard['total_times']) exception('单月使用次数不可大于总次数');
                $addPlatformCard['total_value'] = $addPlatformCard['total_times'];
                unset($addPlatformCard['total_times']);
            }
            $validateAddCard = validate('PlatformCard');
            $validateCard = $validateAddCard->check($addPlatformCard);
            if(!$validateCard){
                return exception($validateAddCard->getError());
            }
            try{
                $PlatformCardId = model('PlatformCard')->addPlatformCard($addPlatformCard);
            }catch(\Exception $e){
                $this->error($addPlatformCard['cardname'].'添加失败');
            }
            if($PlatformCardId){
                action_log($this->tableName . '_add', $this->tableName, $PlatformCardId, UID, $addPlatformCard['cardname']);
                if($addPlatformCard['card_type'] == 1){
                    $this->success('权益卡'.$addPlatformCard['cardname'].'添加成功','PlatformCard/onSaleCard');
                } else {
                    $this->success('次数卡'.$addPlatformCard['cardname'].'添加成功','PlatformCard/onSaleCard');
                }
            } else {
                $this->error('添加失败');
            }
        }
        return ZBuilder::make('form')
            ->setPageTitle('新增卡种')
            ->addSelect('card_type', '卡种类别', '', [1 => '权益卡', 2 => '次数卡'])
            ->addText('cardname', '请填写卡种名称')
            ->addText('cash_pay_value', '请填写卡种价格','单位:元(RMB)')
            ->addNumber('total_rights', '权益值数量[:请输入包含的权益数量]', '默认值可更改', '50', '1', '')
            ->addNumber('total_times', '次数卡次数[:请输入包含的使用次数]', '默认值可更改', '50', '1', '')
            ->addNumber('period', '使用期限[:请选择卡的使用时间]', '默认值可更改,单位天', '30', '1', '')
            ->addNumber('monthly_times', '单月可使用次数[:请输入单月可使用次数]', '默认值可更改', '30', '1', '')
            ->addRadio('sale_status', '状态', '', [1 => '启用', 0 => '禁用'])
            ->submitConfirm()
            ->setTrigger('card_type', '2', 'monthly_times,total_times') //次卡表单项选择次数卡弹出 monthly_times,total_value2 项
            ->setTrigger('card_type', '1', 'total_rights') //权益值表单项
            ->fetch();
    }

    /***
     * 查看卡种信息
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function catCardInfo($id)
    {
        try{
            $editCard = model('PlatformCard')->catCardInfo($id);
        }catch(\Exception $e){
            $this->error('卡信息获取失败');
        }
        return ZBuilder::make('form')
            ->setPageTitle('编辑卡种')
            ->addHidden('id')
            ->addSelect('card_type', '卡种类别', '', [1 => '权益卡', 2 => '次数卡'])
            ->addText('cardname', '卡种名称')
            ->addText('cash_pay_value', '卡种价格','单位:元(RMB)')
            ->addNumber('total_rights', '权益值数量')
            ->addNumber('total_times', '次数卡次数')
            ->addNumber('period', '使用期限')
            ->addNumber('monthly_times', '单月可使用次数')
            ->addRadio('sale_status', '状态', '', [1 => '启用', 0 => '禁用'])
            ->submitConfirm()
            ->setTrigger('card_type', '2', 'monthly_times,total_times') //次卡表单项选择次数卡弹出 monthly_times,total_value2 项
            ->setTrigger('card_type', '1', 'total_rights') //权益值表单项
            ->setFormData($editCard)
            ->hideBtn(['submit'])
            ->fetch();
    }

    /***
     * 用户购买记录
     * @param $id
     * @return mixed
     * @throws \think\Exception
     */
    public function buyHistory($id)
    {
        $buyStatus = [0=>'成功',1=>'失败'];
        $buyType = [1=>'支付宝',2=>'微信'];
        $cardType = [1=>'权益卡',2=>'次数卡'];
        $condition = $this->getMap();
        try{
            $buyHistory = model('PlatformCard')->buyHistory($id,$condition);
        }catch(\Exception $e){
            $this->error('用户购买记录获取失败');
        }
        return ZBuilder::make('table')
            ->setTableName('platform_card')
            ->setPageTitle('购买记录')
            ->setSearch(['cardname' => '卡种名称','mobile'=>'手机号码','card_number'=>'卡号','jiaoyi_number'=>'第三方交易号','number'=>'交易单号'])
            ->setPrimaryKey('id')
            ->hideCheckbox()
            ->addColumns([
                ['__INDEX__', 'ID'],
                ['nickname','用户名'],
                ['mobile','手机号码'],
                ['cardname', '商品名称'],
                ['card_type', '卡种类别', 'status', '',[1=>'权益卡', 2=>'次数卡']],
                ['card_number','卡号'],
                ['cash_pay_value','卡种价格'],
                ['buy_price','支付价格'],
                ['buy_type','支付类型', 'status', '',[1=>'支付宝',2=>'微信']],
                ['jiaoyi_number','第三方交易号'],
                ['number','交易单号'],
                ['buy_status','支付状态','status', '',[0=>'成功',1=>'失败']],
                ['create_time', '购买时间','datetime'],
            ])
            ->addTopSelect('ub.card_type', '卡种类型', $cardType)
            ->addTopSelect('buy_type', '支付类型', $buyType)
            ->addTopSelect('buy_status', '支付状态', $buyStatus)
            ->addTimeFilter('ub.create_time', '', ['开始时间', '结束时间'])
            ->setColumnWidth('__INDEX__', 50)
            ->setColumnWidth('nickname', 50)
            ->setColumnWidth('buy_type', 70)
            ->setColumnWidth('cash_pay_value', 70)
            ->setColumnWidth('buy_price', 70)
            ->setColumnWidth('card_type', 70)
            ->setColumnWidth('buy_status', 60)
            ->setColumnWidth('jiaoyi_number', 120)
            ->setColumnWidth('number', 120)
            ->setRowList($buyHistory)
            ->assign('empty_tips', '没有任何数据')
            ->fetch(); // 渲染页面
    }

    /***
     * 卡种列表
     */
    public function cardList()
    {
        $cardType = [1=>'权益卡',2=>'次数卡'];
        $isExpire = [0=>'已过期',1=>'可使用'];
        $condition = $this->getMap();
        if(isset($condition['is_expire'])){ //封装已过期未过期时间筛选
            if($condition['is_expire'] == 1){
               $condition['uc.expire_time'] = ['gt', time()];
            } else {
                $condition['uc.expire_time'] = ['lt', time()];
            }
            unset($condition['is_expire']);
        }
        try{
            $cardList = model('PlatformCard')->cardList($condition);
            //$cardList = model('PlatformCard')->listOfCard($condition);
        }catch(\Exception $e){
            $this->error('卡种列表获取失败');
        }
        return ZBuilder::make('table')
        ->setTableName('platform_card')
        ->setPageTitle('购买记录')
        ->setSearch(['card_number'=>'卡号','nickname'=>'用户名','cardname' => '卡种名称','mobile'=>'手机号码'])
        ->setPrimaryKey('id')
        ->hideCheckbox()
        ->addColumns([
            ['__INDEX__', 'ID'],
            ['nickname','用户名'],
            ['mobile','手机号码'],
            ['card_number','卡号'],
            ['cardname', '卡种名称'],
            ['card_type', '卡种类别', 'status', '',[1=>'权益卡', 2=>'次数卡']],
            ['cash_pay_value','卡种价格'],
            ['total_value','卡种详情'],
            ['period','使用期限'],
            ['create_time', '购买时间','datetime'],
            ['expire_time', '过期时间','datetime'],
            ['balance_value','卡种余额'],
            ['monthRestTimes','当月剩余次数'],
            ['is_expire','状态','status','',[0=>'已过期',1=>'可使用']],
        ])
        ->addTopSelect('card_type', '卡种类型', $cardType)
        ->addTopSelect('is_expire', '是否过期', $isExpire)
        ->addTimeFilter('uc.create_time', '', ['开始时间', '结束时间'])
        ->setColumnWidth('__INDEX__', 50)
        ->setColumnWidth('nickname', 100)
        ->setColumnWidth('cash_pay_value', 70)
        ->setColumnWidth('card_type', 70)
        ->setColumnWidth('period', 70)
        ->setColumnWidth('card_number', 130)
        ->setColumnWidth('create_time', 120)
        ->setColumnWidth('expire_time', 120)
        ->setColumnWidth('balance_value', 110)
        ->setColumnWidth('monthRestTimes', 90)
        ->setColumnWidth('is_expire', 80)
        ->setRowList($cardList)
        //->setRowList($cardListArr)
        ->assign('empty_tips', '没有任何数据')
        ->fetch();
    }
}