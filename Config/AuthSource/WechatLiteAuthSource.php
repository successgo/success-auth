<?php


namespace SuccessGo\SuccessAuth\Config\AuthSource;


use SuccessGo\SuccessAuth\Config\AuthSourceInterface;
use SuccessGo\SuccessAuth\Enum\AuthResponseStatus;
use SuccessGo\SuccessAuth\Exception\AuthException;

class WechatLiteAuthSource implements AuthSourceInterface
{
    public function authorize(): string
    {
        throw AuthException::fromStatus(AuthResponseStatus::NOT_IMPLEMENTED);
    }

    public function accessToken(): string
    {
        return 'https://api.weixin.qq.com/sns/jscode2session';
    }

    public function userInfo(): string
    {
        throw AuthException::fromStatus(AuthResponseStatus::NOT_IMPLEMENTED);
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
        return 'Wechat Lite';
    }
}
