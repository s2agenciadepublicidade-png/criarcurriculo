<?php

namespace App\Support;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $config = require __DIR__ . '/../../config/config.php';
        $db = $config['db'];

        try {
            if ($db['driver'] === 'sqlite') {
                $dsn = 'sqlite:' . $db['database'];
                self::$pdo = new PDO($dsn);
            } else {
                $dsn = sprintf(
                    '%s:host=%s;port=%s;dbname=%s;charset=%s',
                    $db['driver'],
                    $db['host'],
                    $db['port'],
                    $db['database'],
                    $db['charset']
                );
                self::$pdo = new PDO($dsn, $db['username'], $db['password']);
            }
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException('Database connection failed: ' . $e->getMessage(), (int) $e->getCode());
        }

        return self::$pdo;
    }
}
