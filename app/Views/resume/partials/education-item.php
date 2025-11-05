<div class="dynamic-item" data-index="<?= $index; ?>">
    <div class="grid gap-4 md:grid-cols-2">
        <label class="block">
            <span class="form-label">Curso</span>
            <input type="text" name="education[<?= $index; ?>][course]" class="form-input" value="<?= htmlspecialchars($edu['course'] ?? ''); ?>">
        </label>
        <label class="block">
            <span class="form-label">Instituição</span>
            <input type="text" name="education[<?= $index; ?>][institution]" class="form-input" value="<?= htmlspecialchars($edu['institution'] ?? ''); ?>">
        </label>
        <label class="block">
            <span class="form-label">Status</span>
            <select name="education[<?= $index; ?>][status]" class="form-select">
                <option value="concluído" <?= ($edu['status'] ?? '') === 'concluído' ? 'selected' : ''; ?>>Concluído</option>
                <option value="em andamento" <?= ($edu['status'] ?? '') === 'em andamento' ? 'selected' : ''; ?>>Em andamento</option>
            </select>
        </label>
        <label class="block">
            <span class="form-label">Ano</span>
            <input type="text" name="education[<?= $index; ?>][year]" class="form-input" value="<?= htmlspecialchars($edu['year'] ?? ''); ?>">
        </label>
    </div>
    <button type="button" class="btn btn-danger btn-sm mt-4" data-remove>Remover</button>
</div>
