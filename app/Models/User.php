<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

final class User extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        return $this->findBy(['email' => $email]);
    }

    public function createUser(array $data): int
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->create($data);
    }

    public function updateUser(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }

    public function getChildren(int $userId): array
    {
        $stmt = $this->query(
            'SELECT * FROM children WHERE user_id = ? ORDER BY name',
            [$userId]
        );
        return $stmt->fetchAll();
    }
}