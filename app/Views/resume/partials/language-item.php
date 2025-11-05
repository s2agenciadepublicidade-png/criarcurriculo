<div class="dynamic-item" data-index="<?= $index; ?>">
    <div class="grid gap-4 md:grid-cols-2">
        <label class="block">
            <span class="form-label">Idioma</span>
            <input type="text" name="languages[<?= $index; ?>][name]" class="form-input" value="<?= htmlspecialchars($language['name'] ?? ''); ?>">
        </label>
        <label class="block">
            <span class="form-label">Nível</span>
            <select name="languages[<?= $index; ?>][level]" class="form-select">
                <?php foreach (['Básico','Intermediário','Avançado','Fluente','A1','A2','B1','B2','C1','C2'] as $level): ?>
                    <option value="<?= $level; ?>" <?= ($language['level'] ?? '') === $level ? 'selected' : ''; ?>><?= $level; ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <button type="button" class="btn btn-danger btn-sm mt-4" data-remove>Remover</button>
</div>
