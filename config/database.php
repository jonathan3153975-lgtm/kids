<?php

declare(strict_types=1);

return [
    'database' => [
        'host' => 'localhost',
        'port' => 3306,
        'database' => 'kidsystem',
        'username' => 'root',
        'password' => 'YSara6a9u',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],
    'jwt' => [
        'secret' => 'your-super-secret-jwt-key-change-this-in-production',
        'algorithm' => 'HS256',
        'expires_in' => 3600, // 1 hour
        'refresh_expires_in' => 604800, // 7 days
    ],
];