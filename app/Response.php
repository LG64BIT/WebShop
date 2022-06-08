<?php
namespace app;

class Response
{
    protected $headers = [];
    protected $body;
    protected $statusCode = 200;

    public function setBody($body) : Response
    {
        $this->body=$body;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withStatus($statusCode) : Response
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function withJson($body): Response
    {
        $this->withHeader('Content-Type', 'application/json');
        $this->body = json_encode($body);
        return $this;
    }

    public function withHeader($name, $value): Response
    {
        $this->headers[] = [$name, $value];
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}