<?php
namespace app;

use app\exceptions\PageNotFoundException;

class Response
{
    protected $headers = [];
    protected $body;
    protected $statusCode = 200;

    public function setBody($body, $vars = []) : ?Response
    {
        ob_start();
        try {
            extract($vars, EXTR_SKIP);
            if(!str_ends_with($body, '.php') || !file_exists($body))
                throw new PageNotFoundException("Page not found!");
            include $body;
        } catch (\Exception $exception) {
            ob_end_clean();
            echo $exception->getMessage();
        }
        $this->body = ob_get_clean();
        return $this;
    }

    public function getBody()
    {
        if(!str_ends_with($this->body, '.php'))
            return $this->body;
        include $this->body;
        return null;
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