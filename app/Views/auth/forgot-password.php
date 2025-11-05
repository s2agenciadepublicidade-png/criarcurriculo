<section class="max-w-md mx-auto bg-white shadow rounded-2xl p-8">
    <h1 class="text-2xl font-semibold text-slate-900">Recuperar senha</h1>
    <p class="text-sm text-slate-600 mt-1">Informe seu e-mail e enviaremos um link seguro de redefinição.</p>
    <?php if (!empty($status)): ?><p class="mt-4 text-sm text-emerald-600"><?= htmlspecialchars($status); ?></p><?php endif; ?>
    <form action="/forgot-password" method="post" class="mt-6 space-y-5">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken); ?>">
        <label class="block">
            <span class="form-label">E-mail cadastrado</span>
            <input type="email" name="email" class="form-input" required>
        </label>
        <button type="submit" class="btn btn-primary w-full">Enviar instruções</button>
    </form>
    <p class="mt-4 text-sm text-center text-slate-600">Lembrou sua senha? <a href="/login" class="text-primary-600 font-medium">Voltar para login</a></p>
</section>
