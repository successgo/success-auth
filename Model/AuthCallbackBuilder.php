<?php


namespace SuccessGo\SuccessAuth\Model;


class AuthCallbackBuilder
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     *
     * Use for WechatLite only
     */
    private $encryptedData;

    /**
     * @var string
     *
     * Use for WechatLite only
     */
    private $iv;

    public static function builder(): self
    {
        return new self();
    }

    public function code(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function encryptedData(string $encryptedData): self
    {
        $this->encryptedData = $encryptedData;

        return $this;
    }

    public function iv(string $iv): self
    {
        $this->iv = $iv;

        return $this;
    }

    public function build(): AuthCallback
    {
        $authCallback = new AuthCallback();
        $authCallback->setCode($this->code);

        if ($this->encryptedData) {
            $authCallback->setEncryptedData($this->encryptedData);
            $authCallback->setIv($this->iv);
        }

        return $authCallback;
    }
}
