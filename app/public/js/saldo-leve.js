document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm('Deseja excluir esta despesa? Essa ação não pode ser desfeita.')) {
            event.preventDefault();
        }
    });
});

const invalidField = document.querySelector('[aria-invalid="true"]');
if (invalidField) invalidField.focus();
