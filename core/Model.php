<?php

declare(strict_types=1);

namespace Core;

use PDO;
use PDOStatement;

abstract class Model
{
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function findBy(array $conditions): ?array
    {
        $where = [];
        $values = [];

        foreach ($conditions as $column => $value) {
            $where[] = "{$column} = ?";
            $values[] = $value;
        }

        $whereClause = implode(' AND ', $where);
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$whereClause} LIMIT 1");
        $stmt->execute($values);
        return $stmt->fetch() ?: null;
    }

    public function findAll(array $conditions = []): array
    {
        $where = '';
        $values = [];

        if (!empty($conditions)) {
            $whereParts = [];
            foreach ($conditions as $column => $value) {
                $whereParts[] = "{$column} = ?";
                $values[] = $value;
            }
            $where = ' WHERE ' . implode(' AND ', $whereParts);
        }

        $stmt = $this->db->prepare("SELECT * FROM {$this->table}{$where}");
        $stmt->execute($values);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = str_repeat('?,', count($columns) - 1) . '?';

        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ") VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $set = [];
        $values = [];

        foreach ($data as $column => $value) {
            $set[] = "{$column} = ?";
            $values[] = $value;
        }

        $values[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(',', $set) . " WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($values);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }

    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}