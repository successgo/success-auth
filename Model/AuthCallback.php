<?php


namespace SuccessGo\SuccessAuth\Model;


class AuthCallback
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

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getEncryptedData(): string
    {
        return $this->encryptedData;
    }

    /**
     * @param string $encryptedData
     */
    public function setEncryptedData(string $encryptedData): void
    {
        $this->encryptedData = $encryptedData;
    }

    /**
     * @return string
     */
    public function getIv(): string
    {
        return $this->iv;
    }

    /**
     * @param string $iv
     */
    public function setIv(string $iv): void
    {
        $this->iv = $iv;
    }
}
