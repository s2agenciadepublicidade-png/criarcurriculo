<?php
$data = $data ?? [];
$personal = $data['personal'] ?? [];
$objective = $data['objective'] ?? '';
$summary = $data['summary'] ?? '';
$experiences = $data['experiences'] ?? [];
$education = $data['education'] ?? [];
$courses = $data['courses'] ?? [];
$skills = $data['skills'] ?? ['hard' => [], 'soft' => []];
$projects = $data['projects'] ?? [];
$languages = $data['languages'] ?? [];
$volunteer = $data['volunteer'] ?? [];
$color = $resume['color_scheme'] ?? 'azul';
$palette = [
    'azul' => '#1d4ed8',
    'verde' => '#047857',
    'vinho' => '#7f1d1d',
    'grafite' => '#1f2937',
    'cobalto' => '#1e3a8a',
];
$accent = $palette[$color] ?? '#1d4ed8';
?>
<style>
.resume { font-family: 'Calibri', 'Segoe UI', sans-serif; color: #0f172a; }
.resume h1 { font-size: 28px; margin-bottom: 4px; }
.resume h2 { font-size: 16px; letter-spacing: 0.05em; text-transform: uppercase; color: <?= $accent; ?>; margin-bottom: 8px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; }
.resume .section { margin-bottom: 18px; }
.resume ul { padding-left: 18px; margin: 8px 0; }
.resume li { margin-bottom: 4px; }
.resume .meta { font-size: 13px; color: #475569; }
.resume .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
</style>
<div class="resume">
    <header class="section">
        <h1><?= htmlspecialchars($personal['full_name'] ?? $resume['title']); ?></h1>
        <p class="meta">
            <?= htmlspecialchars($objective ?: $summary ?: ''); ?>
        </p>
        <p class="meta">
            <?= htmlspecialchars($personal['phone'] ?? ''); ?> · <?= htmlspecialchars($personal['email'] ?? ''); ?> · <?= htmlspecialchars($personal['location'] ?? ''); ?>
            <?php if (!empty($personal['linkedin'])): ?> · <a href="<?= htmlspecialchars($personal['linkedin']); ?>" class="text-link">LinkedIn</a><?php endif; ?>
            <?php if (!empty($personal['portfolio'])): ?> · <a href="<?= htmlspecialchars($personal['portfolio']); ?>" class="text-link">Portfólio</a><?php endif; ?>
        </p>
    </header>
    <?php if ($summary): ?>
        <section class="section">
            <h2>Resumo profissional</h2>
            <p><?= nl2br(htmlspecialchars($summary)); ?></p>
        </section>
    <?php endif; ?>
    <?php if ($experiences): ?>
        <section class="section">
            <h2>Experiências</h2>
            <?php foreach ($experiences as $exp): ?>
                <article class="mb-4">
                    <h3 class="font-semibold text-base text-slate-900"><?= htmlspecialchars(($exp['role'] ?? '') . ' · ' . ($exp['company'] ?? '')); ?></h3>
                    <p class="meta"><?= htmlspecialchars(($exp['period'] ?? '') . ' · ' . ($exp['location'] ?? '')); ?></p>
                    <?php if (!empty($exp['responsibilities'])): ?>
                        <ul>
                            <?php foreach (preg_split('/\r?\n/', $exp['responsibilities']) as $item): if (trim($item) === '') continue; ?>
                                <li><?= htmlspecialchars($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if (!empty($exp['results'])): ?>
                        <p class="meta">Resultado: <?= htmlspecialchars($exp['results']); ?></p>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
    <?php if ($education): ?>
        <section class="section">
            <h2>Formação acadêmica</h2>
            <?php foreach ($education as $edu): ?>
                <p><strong><?= htmlspecialchars($edu['course'] ?? ''); ?></strong> · <?= htmlspecialchars($edu['institution'] ?? ''); ?> (<?= htmlspecialchars($edu['status'] ?? ''); ?> - <?= htmlspecialchars($edu['year'] ?? ''); ?>)</p>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
    <?php if ($courses): ?>
        <section class="section">
            <h2>Cursos & Certificações</h2>
            <ul>
                <?php foreach ($courses as $course): ?>
                    <li><?= htmlspecialchars(($course['name'] ?? '') . ' · ' . ($course['institution'] ?? '') . ' (' . ($course['hours'] ?? '') . ')'); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>
    <?php if (!empty($skills['hard']) || !empty($skills['soft'])): ?>
        <section class="section">
            <h2>Habilidades</h2>
            <div class="two-col">
                <div>
                    <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Hard skills</h3>
                    <ul>
                        <?php foreach ($skills['hard'] as $skill): ?>
                            <li><?= htmlspecialchars(($skill['name'] ?? '') . ' · ' . ($skill['level'] ?? '')); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Soft skills</h3>
                    <ul>
                        <?php foreach ($skills['soft'] as $skill): ?>
                            <li><?= htmlspecialchars(($skill['name'] ?? '') . ' · ' . ($skill['level'] ?? '')); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if ($projects): ?>
        <section class="section">
            <h2>Projetos</h2>
            <?php foreach ($projects as $project): ?>
                <p><strong><?= htmlspecialchars($project['title'] ?? ''); ?></strong> — <?= htmlspecialchars($project['description'] ?? ''); ?> <?php if (!empty($project['link'])): ?><a href="<?= htmlspecialchars($project['link']); ?>" class="text-link">Ver projeto</a><?php endif; ?></p>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
    <?php if ($languages): ?>
        <section class="section">
            <h2>Idiomas</h2>
            <ul>
                <?php foreach ($languages as $language): ?>
                    <li><?= htmlspecialchars(($language['name'] ?? '') . ' · ' . ($language['level'] ?? '')); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>
    <?php if ($volunteer): ?>
        <section class="section">
            <h2>Atividades complementares</h2>
            <?php foreach ($volunteer as $item): ?>
                <p><strong><?= htmlspecialchars($item['name'] ?? ''); ?></strong> — <?= htmlspecialchars($item['description'] ?? ''); ?></p>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</div>
