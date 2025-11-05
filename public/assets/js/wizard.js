import { generateImpactBullet } from './writer.js';

export function initWizard(form) {
    const steps = Array.from(form.querySelectorAll('.wizard-panel'));
    const stepButtons = Array.from(form.querySelectorAll('.wizard-step-button'));
    const progress = form.querySelector('#wizard-progress');
    const label = form.querySelector('#wizard-step-label');
    const tip = document.querySelector('#wizard-tip');
    const microcopy = window.MICROCOPY || {};
    const tipOrder = ['personal','objective','summary','experience','education','education','skills','projects','languages','volunteer','preferences'];
    let current = 0;

    const csrf = form.querySelector('input[name="_csrf"]').value;
    let autosaveTimeout = null;

    function updateUI() {
        steps.forEach((panel, index) => {
            panel.toggleAttribute('hidden', index !== current);
        });
        stepButtons.forEach((btn, index) => {
            const active = index === current;
            btn.classList.toggle('active', active);
            btn.setAttribute('aria-current', active ? 'step' : 'false');
        });
        if (progress) {
            const percentage = ((current + 1) / steps.length) * 100;
            progress.style.width = `${percentage}%`;
        }
        if (label) {
            label.textContent = `Etapa ${current + 1} de ${steps.length}`;
        }
        if (tip && microcopy.tips) {
            const key = tipOrder[current] || 'personal';
            tip.textContent = `Dica do recrutador: ${microcopy.tips[key] || microcopy.tips.personal}`;
        }
    }

    function serializeForm() {
        const data = new FormData(form);
        const formData = {};
        data.forEach((value, key) => {
            const path = key.replace(/\]/g, '').split('[');
            let pointer = formData;
            path.forEach((part, index) => {
                if (index === path.length - 1) {
                    pointer[part] = value;
                } else {
                    pointer[part] = pointer[part] || {};
                    pointer = pointer[part];
                }
            });
        });
        try {
            formData.skills = formData.skills || {};
            formData.skills.hard = JSON.parse(form.querySelector('input[name="skills[hard]"]').value || '[]');
            formData.skills.soft = JSON.parse(form.querySelector('input[name="skills[soft]"]').value || '[]');
        } catch (error) {
            console.error('Erro ao ler skills', error);
        }
        return formData;
    }

    async function autosave() {
        const payload = {
            _csrf: csrf,
            resumeId: form.querySelector('#resume-id').value || null,
            template: form.querySelector('select[name="preferences[template]"]').value,
            color: form.querySelector('select[name="preferences[color]"]').value,
            title: form.querySelector('input[name="preferences[title]"]').value,
            form: serializeForm(),
        };
        try {
            const response = await fetch(form.dataset.autosaveEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            });
            const json = await response.json();
            if (json.success) {
                if (json.resumeId) {
                    form.querySelector('#resume-id').value = json.resumeId;
                    const previewLink = document.querySelector('#preview-link');
                    if (previewLink) {
                        previewLink.classList.remove('disabled');
                        previewLink.setAttribute('href', `/resume/${json.resumeId}/preview`);
                    }
                }
            }
        } catch (error) {
            console.warn('Autosave falhou', error);
        }
    }

    function scheduleAutosave() {
        window.clearTimeout(autosaveTimeout);
        autosaveTimeout = window.setTimeout(autosave, 1200);
    }

    form.addEventListener('input', scheduleAutosave);
    form.addEventListener('change', scheduleAutosave);

    form.querySelector('#btn-next')?.addEventListener('click', () => {
        if (current < steps.length - 1) {
            current += 1;
            updateUI();
        }
    });

    form.querySelector('#btn-prev')?.addEventListener('click', () => {
        if (current > 0) {
            current -= 1;
            updateUI();
        }
    });

    stepButtons.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            current = index;
            updateUI();
        });
    });

    form.querySelector('#btn-generate-bullet')?.addEventListener('click', () => {
        const activePanel = steps[current];
        const textarea = activePanel?.querySelector('textarea');
        if (!textarea) return;
        const bullet = generateImpactBullet(textarea.value, microcopy);
        textarea.value = textarea.value ? `${textarea.value}\n${bullet}` : bullet;
        textarea.dispatchEvent(new Event('input'));
    });

    const counters = {};
    form.querySelectorAll('[data-add]').forEach((button) => {
        const type = button.dataset.add;
        counters[type] = form.querySelectorAll(`#${type}-list .dynamic-item`).length;
        button.addEventListener('click', () => {
            const template = document.getElementById(`${type}-template`);
            const list = form.querySelector(`#${type}-list`);
            if (!template || !list) return;
            const index = counters[type]++;
            const html = template.innerHTML.replace(/__INDEX__/g, index);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            const element = wrapper.firstElementChild;
            if (element) {
                list.appendChild(element);
                element.querySelectorAll('input, textarea, select').forEach((field) => field.dispatchEvent(new Event('input', { bubbles: true })));
            }
            scheduleAutosave();
        });
    });

    form.addEventListener('click', (event) => {
        const target = event.target;
        if (target instanceof HTMLElement && target.hasAttribute('data-remove')) {
            const item = target.closest('.dynamic-item');
            item?.remove();
            scheduleAutosave();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowRight') {
            event.preventDefault();
            if (current < steps.length - 1) {
                current += 1;
                updateUI();
            }
        }
        if (event.key === 'ArrowLeft') {
            event.preventDefault();
            if (current > 0) {
                current -= 1;
                updateUI();
            }
        }
    });

    updateUI();
    scheduleAutosave();
}
