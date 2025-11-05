<?php
include __DIR__ . '/shared.php';
?>
<div class="template minimalista" data-color="<?= htmlspecialchars($accent); ?>">
    <header class="header">
        <div>
            <h1><?= htmlspecialchars($personal['full_name'] ?? $resume['title']); ?></h1>
            <?php if ($objective): ?><p class="headline"><?= htmlspecialchars($objective); ?></p><?php endif; ?>
            <p class="contacts">
                <?= htmlspecialchars($personal['email'] ?? ''); ?> · <?= htmlspecialchars($personal['phone'] ?? ''); ?> · <?= htmlspecialchars($personal['location'] ?? ''); ?>
            </p>
        </div>
        <div class="links">
            <?php if (!empty($personal['linkedin'])): ?><a href="<?= htmlspecialchars($personal['linkedin']); ?>">LinkedIn</a><?php endif; ?>
            <?php if (!empty($personal['portfolio'])): ?><a href="<?= htmlspecialchars($personal['portfolio']); ?>">Portfólio</a><?php endif; ?>
        </div>
    </header>
    <main class="content">
        <?php section('Resumo', $summary ? '<p>' . nl2br(htmlspecialchars($summary)) . '</p>' : null); ?>
        <?php section('Experiências', render_experiences($experiences)); ?>
        <div class="grid">
            <?php section('Formação', render_list($education, fn($item) => '<strong>' . htmlspecialchars($item['course'] ?? '') . '</strong><span>' . htmlspecialchars(($item['institution'] ?? '') . ' · ' . ($item['status'] ?? '') . ' · ' . ($item['year'] ?? '')) . '</span>')); ?>
            <?php section('Cursos', render_list($courses, fn($item) => '<strong>' . htmlspecialchars($item['name'] ?? '') . '</strong><span>' . htmlspecialchars(($item['institution'] ?? '') . ' · ' . ($item['hours'] ?? '')) . '</span>')); ?>
        </div>
        <div class="grid">
            <?php section('Skills técnicas', render_tags($skills['hard'] ?? [])); ?>
            <?php section('Competências comportamentais', render_tags($skills['soft'] ?? [])); ?>
        </div>
        <?php section('Projetos', render_projects($projects)); ?>
        <div class="grid">
            <?php section('Idiomas', render_tags($languages)); ?>
            <?php section('Voluntariado', render_list($volunteer, fn($item) => '<strong>' . htmlspecialchars($item['name'] ?? '') . '</strong><span>' . htmlspecialchars($item['description'] ?? '') . '</span>')); ?>
        </div>
    </main>
</div>
