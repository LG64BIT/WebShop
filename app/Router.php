<?php

namespace App;

use app\exceptions\MethodNotAllowedException;
use app\exceptions\RouteNotFoundException;

class Router
{
    protected $routes = [];
    protected $path;
    protected $methods = [];

    public function addRoute($uri, $handler, array $methods = ['GET'])
    {
        $this->routes[$uri] = $handler;
        $this->methods[$uri] = $methods;
    }

    public function setPath($path = '/')
    {
        $this->path = $path;
    }

    public function getResponse()
    {
        if(!isset($this->routes[$this->path])) {
            throw new RouteNotFoundException("Route {$this->path} not registered!");
        }
        if(!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$this->path])) {
            throw new MethodNotAllowedException("Method not allowed!");
        }
        return $this->routes[$this->path];
    }
}
