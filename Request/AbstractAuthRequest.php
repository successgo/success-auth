<?php


namespace SuccessGo\SuccessAuth\Request;


use SuccessGo\SuccessAuth\Config\AuthConfig;
use SuccessGo\SuccessAuth\Config\AuthSourceInterface;
use SuccessGo\SuccessAuth\Enum\AuthResponseStatus;
use SuccessGo\SuccessAuth\Exception\AuthException;
use SuccessGo\SuccessAuth\Model\AuthCallback;
use SuccessGo\SuccessAuth\Model\AuthResponse;
use SuccessGo\SuccessAuth\Model\AuthResponseBuilder;
use SuccessGo\SuccessAuth\Model\AuthToken;
use SuccessGo\SuccessAuth\Model\AuthUser;
use SuccessGo\SuccessAuth\Util\HttpClient;
use SuccessGo\SuccessAuth\Util\UrlBuilder;

abstract class AbstractAuthRequest implements AuthRequestInterface
{
    /**
     * @var AuthConfig
     */
    protected $config;

    /**
     * @var AuthSourceInterface
     */
    protected $source;

    public function __construct(AuthConfig $config, AuthSourceInterface $source)
    {
        $this->config = $config;
        $this->source = $source;
    }

    public function authorize(string $state = null): string
    {
        return $this->authorizeUrl();
    }

    abstract protected function getAccessToken(AuthCallback $authCallback): AuthToken;

    abstract protected function getUserInfo(AuthToken $authToken): AuthUser;

    public function login(AuthCallback $authCallback): AuthResponse
    {
        try {
            $authToken = $this->getAccessToken($authCallback);
            $authUser = $this->getUserInfo($authToken);

            return AuthResponseBuilder::builder()
                ->code(AuthResponseStatus::SUCCESS)
                ->msg(AuthResponseStatus::getStatusMsg(AuthResponseStatus::SUCCESS))
                ->data($authUser)
                ->build();
        } catch (\Exception $e) {
            return $this->responseError($e);
        }
    }

    private function responseError(\Exception $e): AuthResponse
    {
        $errCode = AuthResponseStatus::FAILURE;
        $errMsg = $e->getMessage();
        if ($e instanceof AuthException) {
            $errCode = $e->getCode();
        }

        return AuthResponseBuilder::builder()->code($errCode)->msg($errMsg)->build();
    }

    public function revoke(AuthToken $authToken): AuthResponse
    {
        throw AuthException::fromStatus(AuthResponseStatus::NOT_IMPLEMENTED);
    }

    public function refresh(AuthToken $authToken): AuthResponse
    {
        throw AuthException::fromStatus(AuthResponseStatus::NOT_IMPLEMENTED);
    }

    protected function authorizeUrl(): string
    {
        return UrlBuilder::fromBaseUrl($this->source->authorize())
            ->queryParam('response_type', 'code')
            ->queryParam('client_id', $this->config->getClientId())
            ->queryParam('redirect_uri', $this->config->getRedirectUri())
            ->build();
    }

    protected function accessTokenUrl(string $code): string
    {
        return UrlBuilder::fromBaseUrl($this->source->accessToken())
            ->queryParam('code', $code)
            ->queryParam('client_id', $this->config->getClientId())
            ->queryParam('client_secret', $this->config->getClientSecret())
            ->queryParam('grant_type', 'authorization_code')
            ->build();
    }

    protected function userInfoUrl(AuthToken $authToken): string
    {
        return UrlBuilder::fromBaseUrl($this->source->userInfo())
            ->queryParam('access_token', $authToken->getAccessToken())
            ->build();
    }

    protected function doPostAccessToken(string $code, array $options = []): string
    {
        return HttpClient::post($this->accessTokenUrl($code), $options);
    }

    protected function doGetAccessToken(string $code, array $options = []): string
    {
        return HttpClient::get($this->accessTokenUrl($code), $options);
    }

    protected function doPostUserInfo(AuthToken $authToken, array $options = []): string
    {
        return HttpClient::post($this->userInfoUrl($authToken), $options);
    }

    protected function doGetUserInfo(AuthToken $authToken, array $options = []): string
    {
        return HttpClient::get($this->userInfoUrl($authToken), $options);
    }
}
