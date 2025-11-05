<section class="max-w-2xl mx-auto bg-white shadow rounded-2xl p-8">
    <h1 class="text-2xl font-semibold text-slate-900">Crie sua conta</h1>
    <p class="text-sm text-slate-600 mt-1">Responda às etapas com tranquilidade e acompanhe versões futuras do seu currículo.</p>
    <form action="/register" method="post" class="mt-6 space-y-5">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken); ?>">
        <label class="block">
            <span class="form-label">Nome completo</span>
            <input type="text" name="name" class="form-input" value="<?= htmlspecialchars($old['name'] ?? ''); ?>" required autocomplete="name">
            <?php if (!empty($errors['name'])): ?><span class="form-error"><?= htmlspecialchars($errors['name']); ?></span><?php endif; ?>
        </label>
        <label class="block">
            <span class="form-label">E-mail</span>
            <input type="email" name="email" class="form-input" value="<?= htmlspecialchars($old['email'] ?? $_GET['email'] ?? ''); ?>" required autocomplete="email">
            <?php if (!empty($errors['email'])): ?><span class="form-error"><?= htmlspecialchars($errors['email']); ?></span><?php endif; ?>
        </label>
        <label class="block">
            <span class="form-label">Senha</span>
            <input type="password" name="password" class="form-input" required aria-describedby="password-hint" autocomplete="new-password">
            <span id="password-hint" class="text-xs text-slate-500">Use letras maiúsculas, minúsculas e números para aumentar a força.</span>
            <?php if (!empty($errors['password'])): ?><span class="form-error"><?= htmlspecialchars($errors['password']); ?></span><?php endif; ?>
        </label>
        <label class="flex items-start gap-3">
            <input type="checkbox" name="terms" class="mt-1" value="1" <?= !empty($terms) ? 'checked' : ''; ?> required>
            <span class="text-sm text-slate-600">Concordo com os <a href="#" class="text-primary-600 underline">termos de uso</a> e políticas de privacidade.</span>
            <?php if (!empty($errors['terms'])): ?><span class="form-error"><?= htmlspecialchars($errors['terms']); ?></span><?php endif; ?>
        </label>
        <button type="submit" class="btn btn-primary w-full">Criar conta</button>
    </form>
    <p class="mt-4 text-sm text-center text-slate-600">Já possui conta? <a href="/login" class="text-primary-600 font-medium">Entrar</a></p>
</section>
