<?php


namespace SuccessGo\SuccessAuth\Config;


interface AuthSourceInterface
{
    public function authorize(): string;

    public function accessToken(): string;

    public function userInfo(): string;

    public function revoke(): string;

    public function refresh(): string;

    public function getName(): string;
}
