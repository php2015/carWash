<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/29
 * Time: 12:52
 */

namespace app\common\service;


class TimeStamps extends Base
{
    /***
     * 获取时间戳
     */
    public function getTimeStamps()
    {
        try{
            list($this->status,$this->message,$this->data) = [1,'时间戳获取成功',time()];
            return;
        }catch(\Exception $e){
            list($this->status,$this->message,) = [0,'时间戳获取失败'];
            return;
        }
    }
}