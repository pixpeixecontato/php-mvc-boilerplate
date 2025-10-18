<?php

namespace App\Http;

class Request
{
    private array $getParams;
    private array $postParams;
    private string $body;
    private array $headers;
    private string $uri;
    private string $method;
    public function __construct()
    {
        $this->getParams = $_GET ?? [];
        $this->postParams = $_POST ?? [];
        $this->body = json_decode(file_get_contents("php://input"),true) ?? "";
        $this->headers = getallheaders();
        $this->uri = $_SERVER["REQUEST_URI"];
        $this->method = $_SERVER["REQUEST_METHOD"];
    }

    /**
     * Get the value of getParams
     */ 
    public function getGetParams()
    {
        return $this->getParams;
    }

    /**
     * Get the value of postParams
     */ 
    public function getPostParams()
    {
        return $this->postParams;
    }

    /**
     * Get the value of method
     */ 
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the value of uri
     */ 
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Get the value of body
     */ 
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get the value of headers
     */ 
    public function getHeaders()
    {
        return $this->headers;
    }
}