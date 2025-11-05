<div class="dynamic-item" data-index="<?= $index; ?>">
    <div class="grid gap-4 md:grid-cols-2">
        <label class="block">
            <span class="form-label">Cargo</span>
            <input type="text" name="experiences[<?= $index; ?>][role]" class="form-input" value="<?= htmlspecialchars($exp['role'] ?? ''); ?>">
        </label>
        <label class="block">
            <span class="form-label">Empresa</span>
            <input type="text" name="experiences[<?= $index; ?>][company]" class="form-input" value="<?= htmlspecialchars($exp['company'] ?? ''); ?>">
        </label>
        <label class="block">
            <span class="form-label">Período</span>
            <input type="text" name="experiences[<?= $index; ?>][period]" class="form-input" placeholder="2019 - Atual" value="<?= htmlspecialchars($exp['period'] ?? ''); ?>">
        </label>
        <label class="block">
            <span class="form-label">Cidade / UF</span>
            <input type="text" name="experiences[<?= $index; ?>][location]" class="form-input" value="<?= htmlspecialchars($exp['location'] ?? ''); ?>">
        </label>
    </div>
    <label class="block mt-4">
        <span class="form-label">Responsabilidades (use bullets)</span>
        <textarea name="experiences[<?= $index; ?>][responsibilities]" rows="3" class="form-textarea" placeholder="Liderei equipe de 8 vendedores, implementei CRM..."><?= htmlspecialchars($exp['responsibilities'] ?? ''); ?></textarea>
    </label>
    <label class="block mt-3">
        <span class="form-label">Resultados com métricas</span>
        <textarea name="experiences[<?= $index; ?>][results]" rows="3" class="form-textarea" placeholder="Aumentei as vendas em 25% ao otimizar o funil de prospecção."><?= htmlspecialchars($exp['results'] ?? ''); ?></textarea>
    </label>
    <button type="button" class="btn btn-danger btn-sm mt-4" data-remove>Remover</button>
</div>
