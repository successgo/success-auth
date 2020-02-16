<?php


namespace SuccessGo\SuccessAuth\Model;


class AuthUserBuilder
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var string
     */
    private $source;

    /**
     * @var AuthToken
     */
    private $token;

    public static function builder(): self
    {
        return new self();
    }

    public function uuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function username(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function nickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function avatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function source(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function token(AuthToken $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function build(): AuthUser
    {
        $authUser = new AuthUser();
        $authUser->setUuid($this->uuid);
        $authUser->setUsername($this->username);
        $authUser->setNickname($this->nickname);
        $authUser->setAvatar($this->avatar);
        $authUser->setSource($this->source);
        $authUser->setToken($this->token);

        return $authUser;
    }
}
