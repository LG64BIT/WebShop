<?php
namespace app;

class App
{
    protected $container;

    public function __construct()
    {
        $this->container = new Container([
            'router' => function() {
                return new Router;
            },
            'response' => function() {
                return new Response;
            }
        ]);
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function get($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, ['GET']);
    }

    public function post($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, ['POST']);
    }

    public function map($uri, $handler, $methods)
    {
        $this->container->router->addRoute($uri, $handler, $methods);
    }

    public function run()
    {
        $router = $this->container->router;
        $router->setPath($_SERVER['PATH_INFO'] ?? '/');
        try {
            $response = $router->getResponse();
        }catch (\Exception $e)
        {
            if($this->container->offsetExists('errorHandler'))
                $response = $this->container->errorHandler;
            else
                return null;
        }
        return $this->respond($this->process($response));
    }

    public function process($callable)
    {
        $response = $this->container->response;
        if(is_array($callable)) {
            if(!is_object($callable[0]))
                $callable[0] = new $callable[0];
            return call_user_func($callable, $response);
        }
        return $callable($response);
    }

    protected function respond($response)
    {
        if(!$response instanceof Response) {
            echo $response;
            return null;
        }
        header(sprintf('HTTP/%s %s %s', '1.1', $response->getStatusCode(), ''));

        foreach ($response->getHeaders() as $header)
            header($header[0] . ': ' . $header[1]);
        echo $response->getBody();
    }
}