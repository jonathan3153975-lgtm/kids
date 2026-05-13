<?php

declare(strict_types=1);

namespace Core;

use App\Services\AuthService;

final class AuthMiddleware
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function handle(): ?array
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        if (!str_starts_with($authHeader, 'Bearer ')) {
            return null;
        }

        $token = substr($authHeader, 7);

        if (empty($token)) {
            return null;
        }

        $user = $this->authService->getUserFromToken($token);

        if (!$user) {
            return null;
        }

        return $user;
    }

    public function requireAuth(): array
    {
        $user = $this->handle();

        if (!$user) {
            http_response_code(401);
            echo json_encode(['message' => 'Token de acesso inválido ou expirado']);
            exit;
        }

        return $user;
    }

    public function requireRole(array|string $roles): array
    {
        $user = $this->requireAuth();
        $roles = is_array($roles) ? $roles : [$roles];

        if (!in_array($user['role'], $roles, true)) {
            http_response_code(403);
            echo json_encode(['message' => 'Acesso negado']);
            exit;
        }

        return $user;
    }
}