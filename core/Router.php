<?php

declare(strict_types=1);

namespace Core;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, array $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $path = rtrim($path, '/') ?: '/';

        $action = $this->routes[$method][$path] ?? null;

        // Se não encontrou correspondência exata, tentar encontrar rota com parâmetros
        if ($action === null) {
            $action = $this->findRouteWithParams($method, $path);
        }

        // Se não encontrou correspondência exata, tentar encontrar rota com parâmetros
        if ($action === null) {
            $action = $this->findRouteWithParams($method, $path);
        }

        if ($action === null) {
            http_response_code(404);
            echo 'Pagina nao encontrada.';
            return;
        }

        if (is_array($action) && count($action) === 3) {
            // Rota com parâmetros: [$controllerClass, $controllerMethod, $params]
            [$controllerClass, $controllerMethod, $params] = $action;
            $controller = new $controllerClass();
            $controller->{$controllerMethod}(...$params);
        } else {
            // Rota sem parâmetros: [$controllerClass, $controllerMethod]
            [$controllerClass, $controllerMethod] = $action;
            $controller = new $controllerClass();
            $controller->{$controllerMethod}();
        }
    }

    private function findRouteWithParams(string $method, string $path): ?array
    {
        if (!isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $routePath => $action) {
            $params = $this->matchRoute($routePath, $path);
            if ($params !== null) {
                return [$action[0], $action[1], $params];
            }
        }

        return null;
    }

    private function matchRoute(string $routePath, string $requestPath): ?array
    {
        // Converter {param} para regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $requestPath, $matches)) {
            // Remover o match completo (índice 0) e retornar apenas os parâmetros
            array_shift($matches);
            return $matches;
        }

        return null;
    }

    private function addRoute(string $method, string $path, array $action): void
    {
        $normalizedPath = rtrim($path, '/') ?: '/';
        $this->routes[$method][$normalizedPath] = $action;
    }
}
