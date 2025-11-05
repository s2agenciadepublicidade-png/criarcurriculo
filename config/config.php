<?php
return [
    'db' => [
        'driver' => env('DB_DRIVER', 'sqlite'),
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_NAME', __DIR__ . '/../storage/database.sqlite'),
        'username' => env('DB_USER', 'root'),
        'password' => env('DB_PASS', ''),
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'base_url' => env('APP_URL', 'http://localhost:8000'),
        'name' => 'Criar Currículo',
        'timezone' => env('APP_TIMEZONE', 'America/Sao_Paulo'),
        'locale' => 'pt_BR',
    ],
    'mail' => [
        'host' => env('MAIL_HOST', 'smtp.example.com'),
        'port' => env('MAIL_PORT', 587),
        'username' => env('MAIL_USER', ''),
        'password' => env('MAIL_PASS', ''),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        'from_address' => env('MAIL_FROM_ADDRESS', 'no-reply@example.com'),
        'from_name' => env('MAIL_FROM_NAME', 'Criar Currículo'),
    ],
];

function env(string $key, $default = null)
{
    $value = getenv($key);
    if ($value === false) {
        return $default;
    }
    return $value;
}
