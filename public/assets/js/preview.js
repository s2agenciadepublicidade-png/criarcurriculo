document.querySelectorAll('[data-dialog]')?.forEach((button) => {
    button.addEventListener('click', () => {
        const target = document.getElementById(`${button.dataset.dialog}-dialog`);
        if (target) {
            target.hidden = false;
            target.querySelector('input, textarea, button')?.focus();
        }
    });
});

document.querySelectorAll('[data-close]')?.forEach((element) => {
    element.addEventListener('click', () => {
        element.closest('.dialog').hidden = true;
    });
});

document.querySelectorAll('.dialog')?.forEach((dialog) => {
    dialog.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            dialog.hidden = true;
        }
    });
});
