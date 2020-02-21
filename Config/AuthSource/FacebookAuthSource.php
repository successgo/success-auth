<?php


namespace SuccessGo\SuccessAuth\Config\AuthSource;


use SuccessGo\SuccessAuth\Config\AuthSourceInterface;
use SuccessGo\SuccessAuth\Enum\AuthResponseStatus;
use SuccessGo\SuccessAuth\Exception\AuthException;

class FacebookAuthSource implements AuthSourceInterface
{
    public function authorize(): string
    {
        return 'https://www.facebook.com/v3.3/dialog/oauth';
    }

    public function accessToken(): string
    {
        return 'https://graph.facebook.com/v3.3/oauth/access_token';
    }

    public function userInfo(): string
    {
        return 'https://graph.facebook.com/v3.3/me';
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
        return 'Facebook';
    }
}
