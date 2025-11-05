<?php
declare(strict_types=1);

session_start();

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
}

$config = require __DIR__ . '/../config/config.php';
date_default_timezone_set($config['app']['timezone'] ?? 'UTC');

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

$routes = [
    'GET' => [
        '/' => [App\Controllers\HomeController::class, 'index'],
        '/register' => [App\Controllers\AuthController::class, 'showRegister'],
        '/login' => [App\Controllers\AuthController::class, 'showLogin'],
        '/forgot-password' => [App\Controllers\AuthController::class, 'showForgotPassword'],
        '/reset-password' => [App\Controllers\AuthController::class, 'showResetPassword'],
        '/dashboard' => [App\Controllers\DashboardController::class, 'index'],
        '/resume/new' => [App\Controllers\ResumeController::class, 'create'],
        '/resume/(\d+)/edit' => [App\Controllers\ResumeController::class, 'edit'],
        '/resume/(\d+)/preview' => [App\Controllers\ResumeController::class, 'preview'],
        '/resume/(\d+)/export-pdf' => [App\Controllers\ResumeController::class, 'exportPdf'],
        '/share/whatsapp/(\d+)' => [App\Controllers\ResumeController::class, 'whatsapp'],
    ],
    'POST' => [
        '/register' => [App\Controllers\AuthController::class, 'register'],
        '/login' => [App\Controllers\AuthController::class, 'login'],
        '/logout' => [App\Controllers\AuthController::class, 'logout'],
        '/forgot-password' => [App\Controllers\AuthController::class, 'sendResetLink'],
        '/reset-password' => [App\Controllers\AuthController::class, 'resetPassword'],
        '/resume/save-step' => [App\Controllers\ResumeController::class, 'saveStep'],
        '/resume/(\d+)/send-email' => [App\Controllers\ResumeController::class, 'sendEmail'],
        '/resume/(\d+)/duplicate' => [App\Controllers\ResumeController::class, 'duplicate'],
        '/resume/(\d+)/delete' => [App\Controllers\ResumeController::class, 'delete'],
    ],
];

function dispatch(string $method, string $uri, array $routes)
{
    if (!isset($routes[$method])) {
        http_response_code(405);
        echo 'Método não permitido';
        return;
    }

    foreach ($routes[$method] as $pattern => $handler) {
        $regex = '#^' . $pattern . '$#';
        if (preg_match($regex, $uri, $matches)) {
            array_shift($matches);
            [$class, $action] = $handler;
            $controller = new $class();
            if ($matches) {
                $params = [];
                if (strpos($pattern, '(') !== false) {
                    // map numeric captures to named parameter 'id'
                    $params['id'] = $matches[0];
                }
                return $controller->$action($params);
            }
            return $controller->$action();
        }
    }

    http_response_code(404);
    echo 'Página não encontrada';
}

dispatch($method, rtrim($uri, '/') ?: '/', $routes);
