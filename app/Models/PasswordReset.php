<?php

namespace App\Models;

use App\Support\Database;
use PDO;

class PasswordReset
{
    public static function create(int $userId, string $token, string $expiresAt): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO password_resets (user_id, token, expires_at, created_at) VALUES (:user_id, :token, :expires_at, :created_at)');
        $stmt->execute([
            ':user_id' => $userId,
            ':token' => $token,
            ':expires_at' => $expiresAt,
            ':created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function findValid(string $token): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = :token AND expires_at > :now LIMIT 1');
        $stmt->execute([
            ':token' => $token,
            ':now' => date('Y-m-d H:i:s'),
        ]);
        $reset = $stmt->fetch(PDO::FETCH_ASSOC);
        return $reset ?: null;
    }

    public static function deleteByUser(int $userId): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('DELETE FROM password_resets WHERE user_id = :user_id');
        $stmt->execute([':user_id' => $userId]);
    }
}
