<?php
$steps = [
    'Dados pessoais',
    'Objetivo profissional',
    'Resumo/Perfil',
    'Experiências',
    'Formação acadêmica',
    'Cursos & Certificações',
    'Habilidades',
    'Projetos & Portfólio',
    'Idiomas',
    'Atividades complementares',
    'Preferências de modelo',
];
?>
<nav class="wizard-stepper" aria-label="Etapas do currículo">
    <ol class="wizard-stepper-list">
        <?php foreach ($steps as $index => $label): ?>
            <li class="wizard-step" data-step="<?= $index; ?>">
                <button type="button" class="wizard-step-button" data-target="step-<?= $index; ?>">
                    <span class="wizard-step-number"><?= $index + 1; ?></span>
                    <span class="wizard-step-label"><?= htmlspecialchars($label); ?></span>
                </button>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>
<section class="wizard-panels">
    <!-- Step 0: Dados pessoais -->
    <article id="step-0" class="wizard-panel" data-step="0" aria-labelledby="step-title-0">
        <header>
            <h2 id="step-title-0" class="panel-title">Dados pessoais</h2>
            <p class="panel-description">E-mail profissional, telefone com WhatsApp e localização abreviada (ex.: São Paulo/SP).</p>
        </header>
        <div class="grid gap-4 md:grid-cols-2">
            <label class="block">
                <span class="form-label">Nome completo</span>
                <input type="text" name="personal[full_name]" class="form-input required" value="<?= htmlspecialchars($formData['personal']['full_name']); ?>" required>
            </label>
            <label class="block">
                <span class="form-label">Telefone</span>
                <input type="tel" name="personal[phone]" class="form-input" placeholder="(11) 91234-5678" value="<?= htmlspecialchars($formData['personal']['phone']); ?>">
            </label>
            <label class="block">
                <span class="form-label">E-mail</span>
                <input type="email" name="personal[email]" class="form-input required" value="<?= htmlspecialchars($formData['personal']['email']); ?>" required>
            </label>
            <label class="block">
                <span class="form-label">Cidade / UF</span>
                <input type="text" name="personal[location]" class="form-input" placeholder="Belo Horizonte/MG" value="<?= htmlspecialchars($formData['personal']['location']); ?>">
            </label>
            <label class="block">
                <span class="form-label">LinkedIn</span>
                <input type="url" name="personal[linkedin]" class="form-input" placeholder="https://linkedin.com/in/seu-perfil" value="<?= htmlspecialchars($formData['personal']['linkedin']); ?>">
            </label>
            <label class="block">
                <span class="form-label">Portfólio / GitHub</span>
                <input type="url" name="personal[portfolio]" class="form-input" placeholder="https://github.com/seuusuario" value="<?= htmlspecialchars($formData['personal']['portfolio']); ?>">
            </label>
        </div>
    </article>
    <!-- Step 1: Objetivo -->
    <article id="step-1" class="wizard-panel" data-step="1" aria-labelledby="step-title-1" hidden>
        <header>
            <h2 id="step-title-1" class="panel-title">Objetivo profissional</h2>
            <p class="panel-description">Em 1-2 linhas, conecte o cargo desejado com o impacto que entrega.</p>
        </header>
        <textarea name="objective" rows="3" class="form-textarea" placeholder="Ex.: Representante de Vendas focado em prospecção B2B e expansão de carteira."><?= htmlspecialchars($formData['objective']); ?></textarea>
        <div class="microcopy">
            <h3>Exemplos rápidos</h3>
            <ul>
                <?php foreach ($microcopy['objectives'] as $area => $text): ?>
                    <li><strong><?= htmlspecialchars($area); ?>:</strong> <?= htmlspecialchars($text); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </article>
    <!-- Step 2: Resumo -->
    <article id="step-2" class="wizard-panel" data-step="2" aria-labelledby="step-title-2" hidden>
        <header>
            <h2 id="step-title-2" class="panel-title">Resumo / Perfil</h2>
            <p class="panel-description">Destaque conquistas, diferenciais e motivação em até 5 frases.</p>
        </header>
        <textarea name="summary" rows="5" class="form-textarea" placeholder="Profissional com X anos de experiência...">
