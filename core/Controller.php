<?php

declare(strict_types=1);

namespace Core;

abstract class Controller
{
    protected function render(string $view, array $params = [], string $layout = 'layouts/app'): void
    {
        $viewPath = ROOT_PATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';
        $layoutPath = ROOT_PATH . '/app/Views/' . str_replace('.', '/', $layout) . '.php';

        if (!is_file($viewPath)) {
            http_response_code(500);
            echo 'View nao encontrada.';
            return;
        }

        extract($params, EXTR_SKIP);

        ob_start();
        require $viewPath;
        $content = (string) ob_get_clean();

        require $layoutPath;
    }

    protected function redirect(string $path): never
    {
        header('Location: ' . app_url($path));
        exit;
    }

    protected function json(array $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    protected function requestInput(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected function requireAuth(): void
    {
        if (!is_authenticated()) {
            flash('error', 'Entre com uma conta demo para continuar.');
            $this->redirect('login');
        }
    }

    protected function requireRole(array|string $roles): void
    {
        if (!has_role($roles)) {
            flash('error', 'Voce nao tem permissao para acessar esta area.');
            $this->redirect('dashboard');
        }
    }
}
