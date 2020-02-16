<?php


namespace SuccessGo\SuccessAuth\Model;


class AuthTokenBuilder
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

    public static function builder(): self
    {
        return new self();
    }

    public function accessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function expireIn(int $expireIn): self
    {
        $this->expireIn = $expireIn;

        return $this;
    }

    public function refreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    public function openId(string $openId): self
    {
        $this->openId = $openId;

        return $this;
    }

    public function unionId(string $unionId): self
    {
        $this->unionId = $unionId;

        return $this;
    }

    public function build(): AuthToken
    {
        $authToken = new AuthToken();
        $authToken->setAccessToken($this->accessToken);
        $authToken->setExpireIn($this->expireIn);
        $authToken->setRefreshToken($this->refreshToken);
        $authToken->setOpenId($this->openId);
        $authToken->setUnionId($this->unionId);

        return $authToken;
    }
}
