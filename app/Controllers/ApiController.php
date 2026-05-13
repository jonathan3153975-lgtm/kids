<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\AuthMiddleware;
use App\Services\AuthService;
use App\Models\User;
use App\Models\Child;

final class ApiController extends Controller
{
    private AuthMiddleware $authMiddleware;
    private AuthService $authService;
    private User $userModel;
    private Child $childModel;

    public function __construct()
    {
        $this->authMiddleware = new AuthMiddleware();
        $this->authService = new AuthService();
        $this->userModel = new User();
        $this->childModel = new Child();
    }

    public function health(): void
    {
        $this->json([
            'status' => 'ok',
            'app' => config('name'),
            'mode' => 'production',
            'timestamp' => date(DATE_ATOM),
        ]);
    }

    public function login(): void
    {
        $email = trim((string) $this->requestInput('email', ''));
        $password = trim((string) $this->requestInput('password', ''));

        if ($email === '' || $password === '') {
            $this->json(['message' => 'E-mail e senha são obrigatórios'], 400);
        }

        $user = $this->authService->authenticate($email, $password);

        if (!$user) {
            $this->json(['message' => 'Credenciais inválidas'], 401);
        }

        $this->json([
            'message' => 'Autenticação realizada com sucesso',
            'access_token' => $this->authService->generateToken($user),
            'refresh_token' => $this->authService->generateRefreshToken($user),
            'user' => $this->authService->sanitizeUser($user),
        ]);
    }

    public function refresh(): void
    {
        $refreshToken = trim((string) $this->requestInput('refresh_token', ''));

        if ($refreshToken === '') {
            $this->json(['message' => 'Refresh token é obrigatório'], 400);
        }

        $result = $this->authService->refreshToken($refreshToken);

        if (!$result) {
            $this->json(['message' => 'Refresh token inválido'], 401);
        }

        $this->json($result);
    }

    public function children(): void
    {
        $user = $this->authMiddleware->requireAuth();

        $children = $this->userModel->getChildren($user['id']);

        $this->json([
            'data' => $children,
        ]);
    }

    public function storeChild(): void
    {
        $user = $this->authMiddleware->requireAuth();

        $name = trim((string) $this->requestInput('name', ''));
        $birthDate = trim((string) $this->requestInput('birth_date', ''));
        $gender = trim((string) $this->requestInput('gender', 'other'));

        if ($name === '' || $birthDate === '') {
            $this->json(['message' => 'Nome e data de nascimento são obrigatórios'], 422);
        }

        $childData = [
            'user_id' => $user['id'],
            'name' => $name,
            'birth_date' => $birthDate,
            'gender' => $gender,
        ];

        $childId = $this->childModel->createChild($childData);

        $child = $this->childModel->find($childId);

        $this->json([
            'message' => 'Criança cadastrada com sucesso',
            'data' => $child,
        ], 201);
    }

    public function games(): void
    {
        // Por enquanto retorna dados mockados, depois conectaremos ao banco
        $this->json([
            'data' => $_SESSION['games'] ?? [],
        ]);
    }
}
