<?php

namespace App\Controllers;

class BaseController
{
    protected function render(string $view, array $params = [], ?string $layout = 'main')
    {
        extract($params, EXTR_OVERWRITE);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View {$view} not found");
        }
        if ($layout === null) {
            include $viewFile;
            return;
        }
        $layoutFile = __DIR__ . '/../Views/layouts/' . $layout . '.php';
        if (!file_exists($layoutFile)) {
            throw new \RuntimeException("Layout {$layout} not found");
        }
        ob_start();
        include $viewFile;
        $content = ob_get_clean();
        include $layoutFile;
    }

    protected function redirect(string $path)
    {
        header('Location: ' . $path);
        exit;
    }
}
