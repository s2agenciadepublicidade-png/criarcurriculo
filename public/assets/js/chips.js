const levels = ['Básico', 'Intermediário', 'Avançado', 'Fluente'];

export function initChipInputs() {
    document.querySelectorAll('.chip-input').forEach((container) => {
        const hidden = container.nextElementSibling;
        if (!(hidden instanceof HTMLInputElement)) return;
        const suggestions = safeParse(container.dataset.suggestions) || [];
        container.addEventListener('click', () => openDialog(container, hidden, suggestions));
    });
}

function safeParse(value) {
    try {
        return value ? JSON.parse(value) : [];
    } catch (error) {
        console.warn('Erro ao parsear sugestões', error);
        return [];
    }
}

function openDialog(container, hidden, suggestions) {
    const name = prompt('Informe a habilidade');
    if (!name) return;
    const level = prompt(`Informe o nível (${levels.join(', ')})`, levels[1]) || levels[1];
    const chip = document.createElement('span');
    chip.className = 'chip';
    chip.dataset.value = name;
    chip.dataset.level = level;
    chip.innerHTML = `${name} <em>${level}</em>`;
    chip.tabIndex = 0;
    chip.addEventListener('click', () => {
        chip.remove();
        sync(container, hidden);
    });
    chip.addEventListener('keydown', (event) => {
        if (event.key === 'Delete' || event.key === 'Backspace') {
            chip.remove();
            sync(container, hidden);
        }
    });
    container.appendChild(chip);
    sync(container, hidden);
}

function sync(container, hidden) {
    const values = Array.from(container.querySelectorAll('.chip')).map((chip) => ({
        name: chip.dataset.value,
        level: chip.dataset.level,
    }));
    hidden.value = JSON.stringify(values);
    hidden.dispatchEvent(new Event('input', { bubbles: true }));
}
