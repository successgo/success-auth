<?php


namespace SuccessGo\SuccessAuth\Util;


class UrlBuilder
{
    private $params = [];
    private $baseUrl;

    private function __construct()
    {
    }

    public static function fromBaseUrl(string $baseUrl): self
    {
        $builder = new self();
        $builder->setBaseUrl($baseUrl);

        return $builder;
    }

    public function queryParam($key, $value): self
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function build(): string
    {
        if (empty($this->params)) {
            return $this->baseUrl;
        }
        $baseUrl = StringHelper::appendIfNotContain($this->baseUrl, '?', '&');
        $paramString = http_build_query($this->params);

        return $baseUrl . $paramString;
    }

    /**
     * @param mixed $baseUrl
     */
    public function setBaseUrl($baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }
}
