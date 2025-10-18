<?php

namespace App\Http;

class Response
{
    const CONTENT_TYPE_HTTML = "text/html";
    const CONTENT_TYPE_JSON = "application/json";
    private array $headers;
    private int $httpCode;
    private string $content;
    private string $contentType;
    public function __construct(string $content, int $httpCode = 200,string $contentType = "text/html")
    {
        $this->content = $content;
        $this->contentType = $contentType;
        $this->setHeaders("Content-Type",$contentType);
        $this->setHttpCode($httpCode);
    }
    public function setHeaders(string $key, string $value):void
    {
        $this->headers[$key] = $value;
        header("$key: $value");
    }
    public function response():void
    {
        echo $this->content;
        exit;
    }
    private function setHttpCode(int $httpCode):void
    {
        $this->httpCode = $httpCode;
        http_response_code($httpCode);
    }

}