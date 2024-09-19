<?php

namespace App;

class Endpoint
{
    protected string $path;
    protected HttpMethod $method;
    protected $controller;
    protected bool $isApi;

    protected array $urlParams = [];

    public function __construct(string $path, HttpMethod $method, callable $action, bool $isApi)
    {
        $this->path = $path;
        $this->method = $method;
        $this->controller = $action;
        $this->isApi = $isApi;
    }

    public function match(string $path, HttpMethod $method): bool
    {
        //return $this->path === $path && $this->method === $method;

        $correctPath = explode('/', $this->path);
        $currentPath = explode('/', $path);


        $filterPathItem = function ($part) {
            return !empty($part) && $part !== '/';
        };

        $correctPath = array_filter($correctPath, $filterPathItem);
        $currentPath = array_filter($currentPath, $filterPathItem);

        foreach ($correctPath as $correctPathPart) {
            $currentPathPart = array_shift($currentPath);

            if ($correctPathPart === $currentPathPart) {
                continue;
            }

            if (str_starts_with($correctPathPart, '{') && str_ends_with($correctPathPart, '}')) {
                $this->urlParams[trim($correctPathPart, '{}')] = $currentPathPart;
                continue;
            }

            return false;
        }

        if (!empty($currentPath)) {
            return false;
        }

        return true;
    }

    public function execute(Router $router): mixed
    {
        return ($this->controller)($router);
    }

    public function isApi(): bool
    {
        return $this->isApi;
    }

    public function getUrlParams(): array
    {
        return $this->urlParams;
    }

    public function hasUrlParams(): bool
    {
        return !empty($this->urlParams);
    }
}