<?= trim(htmlspecialchars($formData['summary'])); ?>
        </textarea>
        <p class="text-sm text-slate-500 mt-2">Dica: combine métricas, verbos fortes e contexto da área.</p>
    </article>
    <!-- Step 3: Experiências -->
    <article id="step-3" class="wizard-panel" data-step="3" aria-labelledby="step-title-3" hidden>
        <header>
            <h2 id="step-title-3" class="panel-title">Experiências</h2>
            <p class="panel-description">Use bullets que mostrem verbo + ação + resultado. Clique em “Adicionar experiência”.</p>
        </header>
        <div id="experience-list" class="dynamic-list" data-template="experience-template">
            <?php foreach ($formData['experiences'] as $index => $exp): ?>
                <?php include __DIR__ . '/partials/experience-item.php'; ?>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-secondary" data-add="experience">Adicionar experiência</button>
    </article>
    <!-- Step 4: Formação -->
    <article id="step-4" class="wizard-panel" data-step="4" aria-labelledby="step-title-4" hidden>
        <header>
            <h2 id="step-title-4" class="panel-title">Formação acadêmica</h2>
            <p class="panel-description">Liste curso, instituição, status (concluído/em andamento) e ano.</p>
        </header>
        <div id="education-list" class="dynamic-list" data-template="education-template">
            <?php foreach ($formData['education'] as $index => $edu): ?>
                <?php include __DIR__ . '/partials/education-item.php'; ?>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-secondary" data-add="education">Adicionar formação</button>
    </article>
    <!-- Step 5: Cursos -->
    <article id="step-5" class="wizard-panel" data-step="5" aria-labelledby="step-title-5" hidden>
        <header>
            <h2 id="step-title-5" class="panel-title">Cursos & Certificações</h2>
            <p class="panel-description">Inclua cursos relevantes, certificações e carga horária.</p>
        </header>
        <div id="courses-list" class="dynamic-list" data-template="course-template">
            <?php foreach ($formData['courses'] as $index => $course): ?>
                <?php include __DIR__ . '/partials/course-item.php'; ?>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-secondary" data-add="course">Adicionar curso/certificação</button>
    </article>
    <!-- Step 6: Habilidades -->
    <article id="step-6" class="wizard-panel" data-step="6" aria-labelledby="step-title-6" hidden>
        <header>
            <h2 id="step-title-6" class="panel-title">Habilidades</h2>
            <p class="panel-description">Separe hard skills e soft skills. Defina o nível de domínio.</p>
        </header>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <h3 class="subheading">Hard skills</h3>
                <div id="hard-skills" class="chip-input" data-suggestions='<?= json_encode($microcopy['skills']['TI']); ?>'>
                    <?php foreach ($formData['skills']['hard'] as $skill): ?>
                        <span class="chip" data-value="<?= htmlspecialchars($skill['name']); ?>" data-level="<?= htmlspecialchars($skill['level']); ?>"><?= htmlspecialchars($skill['name']); ?> <em><?= htmlspecialchars($skill['level']); ?></em></span>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="skills[hard]" value='<?= json_encode($formData['skills']['hard']); ?>'>
            </div>
            <div>
                <h3 class="subheading">Soft skills</h3>
                <div id="soft-skills" class="chip-input" data-suggestions='<?= json_encode($microcopy['skills']['Atendimento']); ?>'>
                    <?php foreach ($formData['skills']['soft'] as $skill): ?>
                        <span class="chip" data-value="<?= htmlspecialchars($skill['name']); ?>" data-level="<?= htmlspecialchars($skill['level']); ?>"><?= htmlspecialchars($skill['name']); ?> <em><?= htmlspecialchars($skill['level']); ?></em></span>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="skills[soft]" value='<?= json_encode($formData['skills']['soft']); ?>'>
            </div>
        </div>
    </article>
    <!-- Step 7: Projetos -->
    <article id="step-7" class="wizard-panel" data-step="7" aria-labelledby="step-title-7" hidden>
        <header>
            <h2 id="step-title-7" class="panel-title">Projetos & Portfólio</h2>
            <p class="panel-description">Mostre projetos relevantes com resultados, tecnologias e links.</p>
        </header>
        <div id="projects-list" class="dynamic-list" data-template="project-template">
            <?php foreach ($formData['projects'] as $index => $project): ?>
                <?php include __DIR__ . '/partials/project-item.php'; ?>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-secondary" data-add="project">Adicionar projeto</button>
    </article>
    <!-- Step 8: Idiomas -->
    <article id="step-8" class="wizard-panel" data-step="8" aria-labelledby="step-title-8" hidden>
        <header>
            <h2 id="step-title-8" class="panel-title">Idiomas</h2>
            <p class="panel-description">Informe idioma e nível (A1-C2 ou Básico/Fluente).</p>
        </header>
        <div id="languages-list" class="dynamic-list" data-template="language-template">
            <?php foreach ($formData['languages'] as $index => $language): ?>
                <?php include __DIR__ . '/partials/language-item.php'; ?>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-secondary" data-add="language">Adicionar idioma</button>
    </article>
    <!-- Step 9: Voluntariado -->
    <article id="step-9" class="wizard-panel" data-step="9" aria-labelledby="step-title-9" hidden>
        <header>
            <h2 id="step-title-9" class="panel-title">Atividades complementares / Voluntariado</h2>
            <p class="panel-description">Compartilhe ações sociais, mentorias ou projetos paralelos relevantes.</p>
        </header>
        <div id="volunteer-list" class="dynamic-list" data-template="volunteer-template">
            <?php foreach ($formData['volunteer'] as $index => $item): ?>
                <?php include __DIR__ . '/partials/volunteer-item.php'; ?>
            <?php endforeach; ?>
        </div>
        <button type="button" class="btn btn-secondary" data-add="volunteer">Adicionar atividade</button>
    </article>
    <!-- Step 10: Preferências -->
    <article id="step-10" class="wizard-panel" data-step="10" aria-labelledby="step-title-10" hidden>
        <header>
            <h2 id="step-title-10" class="panel-title">Preferências do modelo</h2>
            <p class="panel-description">Escolha o template e cor de destaque. Alterações refletem na prévia.</p>
        </header>
        <label class="block">
            <span class="form-label">Título do currículo</span>
            <input type="text" name="preferences[title]" class="form-input" value="<?= htmlspecialchars($formData['preferences']['title']); ?>">
        </label>
        <label class="block">
            <span class="form-label">Modelo</span>
            <select name="preferences[template]" class="form-select">
                <option value="classico" <?= $formData['preferences']['template'] === 'classico' ? 'selected' : ''; ?>>Clássico conservador</option>
                <option value="minimalista" <?= $formData['preferences']['template'] === 'minimalista' ? 'selected' : ''; ?>>Moderno minimalista</option>
                <option value="lateral" <?= $formData['preferences']['template'] === 'lateral' ? 'selected' : ''; ?>>Profissional com barra lateral</option>
                <option value="criativo" <?= $formData['preferences']['template'] === 'criativo' ? 'selected' : ''; ?>>Criativo visual moderado</option>
                <option value="tech" <?= $formData['preferences']['template'] === 'tech' ? 'selected' : ''; ?>>Tech / Design</option>
            </select>
        </label>
        <label class="block">
            <span class="form-label">Cor de destaque</span>
            <select name="preferences[color]" class="form-select">
                <option value="azul" <?= $formData['preferences']['color'] === 'azul' ? 'selected' : ''; ?>>Azul confiável</option>
                <option value="verde" <?= $formData['preferences']['color'] === 'verde' ? 'selected' : ''; ?>>Verde sereno</option>
                <option value="vinho" <?= $formData['preferences']['color'] === 'vinho' ? 'selected' : ''; ?>>Vinho elegante</option>
                <option value="grafite" <?= $formData['preferences']['color'] === 'grafite' ? 'selected' : ''; ?>>Grafite neutro</option>
                <option value="cobalto" <?= $formData['preferences']['color'] === 'cobalto' ? 'selected' : ''; ?>>Cobalto vibrante</option>
            </select>
        </label>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">Pronto? Gere a prévia atualizada com base nas respostas.</p>
            <a href="<?= isset($resume['id']) ? '/resume/' . $resume['id'] . '/preview' : '#'; ?>" class="btn btn-primary<?= isset($resume['id']) ? '' : ' disabled'; ?>" id="preview-link">Ver prévia</a>
        </div>
    </article>
</section>
<?php include __DIR__ . '/partials/templates.php'; ?>
