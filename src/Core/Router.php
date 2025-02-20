<?php

declare(strict_types=1);

namespace App\Core;

use function http_response_code;
use function json_encode;

class Router
{
    /**
     * @var array
     */
    private array $routes = [];

    /**
     * @param string   $uri
     * @param callable $callback
     *
     * @return void
     */
    public function get(string $uri, callable $callback): void
    {
        $this->routes['GET'][$uri] = $callback;
    }

    /**
     * @param string   $uri
     * @param callable $callback
     *
     * @return void
     */
    public function post(string $uri, callable $callback): void
    {
        $this->routes['POST'][$uri] = $callback;
    }

    /**
     * @param string $uri
     * @param string $method
     *
     * @return void
     */
    public function dispatch(string $uri, string $method): void
    {
        $callback = $this->routes[$method][$uri] ?? null;

        if (!$callback) {
            http_response_code(404);
            echo json_encode(['error' => 'Not Found']);

            return;
        }

        echo json_encode($callback());
    }
}
