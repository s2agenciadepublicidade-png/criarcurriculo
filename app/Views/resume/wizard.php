<?php
$defaults = [
    'personal' => [
        'full_name' => '', 'phone' => '', 'email' => '', 'location' => '', 'linkedin' => '', 'portfolio' => ''
    ],
    'objective' => '',
    'summary' => '',
    'experiences' => [],
    'education' => [],
    'courses' => [],
    'skills' => ['hard' => [], 'soft' => []],
    'projects' => [],
    'languages' => [],
    'volunteer' => [],
    'preferences' => ['template' => $resume['template'] ?? 'classico', 'color' => $resume['color_scheme'] ?? 'azul', 'title' => $resume['title'] ?? 'Currículo profissional'],
];
$formData = array_replace_recursive($defaults, $formData ?? []);
$microcopy = include __DIR__ . '/../../support/microcopy.php';
?>
<section class="bg-white shadow rounded-2xl border border-slate-200">
    <header class="px-6 py-5 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Assistente de currículos</h1>
            <p class="text-sm text-slate-600">Avance no seu ritmo. O progresso é salvo automaticamente.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="11" aria-valuenow="1">
                <div class="progress-bar" id="wizard-progress"></div>
            </div>
            <span class="text-sm text-slate-600" id="wizard-step-label">Etapa 1 de 11</span>
        </div>
    </header>
    <form id="resume-form" class="p-6 space-y-8" novalidate data-autosave-endpoint="/resume/save-step">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken); ?>">
        <input type="hidden" id="resume-id" value="<?= htmlspecialchars($resume['id'] ?? ''); ?>">
        <input type="hidden" id="autosave-title" value="<?= htmlspecialchars($formData['preferences']['title']); ?>">
        <input type="hidden" id="autosave-template" value="<?= htmlspecialchars($formData['preferences']['template']); ?>">
        <input type="hidden" id="autosave-color" value="<?= htmlspecialchars($formData['preferences']['color']); ?>">
        <div class="wizard" role="group" aria-labelledby="wizard-step-label">
            <?php include __DIR__ . '/wizard-steps.php'; ?>
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pt-4 border-t border-slate-200">
            <div class="text-sm text-slate-500" id="wizard-tip">Dica do recrutador: <?= htmlspecialchars($microcopy['tips']['personal']); ?></div>
            <div class="flex gap-3">
                <button type="button" class="btn btn-light" id="btn-prev">Voltar</button>
                <button type="button" class="btn btn-secondary" id="btn-generate-bullet">Gerar bullet de impacto</button>
                <button type="button" class="btn btn-primary" id="btn-next">Avançar etapa</button>
            </div>
        </div>
    </form>
</section>
<script>
window.MICROCOPY = <?= json_encode($microcopy, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
</script>
<section class="mt-8 grid gap-6 md:grid-cols-2">
    <article class="card">
        <h2 class="card-title">Sugestões rápidas por área</h2>
        <ul class="list-disc list-inside text-sm text-slate-600 space-y-2">
            <?php foreach ($microcopy['objectives'] as $area => $text): ?>
                <li><strong><?= htmlspecialchars($area); ?>:</strong> <?= htmlspecialchars($text); ?></li>
            <?php endforeach; ?>
        </ul>
    </article>
    <article class="card">
        <h2 class="card-title">Resultados de impacto</h2>
        <ul class="list-disc list-inside text-sm text-slate-600 space-y-2">
            <?php foreach ($microcopy['results'] as $text): ?>
                <li><?= htmlspecialchars($text); ?></li>
            <?php endforeach; ?>
        </ul>
    </article>
</section>
