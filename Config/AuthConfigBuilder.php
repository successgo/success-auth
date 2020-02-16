<?php


namespace SuccessGo\SuccessAuth\Config;


class AuthConfigBuilder
{
    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $redirectUri;

    public static function builder(): self
    {
        return new self();
    }

    public function clientId(string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function clientSecret(string $clientSecret): self
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    public function redirectUri(string $redirectUri): self
    {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    public function build(): AuthConfig
    {
        $config = new AuthConfig();
        $config->setClientId($this->clientId);
        $config->setClientSecret($this->clientSecret);
        $config->setRedirectUri($this->redirectUri);

        return $config;
    }
}
