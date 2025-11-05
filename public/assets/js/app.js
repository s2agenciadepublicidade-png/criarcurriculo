import { initWizard } from './wizard.js';
import { initChipInputs } from './chips.js';

const wizardForm = document.querySelector('#resume-form');
if (wizardForm) {
    initChipInputs();
    initWizard(wizardForm);
}

const flashElements = document.querySelectorAll('[data-autodismiss]');
flashElements.forEach((el) => {
    setTimeout(() => el.remove(), Number(el.dataset.autodismiss) || 4000);
});
