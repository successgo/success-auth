<?php


namespace SuccessGo\SuccessAuth\Request\AuthRequest;


use SuccessGo\SuccessAuth\Exception\AuthException;
use SuccessGo\SuccessAuth\Model\AuthCallback;
use SuccessGo\SuccessAuth\Model\AuthToken;
use SuccessGo\SuccessAuth\Model\AuthTokenBuilder;
use SuccessGo\SuccessAuth\Model\AuthUser;
use SuccessGo\SuccessAuth\Model\AuthUserBuilder;
use SuccessGo\SuccessAuth\Request\AbstractAuthRequest;
use SuccessGo\SuccessAuth\Util\UrlBuilder;

class GoogleAuthRequest extends AbstractAuthRequest
{
    protected function getAccessToken(AuthCallback $authCallback): AuthToken
    {
        $rawResponse = $this->doPostAccessToken($authCallback->getCode());
        $response = json_decode($rawResponse, true);

        $this->checkResponse($response);

        return AuthTokenBuilder::builder()
            ->accessToken($response['access_token'])
            ->expireIn($response['expires_in'])
            ->build();
    }

    protected function getUserInfo(AuthToken $authToken): AuthUser
    {
        $rawResponse = $this->doPostUserInfo($authToken, ['headers' => ['Authorization' => 'Bearer ' . $authToken->getAccessToken()]]);
        $response = json_decode($rawResponse, true);

        $this->checkResponse($response);

        return AuthUserBuilder::builder()
            ->uuid($response['sub'])
            ->username($response['email'])
            ->avatar($response['picture'])
            ->nickname($response['name'])
            ->token($authToken)
            ->source($this->source->getName())
            ->build();
    }

    protected function userInfoUrl(AuthToken $authToken): string
    {
        return UrlBuilder::fromBaseUrl($this->source->userInfo())
            ->queryParam('access_token', $authToken->getAccessToken())
            ->build();
    }

    private function checkResponse($response)
    {
        if (isset($response['error'], $response['message'])) {
            throw AuthException::fromMessage($response['message']);
        }
    }
}
