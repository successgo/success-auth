<?php


namespace SuccessGo\SuccessAuth\Model;


use SuccessGo\SuccessAuth\Enum\AuthResponseStatus;

class AuthResponse
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $msg;

    /**
     * @var mixed
     */
    private $data;

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getMsg(): string
    {
        return $this->msg;
    }

    public function setMsg(string $msg): void
    {
        $this->msg = $msg;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function ok(): bool
    {
        return $this->code === AuthResponseStatus::SUCCESS;
    }
}
