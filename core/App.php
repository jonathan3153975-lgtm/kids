<?php

declare(strict_types=1);

namespace Core;

use App\Controllers\ApiController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;

final class App
{
    private Router $router;

    public function __construct(private readonly array $config)
    {
        $this->router = new Router();
        $this->bootDemoState();
        $this->registerRoutes();
    }

    public function run(): void
    {
        $this->router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
    }

    private function bootDemoState(): void
    {
        // Dados demo agora vêm do banco de dados
        // Mantém apenas para compatibilidade com jogos mockados
        $_SESSION['games'] ??= $this->config['demo']['games'] ?? [];
        $_SESSION['plans'] ??= $this->config['demo']['plans'] ?? [];
    }

    private function registerRoutes(): void
    {
        $this->router->get('/', [HomeController::class, 'index']);
        $this->router->get('/login', [AuthController::class, 'showLogin']);
        $this->router->post('/login', [AuthController::class, 'login']);
        $this->router->get('/logout', [AuthController::class, 'logout']);

        $this->router->get('/dashboard', [DashboardController::class, 'index']);
        $this->router->get('/children', [DashboardController::class, 'children']);
        $this->router->post('/children', [DashboardController::class, 'storeChild']);
        $this->router->get('/games', [DashboardController::class, 'games']);
        $this->router->get('/game', [DashboardController::class, 'games']);
        $this->router->get('/games/alphabet', [DashboardController::class, 'playAlphabet']);
        $this->router->get('/games/{slug}', [DashboardController::class, 'playGame']);
        $this->router->get('/game/{slug}', [DashboardController::class, 'playGame']);
        $this->router->get('/admin', [DashboardController::class, 'admin']);

        $this->router->get('/api/v1/health', [ApiController::class, 'health']);
        $this->router->post('/api/v1/auth/login', [ApiController::class, 'login']);
        $this->router->get('/api/v1/children', [ApiController::class, 'children']);
        $this->router->post('/api/v1/children', [ApiController::class, 'storeChild']);
        $this->router->get('/api/v1/games', [ApiController::class, 'games']);
    }
}
