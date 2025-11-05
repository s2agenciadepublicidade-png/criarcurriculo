<div class="dynamic-item" data-index="<?= $index; ?>">
    <div class="grid gap-4 md:grid-cols-3">
        <label class="block">
            <span class="form-label">Nome do curso</span>
            <input type="text" name="courses[<?= $index; ?>][name]" class="form-input" value="<?= htmlspecialchars($course['name'] ?? ''); ?>">
        </label>
        <label class="block">
            <span class="form-label">Instituição</span>
            <input type="text" name="courses[<?= $index; ?>][institution]" class="form-input" value="<?= htmlspecialchars($course['institution'] ?? ''); ?>">
        </label>
        <label class="block">
            <span class="form-label">Carga horária / Credencial</span>
            <input type="text" name="courses[<?= $index; ?>][hours]" class="form-input" value="<?= htmlspecialchars($course['hours'] ?? ''); ?>">
        </label>
    </div>
    <button type="button" class="btn btn-danger btn-sm mt-4" data-remove>Remover</button>
</div>
