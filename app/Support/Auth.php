<?php

namespace App\Support;

use App\Models\User;

class Auth
{
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function attempt(string $email, string $password): bool
    {
        $user = User::findByEmail($email);
        if (!$user) {
            return false;
        }
        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ];
        return true;
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
    }
}
