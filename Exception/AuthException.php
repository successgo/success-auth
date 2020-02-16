<?php


namespace SuccessGo\SuccessAuth\Exception;


use SuccessGo\SuccessAuth\Config\AuthSourceInterface;
use SuccessGo\SuccessAuth\Enum\AuthResponseStatus;
use Throwable;

class AuthException extends \RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null, AuthSourceInterface $source = null)
    {
        if ($source !== null) {
            $message = sprintf("%s [%s]", $message, $source->getName());
        }

        parent::__construct($message, $code, $previous);
    }

    public static function fromMessage(string $msg): self
    {
        return new AuthException($msg, AuthResponseStatus::FAILURE);
    }

    public static function fromStatus(int $code): self
    {
        return new AuthException(AuthResponseStatus::getStatusMsg($code), $code);
    }
}
