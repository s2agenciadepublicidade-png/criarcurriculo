<?php
include __DIR__ . '/shared.php';
?>
<div class="template tech" data-color="<?= htmlspecialchars($accent); ?>">
    <header class="top">
        <div>
            <h1><?= htmlspecialchars($personal['full_name'] ?? $resume['title']); ?></h1>
            <?php if ($objective): ?><p class="headline"><?= htmlspecialchars($objective); ?></p><?php endif; ?>
        </div>
        <div class="contacts">
            <span><?= htmlspecialchars($personal['email'] ?? ''); ?></span>
            <span><?= htmlspecialchars($personal['phone'] ?? ''); ?></span>
            <span><?= htmlspecialchars($personal['location'] ?? ''); ?></span>
        </div>
    </header>
    <section>
        <h2>Resumo</h2>
        <p><?= nl2br(htmlspecialchars($summary)); ?></p>
    </section>
    <section>
        <h2>Stack principal</h2>
        <?= render_tags($skills['hard'] ?? []); ?>
    </section>
    <section class="experience-grid">
        <h2>Histórico profissional</h2>
        <?= render_experiences($experiences); ?>
    </section>
    <section class="skills-grid">
        <div>
            <h2>Soft skills</h2>
            <?= render_tags($skills['soft'] ?? []); ?>
        </div>
        <div>
            <h2>Idiomas</h2>
            <?= render_tags($languages); ?>
        </div>
    </section>
    <section>
        <h2>Projetos relevantes</h2>
        <?= render_projects($projects); ?>
    </section>
    <section class="two">
        <div>
            <h2>Formação</h2>
            <?= render_list($education, fn($item) => '<strong>' . htmlspecialchars($item['course'] ?? '') . '</strong><span>' . htmlspecialchars(($item['institution'] ?? '') . ' · ' . ($item['status'] ?? '') . ' · ' . ($item['year'] ?? '')) . '</span>'); ?>
        </div>
        <div>
            <h2>Cursos & Certificações</h2>
            <?= render_list($courses, fn($item) => '<strong>' . htmlspecialchars($item['name'] ?? '') . '</strong><span>' . htmlspecialchars(($item['institution'] ?? '') . ' · ' . ($item['hours'] ?? '')) . '</span>'); ?>
        </div>
    </section>
    <section>
        <h2>Voluntariado</h2>
        <?= render_list($volunteer, fn($item) => '<strong>' . htmlspecialchars($item['name'] ?? '') . '</strong><span>' . htmlspecialchars($item['description'] ?? '') . '</span>'); ?>
    </section>
</div>
<style>
.template.tech { display: grid; gap: 20px; font-family: 'IBM Plex Sans', 'Inter', sans-serif; }
.template.tech .top { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid <?= $accent; ?>; padding-bottom: 16px; }
.template.tech .contacts { display: flex; flex-direction: column; gap: 4px; font-size: 12px; color: #475569; text-align: right; }
.template.tech .experience-grid .stack { border-left: 3px solid <?= $accent; ?>; padding-left: 16px; }
.template.tech .stack .item { background: rgba(37,99,235,0.06); border-radius: 12px; padding: 12px; }
.template.tech .skills-grid { display: grid; gap: 16px; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
.template.tech .two { display: grid; gap: 16px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
.template.tech .tags span { background: rgba(37,99,235,0.15); border: 1px solid <?= $accent; ?>; color: <?= $accent; ?>; }
.template.tech a { color: <?= $accent; ?>; }
</style>
