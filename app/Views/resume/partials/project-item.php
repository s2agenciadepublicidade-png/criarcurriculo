<div class="dynamic-item" data-index="<?= $index; ?>">
    <div class="grid gap-4 md:grid-cols-2">
        <label class="block">
            <span class="form-label">Título</span>
            <input type="text" name="projects[<?= $index; ?>][title]" class="form-input" value="<?= htmlspecialchars($project['title'] ?? ''); ?>">
        </label>
        <label class="block">
            <span class="form-label">Link / Resultado</span>
            <input type="text" name="projects[<?= $index; ?>][link]" class="form-input" value="<?= htmlspecialchars($project['link'] ?? ''); ?>">
        </label>
    </div>
    <label class="block mt-3">
        <span class="form-label">Descrição breve</span>
        <textarea name="projects[<?= $index; ?>][description]" rows="3" class="form-textarea" placeholder="Descreva o desafio, a solução e o impacto."><?= htmlspecialchars($project['description'] ?? ''); ?></textarea>
    </label>
    <button type="button" class="btn btn-danger btn-sm mt-4" data-remove>Remover</button>
</div>
