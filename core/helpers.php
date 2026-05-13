<?php

declare(strict_types=1);

function config(?string $key = null, mixed $default = null): mixed
{
    $config = $GLOBALS['app_config'] ?? [];

    if ($key === null || $key === '') {
        return $config;
    }

    $segments = explode('.', $key);
    $value = $config;

    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }

        $value = $value[$segment];
    }

    return $value;
}

function app_url(string $path = ''): string
{
    $baseUrl = rtrim((string) config('base_url', '/'), '/');
    $sanitizedPath = ltrim($path, '/');

    if ($baseUrl === '') {
        return '/' . $sanitizedPath;
    }

    return $baseUrl . ($sanitizedPath !== '' ? '/' . $sanitizedPath : '');
}

function asset(string $path): string
{
    return app_url('assets/' . ltrim($path, '/'));
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }

    if (!isset($_SESSION['_flash'][$key])) {
        return null;
    }

    $value = $_SESSION['_flash'][$key];
    unset($_SESSION['_flash'][$key]);

    return $value;
}

function old(string $key, string $default = ''): string
{
    return (string) ($_SESSION['_old'][$key] ?? $default);
}

function current_user(): ?array
{
    return $_SESSION['auth_user'] ?? null;
}

function is_authenticated(): bool
{
    return current_user() !== null;
}

function has_role(array|string $roles): bool
{
    $user = current_user();

    if ($user === null) {
        return false;
    }

    $roles = is_array($roles) ? $roles : [$roles];

    return in_array($user['role'] ?? null, $roles, true);
}

function age_from_birth_date(string $birthDate): int
{
    $now = new DateTimeImmutable('now');
    $date = new DateTimeImmutable($birthDate);

    return (int) $date->diff($now)->y;
}
