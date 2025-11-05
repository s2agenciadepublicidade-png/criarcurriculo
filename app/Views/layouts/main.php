<?php
use App\Support\Auth;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Criar Currículo'); ?></title>
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <script type="module" src="/assets/js/app.js" defer></script>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">
<header class="bg-white shadow-sm">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="/" class="text-xl font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-500">Criar Currículo</a>
        <nav class="flex items-center gap-4">
            <?php if (Auth::check()): ?>
                <a href="/dashboard" class="text-sm font-medium text-slate-600 hover:text-primary-600">Painel</a>
                <form action="/logout" method="post" class="inline">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(App\Support\Csrf::token()); ?>">
                    <button type="submit" class="px-3 py-1.5 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">Sair</button>
                </form>
            <?php else: ?>
                <a href="/login" class="text-sm font-medium text-slate-600 hover:text-primary-600">Entrar</a>
                <a href="/register" class="px-3 py-1.5 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">Começar</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="py-10">
    <div class="max-w-6xl mx-auto px-4">
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-xl px-4 py-3 mb-6 text-sm" role="alert" data-autodismiss="6000">
                <?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="bg-red-100 text-red-800 border border-red-300 rounded-xl px-4 py-3 mb-6 text-sm" role="alert" data-autodismiss="6000">
                <?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
            </div>
        <?php endif; ?>
        <?= $content; ?>
    </div>
</main>
<footer class="border-t border-slate-200 py-6 mt-12 text-sm text-slate-500">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <p>&copy; <?= date('Y'); ?> Criar Currículo. Todos os direitos reservados.</p>
        <div class="flex gap-4">
            <a href="#" class="hover:text-primary-600">Termos</a>
            <a href="#" class="hover:text-primary-600">Privacidade</a>
            <a href="mailto:contato@example.com" class="hover:text-primary-600">Suporte</a>
        </div>
    </div>
</footer>
</body>
</html>
