<?php


namespace SuccessGo\SuccessAuth\Model;


class AuthToken
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var int
     */
    private $expireIn;

    /**
     * @var string
     */
    private $refreshToken;

    /**
     * @var string
     */
    private $openId;

    /**
     * @var string
     */
    private $unionId;

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return int
     */
    public function getExpireIn(): int
    {
        return $this->expireIn;
    }

    /**
     * @param int $expireIn
     */
    public function setExpireIn(int $expireIn): void
    {
        $this->expireIn = $expireIn;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return string
     */
    public function getOpenId(): string
    {
        return $this->openId;
    }

    /**
     * @param string $openId
     */
    public function setOpenId(string $openId): void
    {
        $this->openId = $openId;
    }

    /**
     * @return string
     */
    public function getUnionId(): string
    {
        return $this->unionId;
    }

    /**
     * @param string $unionId
     */
    public function setUnionId(string $unionId): void
    {
        $this->unionId = $unionId;
    }
}
