# SuccessAuth

Make auth login easy

## Install

```shell script
composer require "successgo/success-auth:^1.0" -vvv
```

## Use

```php
// build config
$config = \SuccessGo\SuccessAuth\Config\AuthConfigBuilder::builder()
    ->clientId('Client Id')
    ->clientSecret('Client Secret')
    ->redirectUri('Redirect Uri')
    ->build();

// build the auth request
$authRequest = new \SuccessGo\SuccessAuth\Request\AuthRequest\WechatOpenAuthRequest($config, new \SuccessGo\SuccessAuth\Config\AuthSource\WechatOpenAuthSource());

// build auth callback
$authCallback = \SuccessGo\SuccessAuth\Model\AuthCallbackBuilder::builder()->code('Code')->build();

// get the auth response
$authResponse = $authRequest->login($authCallback);

if ($authResponse->isOk()) {
    // Do your business here
}
```

## Acknowledgement

- JustAuth https://github.com/justauth/JustAuth
- YunrunOAuthLogin https://github.com/Yurunsoft/YurunOAuthLogin

## LICENSE

See https://successgo.mit-license.org
