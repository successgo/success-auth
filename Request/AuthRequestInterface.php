<?php


namespace SuccessGo\SuccessAuth\Request;


use SuccessGo\SuccessAuth\Model\AuthCallback;
use SuccessGo\SuccessAuth\Model\AuthResponse;
use SuccessGo\SuccessAuth\Model\AuthToken;

interface AuthRequestInterface
{
    public function authorize(string $state = null): string;

    public function login(AuthCallback $authCallback): AuthResponse;

    public function revoke(AuthToken $authToken): AuthResponse;

    public function refresh(AuthToken $authToken): AuthResponse;
}
