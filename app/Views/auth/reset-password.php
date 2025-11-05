<section class="max-w-md mx-auto bg-white shadow rounded-2xl p-8">
    <h1 class="text-2xl font-semibold text-slate-900">Definir nova senha</h1>
    <p class="text-sm text-slate-600 mt-1">Crie uma senha forte para proteger seus currículos.</p>
    <?php if (!empty($status)): ?><p class="mt-4 text-sm text-emerald-600"><?= htmlspecialchars($status); ?></p><?php endif; ?>
    <form action="/reset-password" method="post" class="mt-6 space-y-5">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken); ?>">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? $_GET['token'] ?? ''); ?>">
        <label class="block">
            <span class="form-label">Nova senha</span>
            <input type="password" name="password" class="form-input" required>
            <?php if (!empty($errors['password'])): ?><span class="form-error"><?= htmlspecialchars($errors['password']); ?></span><?php endif; ?>
        </label>
        <?php if (!empty($errors['token'])): ?><p class="form-error"><?= htmlspecialchars($errors['token']); ?></p><?php endif; ?>
        <button type="submit" class="btn btn-primary w-full">Salvar nova senha</button>
    </form>
</section>
