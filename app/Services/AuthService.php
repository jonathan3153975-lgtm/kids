<?php

declare(strict_types=1);

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

final class AuthService
{
    private User $userModel;
    private array $jwtConfig;

    public function __construct()
    {
        $this->userModel = new User();
        $config = require ROOT_PATH . '/config/database.php';
        $this->jwtConfig = $config['jwt'];
    }

    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return null;
        }

        if ($user['status'] !== 'active') {
            return null;
        }

        return $user;
    }

    public function generateToken(array $user): string
    {
        $payload = [
            'iss' => 'kids-platform',
            'aud' => 'kids-platform',
            'iat' => time(),
            'exp' => time() + $this->jwtConfig['expires_in'],
            'user_id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        return JWT::encode($payload, $this->jwtConfig['secret'], $this->jwtConfig['algorithm']);
    }

    public function generateRefreshToken(array $user): string
    {
        $payload = [
            'iss' => 'kids-platform',
            'aud' => 'kids-platform',
            'iat' => time(),
            'exp' => time() + $this->jwtConfig['refresh_expires_in'],
            'user_id' => $user['id'],
            'type' => 'refresh',
        ];

        return JWT::encode($payload, $this->jwtConfig['secret'], $this->jwtConfig['algorithm']);
    }

    public function validateToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->jwtConfig['secret'], $this->jwtConfig['algorithm']));

            if ($decoded->type === 'refresh') {
                return null; // Refresh tokens não são válidos para acesso
            }

            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function validateRefreshToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->jwtConfig['secret'], $this->jwtConfig['algorithm']));

            if ($decoded->type !== 'refresh') {
                return null;
            }

            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getUserFromToken(string $token): ?array
    {
        $payload = $this->validateToken($token);

        if (!$payload) {
            return null;
        }

        return $this->userModel->find((int) $payload['user_id']);
    }

    public function refreshToken(string $refreshToken): ?array
    {
        $payload = $this->validateRefreshToken($refreshToken);

        if (!$payload) {
            return null;
        }

        $user = $this->userModel->find((int) $payload['user_id']);

        if (!$user) {
            return null;
        }

        return [
            'access_token' => $this->generateToken($user),
            'refresh_token' => $this->generateRefreshToken($user),
            'user' => $this->sanitizeUser($user),
        ];
    }

    public function sanitizeUser(array $user): array
    {
        unset($user['password'], $user['remember_token']);
        return $user;
    }
}