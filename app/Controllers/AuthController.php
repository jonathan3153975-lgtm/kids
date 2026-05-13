<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Services\AuthService;

final class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function showLogin(): void
    {
        if (is_authenticated()) {
            $this->redirect('dashboard');
        }

        $this->render('auth/login');
    }

    public function login(): void
    {
        $email = trim((string) $this->requestInput('email', ''));
        $password = trim((string) $this->requestInput('password', ''));

        $_SESSION['_old'] = ['email' => $email];

        if ($email === '' || $password === '') {
            flash('error', 'E-mail e senha são obrigatórios.');
            $this->redirect('login');
        }

        $user = $this->authService->authenticate($email, $password);

        if (!$user) {
            flash('error', 'Credenciais inválidas. Use as contas demo exibidas na tela.');
            $this->redirect('login');
        }

        $_SESSION['auth_user'] = $this->authService->sanitizeUser($user);
        $_SESSION['access_token'] = $this->authService->generateToken($user);
        $_SESSION['refresh_token'] = $this->authService->generateRefreshToken($user);

        unset($_SESSION['_old']);
        flash('success', 'Login realizado com sucesso.');
        $this->redirect('dashboard');
    }

    public function logout(): void
    {
        unset($_SESSION['auth_user'], $_SESSION['access_token'], $_SESSION['refresh_token']);
        flash('success', 'Sessão encerrada.');
        $this->redirect('login');
    }
}
