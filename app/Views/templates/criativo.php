<?php
include __DIR__ . '/shared.php';
?>
<div class="template criativo" data-color="<?= htmlspecialchars($accent); ?>">
    <header class="hero">
        <div>
            <h1><?= htmlspecialchars($personal['full_name'] ?? $resume['title']); ?></h1>
            <?php if ($objective): ?><p class="headline"><?= htmlspecialchars($objective); ?></p><?php endif; ?>
        </div>
        <div class="badge">Disponível para novas oportunidades</div>
    </header>
    <section class="summary">
        <h2>Sobre</h2>
        <p><?= nl2br(htmlspecialchars($summary)); ?></p>
        <ul class="chips">
            <?php foreach (($skills['hard'] ?? []) as $skill): ?>
                <li><?= htmlspecialchars($skill['name'] ?? ''); ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section>
        <h2>Experiências com impacto</h2>
        <?= render_experiences($experiences); ?>
    </section>
    <section class="grid">
        <div>
            <h2>Formação</h2>
            <?= render_list($education, fn($item) => '<strong>' . htmlspecialchars($item['course'] ?? '') . '</strong><span>' . htmlspecialchars(($item['institution'] ?? '') . ' · ' . ($item['status'] ?? '') . ' · ' . ($item['year'] ?? '')) . '</span>'); ?>
        </div>
        <div>
            <h2>Cursos</h2>
            <?= render_list($courses, fn($item) => '<strong>' . htmlspecialchars($item['name'] ?? '') . '</strong><span>' . htmlspecialchars(($item['institution'] ?? '') . ' · ' . ($item['hours'] ?? '')) . '</span>'); ?>
        </div>
    </section>
    <section>
        <h2>Projetos em destaque</h2>
        <?= render_projects($projects); ?>
    </section>
    <section class="grid">
        <div>
            <h2>Idiomas</h2>
            <?= render_tags($languages); ?>
        </div>
        <div>
            <h2>Voluntariado</h2>
            <?= render_list($volunteer, fn($item) => '<strong>' . htmlspecialchars($item['name'] ?? '') . '</strong><span>' . htmlspecialchars($item['description'] ?? '') . '</span>'); ?>
        </div>
    </section>
    <footer class="cta">
        <div>
            <strong>Contato</strong>
            <p><?= htmlspecialchars($personal['email'] ?? ''); ?> · <?= htmlspecialchars($personal['phone'] ?? ''); ?></p>
        </div>
        <div class="links">
            <?php if (!empty($personal['linkedin'])): ?><a href="<?= htmlspecialchars($personal['linkedin']); ?>">LinkedIn</a><?php endif; ?>
            <?php if (!empty($personal['portfolio'])): ?><a href="<?= htmlspecialchars($personal['portfolio']); ?>">Portfólio</a><?php endif; ?>
        </div>
    </footer>
</div>
<?php [$r, $g, $b] = sscanf($accent, '#%02x%02x%02x'); ?>
<style>
.template.criativo { background: linear-gradient(135deg, rgba(<?= $r; ?>,<?= $g; ?>,<?= $b; ?>,0.08), #ffffff 60%); padding: 32px; border-radius: 24px; display: flex; flex-direction: column; gap: 24px; }
.template.criativo .hero { display: flex; justify-content: space-between; align-items: center; }
.template.criativo .badge { background: rgba(255,255,255,0.8); border: 2px solid <?= $accent; ?>; padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; color: <?= $accent; ?>; }
.template.criativo .summary { background: rgba(255,255,255,0.75); padding: 20px; border-radius: 16px; box-shadow: 0 10px 30px rgba(15,23,42,0.08); }
.template.criativo .chips { list-style: none; padding: 0; margin: 16px 0 0; display: flex; flex-wrap: wrap; gap: 8px; }
.template.criativo .chips li { background: <?= $accent; ?>; color: #ffffff; padding: 6px 12px; border-radius: 999px; font-size: 12px; }
.template.criativo .grid { display: grid; gap: 20px; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
.template.criativo section h2 { text-transform: uppercase; letter-spacing: 0.1em; font-size: 13px; color: <?= $accent; ?>; margin-bottom: 8px; }
.template.criativo .cta { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(15,23,42,0.1); padding-top: 16px; }
.template.criativo a { color: <?= $accent; ?>; text-decoration: none; }
</style>
