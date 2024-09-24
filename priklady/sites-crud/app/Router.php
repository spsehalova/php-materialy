<?php

namespace App;

use Exception;

class Router
{
    /**
     * @var Endpoint[]
     */
    public array $endpoints = [];

    protected Endpoint $currentEndpoint;

    public function get(string $path, callable $action, $isApi = false): void
    {
        $this->endpoints[] = new Endpoint($path, HttpMethod::GET, $action, $isApi);
    }

    public function getCurrentEndpoint(): ?Endpoint
    {
        return $this->currentEndpoint ?? null;
    }

    /**
     * @throws Exception
     */
    public function resolve(): void
    {
        $path = $_SERVER['REQUEST_URI'];
        $method = HttpMethod::from($_SERVER['REQUEST_METHOD']);

        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->match($path, $method)) {
                $this->currentEndpoint = $endpoint;

                try
                {
                    $response = $endpoint->execute($this);
                }
                catch (Exception $e)
                {
                    if ($e->getCode() >= 400 && $e->getCode() < 500)
                    {
                        http_response_code($e->getCode());

                        if ($endpoint->isApi())
                        {
                            header('Content-Type: application/json');
                            echo json_encode([
                                'error' => $e->getMessage(),
                                'status' => $e->getCode()
                            ]);
                        }
                        else
                        {
                            echo layout('Error', function () use ($e) {
                                return "<h1> {$e->getMessage()} </h1>";
                            });
                        }
                        die($e->getCode());
                    }
                    else
                    {
                        if ($endpoint->isApi())
                        {
                            echo json_encode([
                                'error' => 'Internal Server Error',
                                'status' => 500
                            ]);
                        }
                        else
                        {
                            echo layout('Internal Server Error', function () {
                                return "<h1> Internal Server Error </h1>";
                            });
                        }
                        die(500);
                    }

                }


                if ($endpoint->isApi()) {
                    header('Content-Type: application/json');

                    if (is_string($response)) {
                        echo $response;
                        return;
                    }

                    if (!is_array($response)) {
                        if (method_exists($response, 'toArray')) {
                            $response = $response->toArray();
                        }
                    }

                    echo json_encode([
                        'data' => $response
                    ]);
                    return;
                }
                else {
                    if (isset($response) && is_string($response))
                    {
                        echo $response;
                    }
                }

                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
        die(404);
    }
}