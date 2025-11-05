<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Pré-visualização'); ?></title>
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <script type="module" src="/assets/js/preview.js" defer></script>
</head>
<body class="bg-slate-100">
<div class="min-h-screen flex flex-col">
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-slate-900">Pré-visualização</h1>
                <p class="text-sm text-slate-500">Escolha o modelo, exporte em PDF ou compartilhe.</p>
            </div>
            <div class="flex gap-2">
                <a href="/resume/<?= $resume['id']; ?>/export-pdf?template=<?= urlencode($template); ?>" class="btn btn-primary">Baixar PDF</a>
                <a href="/share/whatsapp/<?= $resume['id']; ?>" class="btn btn-secondary" target="_blank" rel="noopener">Enviar WhatsApp</a>
                <button data-dialog="email" class="btn btn-light">Enviar por e-mail</button>
            </div>
        </div>
    </header>
    <main class="flex-1">
        <div class="max-w-6xl mx-auto px-4 py-8 grid gap-6 lg:grid-cols-[2fr_1fr]">
            <?php if (!empty($_SESSION['flash_success'])): ?>
                <div class="lg:col-span-2 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-xl px-4 py-3 text-sm" role="alert" data-autodismiss="6000">
                    <?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['flash_error'])): ?>
                <div class="lg:col-span-2 bg-red-100 text-red-800 border border-red-300 rounded-xl px-4 py-3 text-sm" role="alert" data-autodismiss="6000">
                    <?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
                </div>
            <?php endif; ?>
            <section class="bg-white shadow rounded-lg p-6 overflow-auto" aria-label="Pré-visualização do currículo">
                <?= $content; ?>
            </section>
            <aside class="space-y-6">
                <section class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-base font-semibold text-slate-900">Modelos</h2>
                    <p class="text-sm text-slate-500">Visualize como o currículo se adapta a cada formato.</p>
                    <div class="mt-4 flex flex-col gap-2">
                        <?php foreach (['classico' => 'Clássico', 'minimalista' => 'Minimalista', 'lateral' => 'Barra Lateral', 'criativo' => 'Criativo', 'tech' => 'Tech/Design'] as $key => $label): ?>
                            <a class="btn <?= $template === $key ? 'btn-primary' : 'btn-light'; ?>" href="/resume/<?= $resume['id']; ?>/preview?template=<?= $key; ?>">Modelo <?= $label; ?></a>
                        <?php endforeach; ?>
                    </div>
                </section>
                <section class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-base font-semibold text-slate-900">Checklist final</h2>
                    <ul class="mt-3 space-y-2 text-sm text-slate-600">
                        <li>✔ Revise ortografia e gramática.</li>
                        <li>✔ Verifique datas em ordem decrescente.</li>
                        <li>✔ Utilize métricas e verbos fortes.</li>
                        <li>✔ Garanta contatos atualizados.</li>
                        <li>✔ Personalize objetivo para a vaga.</li>
                    </ul>
                </section>
            </aside>
        </div>
    </main>
</div>
<div id="email-dialog" class="dialog" hidden>
    <div class="dialog-backdrop" data-close></div>
    <div class="dialog-card" role="dialog" aria-modal="true" aria-labelledby="email-dialog-title">
        <form action="/resume/<?= $resume['id']; ?>/send-email" method="post" class="space-y-4">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(App\Support\Csrf::token()); ?>">
            <h2 id="email-dialog-title" class="text-lg font-semibold text-slate-900">Enviar por e-mail</h2>
            <p class="text-sm text-slate-600">Preencha os dados e enviaremos o currículo anexado.</p>
            <?php if (!empty($_SESSION['flash_error'])): ?>
                <p class="text-sm text-red-600"><?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></p>
            <?php elseif (!empty($_SESSION['flash_success'])): ?>
                <p class="text-sm text-emerald-600"><?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></p>
            <?php endif; ?>
            <label class="block">
                <span class="form-label">Destinatário</span>
                <input type="email" name="to" class="form-input" required placeholder="exemplo@empresa.com">
            </label>
            <label class="block">
                <span class="form-label">Assunto</span>
                <input type="text" name="subject" class="form-input" value="Meu currículo atualizado" required>
            </label>
            <label class="block">
                <span class="form-label">Mensagem</span>
                <textarea name="message" rows="4" class="form-textarea">Olá! Segue meu currículo atualizado em anexo.
Obrigado pelo retorno.</textarea>
            </label>
            <div class="flex justify-end gap-2">
                <button type="button" data-close class="btn btn-light">Cancelar</button>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
