<?php


namespace SuccessGo\SuccessAuth\Enum;


use SuccessGo\SuccessAuth\Exception\AuthException;

class AuthResponseStatus
{
    const SUCCESS = 2000;
    const FAILURE = 5000;
    const NOT_IMPLEMENTED = 5001;
    const PARAM_MISSING = 5002;
    const UNSUPPORTED = 5003;
    const NO_AUTH_SOURCE = 5004;
    const UNIDENTIFIED_PLATFORM = 5005;
    const ILLEGAL_REDIRECT_URI = 5006;
    const ILLEGAL_REQUEST = 5007;
    const ILLEGAL_CODE = 5008;
    const ILLEGAL_STATUS = 5009;
    const REQUIRE_REFRESH_TOKEN = 5010;
    const SESSION_KEY_FMT_ERR = 5011;
    const IV_FMT_ERR = 5012;
    const WECHAT_LITE_DECRYPT_FAIL = 5013;

    public static $statusMsgMap = [
        self::SUCCESS => 'Success',
        self::FAILURE => 'Failure',
        self::NOT_IMPLEMENTED => 'Not implemented',
        self::PARAM_MISSING => 'Param missing',
        self::UNSUPPORTED => 'Unsupported operation',
        self::NO_AUTH_SOURCE => 'AuthSource can not be null',
        self::UNIDENTIFIED_PLATFORM => 'Unidentified platform',
        self::ILLEGAL_REDIRECT_URI => 'Illegal redirect URI',
        self::ILLEGAL_REQUEST => 'Illegal request',
        self::ILLEGAL_CODE => 'Illegal code',
        self::ILLEGAL_STATUS => 'Illegal state',
        self::REQUIRE_REFRESH_TOKEN => 'Refresh token required',
        self::SESSION_KEY_FMT_ERR => 'Session key format error',
        self::IV_FMT_ERR => 'Iv format error',
        self::WECHAT_LITE_DECRYPT_FAIL => 'Wechat lite decrypt fail',
    ];

    public static function getStatusMsg(int $code): string
    {
        if (isset(self::$statusMsgMap[$code])) {
            return self::$statusMsgMap[$code];
        }

        return null;
    }
}
