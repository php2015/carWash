<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/2
 * Time: 10:32
 */

namespace app\common\util;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class Token
{
    public static function makeToken($uid)
    {
        $signer = new Sha256();
        $time = time();
        //设置token签发方
        $token = (new Builder())->setIssuer(config('token.web_site_domain'))// Configures the issuer (iss claim)
        ->setAudience(config('token.web_site_domain'))// Configures the audience (aud claim)
        //设置token ID 并替换到header
        ->setId(config('token.token_id'), true)// Configures the id (jti claim), replicating as a header item
        //设置签发时间
        ->setIssuedAt($time)// Configures the time that the token was issue (iat claim)
        //设置生效时间
        ->setNotBefore($time + config('token.token_expiry_time'))// Configures the time that the token can be used (nbf claim)
        //设置过期时间
//        ->setExpiration($time + config('token_expiration_time'))// Configures the expiration time of the token (exp claim)
        ->set('uid', $uid)// Configures a new claim, called "uid"
        ->sign($signer, config('token.web_token_secret'))
            ->getToken(); // Retrieves the generated token
        return $token->__toString();
    }

    public static function validateToken($token_str)
    {
        $token = (new Parser())->parse((string)$token_str);
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer(config('token.web_site_domain'));
        $data->setAudience(config('token.web_site_domain'));
        $data->setId(config('token.token_id'));
        $res = $token->validate($data);
        if($res !== true){
            return $res;
        }else{
            $arr = [];
            $arr['uid'] = $token->getClaim('uid');
            $arr['info'] = $token->getClaims();
            return $arr;
        }
    }

    public static function validateTokenIsExpired($token_str)
    {
        $token = (new Parser())->parse((string)$token_str);
        return $token->isExpired();
    }

}