<section class="max-w-md mx-auto bg-white shadow rounded-2xl p-8">
    <h1 class="text-2xl font-semibold text-slate-900">Entrar</h1>
    <p class="text-sm text-slate-600 mt-1">Retome suas versões e continue de onde parou.</p>
    <form action="/login" method="post" class="mt-6 space-y-5">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken); ?>">
        <?php if (!empty($errors['credentials'])): ?><p class="form-error"><?= htmlspecialchars($errors['credentials']); ?></p><?php endif; ?>
        <label class="block">
            <span class="form-label">E-mail</span>
            <input type="email" name="email" class="form-input" value="<?= htmlspecialchars($old['email'] ?? ''); ?>" required autocomplete="email">
        </label>
        <label class="block">
            <span class="form-label">Senha</span>
            <input type="password" name="password" class="form-input" required autocomplete="current-password">
        </label>
        <button type="submit" class="btn btn-primary w-full">Acessar painel</button>
    </form>
    <div class="mt-4 text-sm text-center text-slate-600">
        <a href="/forgot-password" class="text-primary-600 font-medium">Esqueci minha senha</a>
    </div>
    <p class="mt-4 text-sm text-center text-slate-600">Ainda não tem conta? <a href="/register" class="text-primary-600 font-medium">Cadastre-se</a></p>
</section>
