<div class="dynamic-item" data-index="<?= $index; ?>">
    <label class="block">
        <span class="form-label">Atividade / Organização</span>
        <input type="text" name="volunteer[<?= $index; ?>][name]" class="form-input" value="<?= htmlspecialchars($item['name'] ?? ''); ?>">
    </label>
    <label class="block mt-3">
        <span class="form-label">Descrição e impacto</span>
        <textarea name="volunteer[<?= $index; ?>][description]" rows="3" class="form-textarea" placeholder="Mentoria de carreiras para jovens em situação de vulnerabilidade, alcance de 40 participantes."><?= htmlspecialchars($item['description'] ?? ''); ?></textarea>
    </label>
    <button type="button" class="btn btn-danger btn-sm mt-4" data-remove>Remover</button>
</div>
