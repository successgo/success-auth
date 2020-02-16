<?php


namespace SuccessGo\SuccessAuth\Model;


class AuthResponseBuilder
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

    public static function builder(): self
    {
        return new self();
    }

    public function code(int $code): AuthResponseBuilder
    {
        $this->code = $code;

        return $this;
    }

    public function msg(string $msg): AuthResponseBuilder
    {
        $this->msg = $msg;

        return $this;
    }

    public function data($data): AuthResponseBuilder
    {
        $this->data = $data;

        return $this;
    }

    public function build(): AuthResponse
    {
        $response = new AuthResponse();
        $response->setCode($this->code);
        $response->setMsg($this->msg);
        $response->setData($this->data);

        return $response;
    }
}
