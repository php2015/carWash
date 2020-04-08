<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/13
 * Time: 15:04
 */

namespace app\common\service;

class Base
{
    /**
     * 返回状态
     * @var int
     */
    protected $status = 0;

    /**
     * 返回数据
     * @var null
     */
    protected $data = '';

    /**
     * 返回信息
     * @var string
     */
    protected $message = '';

    /**
     * 构造方法
     * Base constructor.
     */
    public function __construct()
    {
    }

    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : null;
    }

    /***
     * 二维码参数解密
     * @param $str
     * @return array|bool
     */
    public function getUrlDeCode($str)
    {
        try {
            $decode = base64_decode($str);

            $decodeArr = explode('.', $decode);

            $endRound = end($decodeArr);

            $byteArr = [];
            $num = count($decodeArr) - 1;
            foreach ($decodeArr as $k => $v) {
                if ($k < $num) {
                    array_push($byteArr, $v - $endRound);
                }
            }

            $params = '';//准备解码的数据池
            foreach ($byteArr as $key => $value) {
                $params .= chr($value);
            }

            $paramsArr = explode('#', $params);
            if(count($paramsArr) > 3){
                return ['userId'=>$paramsArr[0],'jieSuan'=>$paramsArr[1],'cardId'=>$paramsArr[2],'timestamp'=>$paramsArr[3]];
            } else {
                return ['sellerId' => $paramsArr[1], 'staffId' => $paramsArr[0], 'timestamp' => $paramsArr[2]];
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}