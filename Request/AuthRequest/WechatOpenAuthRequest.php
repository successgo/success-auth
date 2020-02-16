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

class WechatOpenAuthRequest extends AbstractAuthRequest
{
    protected function getAccessToken(AuthCallback $authCallback): AuthToken
    {
        $rawResponse = $this->doGetAccessToken($authCallback->getCode());
        $response = json_decode($rawResponse, true);

        $this->checkResponse($response);

        return AuthTokenBuilder::builder()
            ->accessToken($response['access_token'])
            ->expireIn($response['expires_in'])
            ->refreshToken($response['refresh_token'])
            ->openId($response['openid'])
            ->unionId($response['unionid'] ?? '')
            ->build();
    }

    protected function getUserInfo(AuthToken $authToken): AuthUser
    {
        $openId = $authToken->getOpenId();

        $rawResponse = $this->doGetUserInfo($authToken);
        $response = json_decode($rawResponse, true);

        $this->checkResponse($response);

        if (isset($response['unionid'])) {
            $authToken->setUnionId($response['unionid']);
        }

        return AuthUserBuilder::builder()
            ->username($response['nickname'])
            ->nickname($response['nickname'])
            ->avatar($response['headimgurl'])
            ->uuid($openId)
            ->token($authToken)
            ->source($this->source->getName())
            ->build();
    }

    private function checkResponse(array $response): void
    {
        if (isset($response['errcode'])) {
            throw new AuthException($response['errmsg'], $response['errcode']);
        }
    }

    protected function authorizeUrl(): string
    {
        return UrlBuilder::fromBaseUrl($this->source->authorize())
            ->queryParam('appid', $this->config->getClientId())
            ->queryParam('redirect_uri', $this->config->getRedirectUri())
            ->queryParam('response_code', 'code')
            ->queryParam('scope', 'snsapi_login')
            ->build();
    }

    protected function accessTokenUrl(string $code): string
    {
        return UrlBuilder::fromBaseUrl($this->source->accessToken())
            ->queryParam('code', $code)
            ->queryParam('appid', $this->config->getClientId())
            ->queryParam('secret', $this->config->getClientSecret())
            ->queryParam('grant_type', 'authorization_code')
            ->build();
    }

    protected function userInfoUrl(AuthToken $authToken): string
    {
        return UrlBuilder::fromBaseUrl($this->source->userInfo())
            ->queryParam('access_token', $authToken->getAccessToken())
            ->queryParam('openid', $authToken->getOpenId())
            ->queryParam('lang', 'zh_CN')
            ->build();
    }
}
