<?php
include __DIR__ . '/shared.php';
?>
<div class="template lateral" data-color="<?= htmlspecialchars($accent); ?>">
    <aside class="sidebar">
        <div class="profile">
            <h1><?= htmlspecialchars($personal['full_name'] ?? $resume['title']); ?></h1>
            <?php if ($objective): ?><p class="headline"><?= htmlspecialchars($objective); ?></p><?php endif; ?>
        </div>
        <section>
            <h2>Contato</h2>
            <p><?= htmlspecialchars($personal['phone'] ?? ''); ?><br><?= htmlspecialchars($personal['email'] ?? ''); ?><br><?= htmlspecialchars($personal['location'] ?? ''); ?></p>
            <?php if (!empty($personal['linkedin'])): ?><p><a href="<?= htmlspecialchars($personal['linkedin']); ?>">LinkedIn</a></p><?php endif; ?>
            <?php if (!empty($personal['portfolio'])): ?><p><a href="<?= htmlspecialchars($personal['portfolio']); ?>">Portfólio</a></p><?php endif; ?>
        </section>
        <?php section('Skills técnicas', render_tags($skills['hard'] ?? [])); ?>
        <?php section('Soft skills', render_tags($skills['soft'] ?? [])); ?>
        <?php section('Idiomas', render_tags($languages)); ?>
    </aside>
    <main class="main">
        <?php section('Resumo profissional', $summary ? '<p>' . nl2br(htmlspecialchars($summary)) . '</p>' : null); ?>
        <?php section('Experiências', render_experiences($experiences)); ?>
        <?php section('Formação', render_list($education, fn($item) => '<strong>' . htmlspecialchars($item['course'] ?? '') . '</strong><span>' . htmlspecialchars(($item['institution'] ?? '') . ' · ' . ($item['status'] ?? '') . ' · ' . ($item['year'] ?? '')) . '</span>')); ?>
        <?php section('Cursos & Certificações', render_list($courses, fn($item) => '<strong>' . htmlspecialchars($item['name'] ?? '') . '</strong><span>' . htmlspecialchars(($item['institution'] ?? '') . ' · ' . ($item['hours'] ?? '')) . '</span>')); ?>
        <?php section('Projetos', render_projects($projects)); ?>
        <?php section('Voluntariado', render_list($volunteer, fn($item) => '<strong>' . htmlspecialchars($item['name'] ?? '') . '</strong><span>' . htmlspecialchars($item['description'] ?? '') . '</span>')); ?>
    </main>
</div>
<style>
.template.lateral { display: grid; grid-template-columns: 1fr 2.2fr; min-height: 100%; }
.template.lateral .sidebar { background: rgba(37,99,235,0.08); padding: 24px; display: flex; flex-direction: column; gap: 20px; }
.template.lateral .sidebar h1 { font-size: 24px; margin-bottom: 4px; }
.template.lateral .sidebar a { color: <?= $accent; ?>; text-decoration: none; font-size: 13px; }
.template.lateral .main { padding: 24px 32px; display: flex; flex-direction: column; gap: 20px; }
</style>
