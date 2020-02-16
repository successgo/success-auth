<?php


namespace SuccessGo\SuccessAuth\Util;


use GuzzleHttp\Client;

class HttpClient
{
    public static function get(string $url): string
    {
        self::checkHttpClient();
        $client = new Client();
        $response = $client->get($url);
        $stream = $response->getBody();
        return $stream->getContents();
    }

    public static function post(string $url): string
    {
        self::checkHttpClient();
        $client = new Client();
        $response = $client->post($url);
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
