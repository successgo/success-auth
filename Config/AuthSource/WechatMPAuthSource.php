<?php


namespace SuccessGo\SuccessAuth\Config\AuthSource;


use SuccessGo\SuccessAuth\Config\AuthSourceInterface;
use SuccessGo\SuccessAuth\Enum\AuthResponseStatus;
use SuccessGo\SuccessAuth\Exception\AuthException;

class WechatMPAuthSource implements AuthSourceInterface
{
    public function authorize(): string
    {
        return 'https://open.weixin.qq.com/connect/oauth2/authorize';
    }

    public function accessToken(): string
    {
        return 'https://api.weixin.qq.com/sns/oauth2/access_token';
    }

    public function userInfo(): string
    {
        return 'https://api.weixin.qq.com/sns/userinfo';
    }

    public function revoke(): string
    {
        throw AuthException::fromStatus(AuthResponseStatus::NOT_IMPLEMENTED);
    }

    public function refresh(): string
    {
        throw AuthException::fromStatus(AuthResponseStatus::NOT_IMPLEMENTED);
    }

    public function getName(): string
    {
        return 'Wechat MP';
    }
}
