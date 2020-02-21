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

class FacebookAuthRequest extends AbstractAuthRequest
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
        $rawResponse = $this->doGetUserInfo($authToken);
        $response = json_decode($rawResponse, true);

        $this->checkResponse($response);

        return AuthUserBuilder::builder()
            ->uuid($response['id'])
            ->username($response['name'])
            ->nickname($response['name'])
            ->avatar($this->getUserPicture($response) ?? '')
            ->token($authToken)
            ->source($this->source->getName())
            ->build();
    }

    private function getUserPicture($response)
    {
        if (isset($response['picture'], $response['picture']['data'], $response['picture']['data']['url'])) {
            return $response['picture']['data']['url'];
        }

        return null;
    }

    protected function userInfoUrl(AuthToken $authToken): string
    {
        return UrlBuilder::fromBaseUrl($this->source->userInfo())
            ->queryParam('access_token', $authToken->getAccessToken())
            ->queryParam('fields', 'id,name,picture.width(400)')
            ->build();
    }

    private function checkResponse(array $response): void
    {
        if (isset($response['error'])) {
            throw AuthException::fromMessage($response['error']['message']);
        }
    }
}
