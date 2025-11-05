<section class="space-y-8">
    <header class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Olá, <?= htmlspecialchars($user['name']); ?>!</h1>
            <p class="text-slate-600 mt-2">Aqui estão seus currículos com autosave. Crie novos, edite versões e compartilhe.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="/resume/new" class="btn btn-primary">Criar novo currículo</a>
            <a href="/resume/<?= $resumes[0]['id'] ?? 'new'; ?>/edit" class="btn btn-secondary"<?= empty($resumes) ? ' aria-disabled="true" tabindex="-1"' : ''; ?>>Retomar edição</a>
            <a href="/resume/<?= $resumes[0]['id'] ?? 'new'; ?>/preview" class="btn btn-light"<?= empty($resumes) ? ' aria-disabled="true" tabindex="-1"' : ''; ?>>Pré-visualizar</a>
        </div>
    </header>
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4" aria-label="Ações rápidas">
        <article class="card">
            <h2 class="card-title">Assistente guiado</h2>
            <p class="card-text">Complete 11 etapas com dicas sob medida, salvamento automático e validações amigáveis.</p>
            <a href="/resume/new" class="link">Iniciar wizard</a>
        </article>
        <article class="card">
            <h2 class="card-title">Versões salvas</h2>
            <p class="card-text">Duplique currículos para variar objetivos, mude templates em segundos.</p>
            <a href="#curriculos" class="link">Ver minhas versões</a>
        </article>
        <article class="card">
            <h2 class="card-title">Compartilhe rápido</h2>
            <p class="card-text">Gere links prontos para WhatsApp ou envie por e-mail com mensagem personalizada.</p>
            <a href="#" class="link">Modelos de mensagem</a>
        </article>
        <article class="card">
            <h2 class="card-title">Olhar de recrutador</h2>
            <p class="card-text">Checklist de impacto para revisar métricas, palavras-chave e consistência.</p>
            <a href="/resume/new" class="link">Aplicar dicas</a>
        </article>
    </section>
    <section id="curriculos" class="bg-white shadow rounded-2xl border border-slate-200">
        <div class="px-6 py-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Meus currículos</h2>
                <p class="text-sm text-slate-600">Gerencie, duplique ou remova versões antigas.</p>
            </div>
            <form action="/resume/new" method="get" class="flex gap-3">
                <input type="search" name="q" placeholder="Buscar por título" class="form-input" aria-label="Buscar currículos">
                <button type="submit" class="btn btn-secondary">Buscar</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200" role="grid">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="table-head">Título</th>
                        <th scope="col" class="table-head">Template</th>
                        <th scope="col" class="table-head">Atualizado em</th>
                        <th scope="col" class="table-head">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php if (empty($resumes)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-sm text-slate-500">Ainda não há currículos salvos. Comece um novo clicando em “Criar novo currículo”.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($resumes as $resume): ?>
                            <tr>
                                <td class="table-cell">
                                    <span class="font-medium text-slate-900"><?= htmlspecialchars($resume['title']); ?></span>
                                </td>
                                <td class="table-cell capitalize"><?= htmlspecialchars($resume['template']); ?></td>
                                <td class="table-cell"><?= date('d/m/Y H:i', strtotime($resume['updated_at'] ?? $resume['created_at'])); ?></td>
                                <td class="table-cell">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="/resume/<?= $resume['id']; ?>/edit" class="btn btn-light btn-sm">Editar</a>
                                        <a href="/resume/<?= $resume['id']; ?>/preview" class="btn btn-secondary btn-sm">Prévia</a>
                                        <a href="/share/whatsapp/<?= $resume['id']; ?>" class="btn btn-light btn-sm" target="_blank" rel="noopener">WhatsApp</a>
                                        <form action="/resume/<?= $resume['id']; ?>/duplicate" method="post" class="inline">
                                            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken); ?>">
                                            <button class="btn btn-light btn-sm" type="submit">Duplicar</button>
                                        </form>
                                        <form action="/resume/<?= $resume['id']; ?>/delete" method="post" class="inline" onsubmit="return confirm('Deseja realmente excluir este currículo?');">
                                            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken); ?>">
                                            <button class="btn btn-danger btn-sm" type="submit">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</section>
