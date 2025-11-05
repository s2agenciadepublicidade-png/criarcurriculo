<?php

namespace App\Models;

use App\Support\Database;
use PDO;

class Resume
{
    public static function create(array $data): int
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO resumes (user_id, title, data_json, template, color_scheme, created_at, updated_at) VALUES (:user_id, :title, :data_json, :template, :color_scheme, :created_at, :updated_at)');
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':title' => $data['title'],
            ':data_json' => $data['data_json'],
            ':template' => $data['template'],
            ':color_scheme' => $data['color_scheme'],
            ':created_at' => date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s'),
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, int $userId, array $data): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('UPDATE resumes SET title = :title, data_json = :data_json, template = :template, color_scheme = :color_scheme, updated_at = :updated_at WHERE id = :id AND user_id = :user_id');
        $stmt->execute([
            ':title' => $data['title'],
            ':data_json' => $data['data_json'],
            ':template' => $data['template'],
            ':color_scheme' => $data['color_scheme'],
            ':updated_at' => date('Y-m-d H:i:s'),
            ':id' => $id,
            ':user_id' => $userId,
        ]);
    }

    public static function find(int $id, int $userId): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM resumes WHERE id = :id AND user_id = :user_id LIMIT 1');
        $stmt->execute([':id' => $id, ':user_id' => $userId]);
        $resume = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resume ?: null;
    }

    public static function allByUser(int $userId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM resumes WHERE user_id = :user_id ORDER BY updated_at DESC');
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete(int $id, int $userId): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('DELETE FROM resumes WHERE id = :id AND user_id = :user_id');
        $stmt->execute([':id' => $id, ':user_id' => $userId]);
    }

    public static function duplicate(int $id, int $userId): ?int
    {
        $resume = self::find($id, $userId);
        if (!$resume) {
            return null;
        }
        $newTitle = $resume['title'] . ' (cópia)';
        return self::create([
            'user_id' => $userId,
            'title' => $newTitle,
            'data_json' => $resume['data_json'],
            'template' => $resume['template'],
            'color_scheme' => $resume['color_scheme'],
        ]);
    }
}
