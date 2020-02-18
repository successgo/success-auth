<?php


namespace SuccessGo\SuccessAuth\Request\AuthRequest;


use SuccessGo\SuccessAuth\Enum\AuthResponseStatus;
use SuccessGo\SuccessAuth\Exception\AuthException;
use SuccessGo\SuccessAuth\Model\AuthCallback;
use SuccessGo\SuccessAuth\Model\AuthToken;
use SuccessGo\SuccessAuth\Model\AuthTokenBuilder;
use SuccessGo\SuccessAuth\Model\AuthUser;
use SuccessGo\SuccessAuth\Model\AuthUserBuilder;
use SuccessGo\SuccessAuth\Request\AbstractAuthRequest;
use SuccessGo\SuccessAuth\Util\UrlBuilder;

class WechatLiteAuthRequest extends AbstractAuthRequest
{
    /**
     * @var string
     */
    private $encryptedData;

    /**
     * @var string
     */
    private $iv;

    protected function getAccessToken(AuthCallback $authCallback): AuthToken
    {
        $rawResponse = $this->doGetAccessToken($authCallback->getCode());
        $response = json_decode($rawResponse, true);

        $this->checkResponse($response);

        $this->encryptedData = $authCallback->getEncryptedData();
        $this->iv = $authCallback->getIv();

        return AuthTokenBuilder::builder()
            ->accessToken($response['session_key']) // Use session_key to decrypt data for later use
            ->expireIn(0) // No expire in
            ->refreshToken('') // No refresh token
            ->openId($response['openid'])
            ->unionId($response['unionid'] ?? '') // union id may not exist
            ->build();
    }

    protected function getUserInfo(AuthToken $authToken): AuthUser
    {
        $sessionKey = $authToken->getAccessToken();
        $openId = $authToken->getOpenId();

        if (strlen($sessionKey) != 24) {
            throw AuthException::fromStatus(AuthResponseStatus::SESSION_KEY_FMT_ERR);
        }

        if (strlen($this->iv) != 24) {
            throw AuthException::fromStatus(AuthResponseStatus::IV_FMT_ERR);
        }

        $aesKey = base64_decode($sessionKey);
        $aesIv = base64_decode($this->iv);
        $aesCipher = base64_decode($this->encryptedData);
        $rawDecryptedResult = openssl_decrypt($aesCipher, 'aes-128-cbc', $aesKey, 1, $aesIv);
        $data = json_decode($rawDecryptedResult, true);
        if (!$data) {
            throw AuthException::fromStatus(AuthResponseStatus::WECHAT_LITE_DECRYPT_FAIL);
        }

        if (isset($data['unionId'])) {
            $authToken->setUnionId($data['unionId']);
        }

        return AuthUserBuilder::builder()
            ->username($data['nickName'])
            ->nickname($data['nickName'])
            ->avatar($data['avatarUrl'])
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

    protected function accessTokenUrl(string $code): string
    {
        return UrlBuilder::fromBaseUrl($this->source->accessToken())
            ->queryParam('js_code', $code)
            ->queryParam('appid', $this->config->getClientId())
            ->queryParam('secret', $this->config->getClientSecret())
            ->queryParam('grant_type', 'authorization_code')
            ->build();
    }
}
