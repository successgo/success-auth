<?php


namespace SuccessGo\SuccessAuth\Util;


use GuzzleHttp\Client;

class HttpClient
{
    public static function get(string $url, array $options = []): string
    {
        self::checkHttpClient();
        $client = new Client();
        $response = $client->get($url, $options);
        $stream = $response->getBody();
        return $stream->getContents();
    }

    public static function post(string $url, array $options = []): string
    {
        self::checkHttpClient();
        $client = new Client();
        $response = $client->post($url, $options);
        $stream = $response->getBody();
        return $stream->getContents();
    }

    private static function checkHttpClient()
    {
        if (! interface_exists('GuzzleHttp\ClientInterface')) {
            throw new \RuntimeException('You need guzzle http client installed.');
        }
    }
}
