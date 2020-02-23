<?php


namespace SuccessGo\SuccessAuth\Config\AuthSource;


use SuccessGo\SuccessAuth\Config\AuthSourceInterface;
use SuccessGo\SuccessAuth\Enum\AuthResponseStatus;
use SuccessGo\SuccessAuth\Exception\AuthException;

class GoogleAuthSource implements AuthSourceInterface
{
    public function authorize(): string
    {
        return 'https://accounts.google.com/o/oauth2/v2/auth';
    }

    public function accessToken(): string
    {
        return 'https://www.googleapis.com/oauth2/v4/token';
    }

    public function userInfo(): string
    {
        return 'https://www.googleapis.com/oauth2/v3/userinfo';
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
        return 'Google';
    }
}
