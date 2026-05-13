<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

final class Child extends Model
{
    protected string $table = 'children';

    public function createChild(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->create($data);
    }

    public function updateChild(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }

    public function getProgress(int $childId): array
    {
        $stmt = $this->query(
            'SELECT cp.*, g.title as game_title, gl.title as level_title, gp.title as phase_title
             FROM child_progress cp
             LEFT JOIN games g ON cp.game_id = g.id
             LEFT JOIN game_levels gl ON cp.game_level_id = gl.id
             LEFT JOIN game_phases gp ON cp.phase_id = gp.id
             WHERE cp.child_id = ?
             ORDER BY cp.created_at DESC',
            [$childId]
        );
        return $stmt->fetchAll();
    }

    public function getAchievements(int $childId): array
    {
        $stmt = $this->query(
            'SELECT ca.*, a.title, a.description, a.icon, a.reward_coins, a.reward_stars
             FROM child_achievements ca
             JOIN achievements a ON ca.achievement_id = a.id
             WHERE ca.child_id = ?
             ORDER BY ca.unlocked_at DESC',
            [$childId]
        );
        return $stmt->fetchAll();
    }
}