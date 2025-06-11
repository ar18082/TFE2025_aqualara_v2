<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration des délais de validation
    const validationDelays = new Map();

    // Initialisation des formulaires optimisés
    document.querySelectorAll('.optimized-form').forEach(form => {
        initializeForm(form);
    });

    /**
     * Initialise un formulaire optimisé
     */
    function initializeForm(form) {
        // Désactive la validation HTML5 native
        form.setAttribute('novalidate', '');

        // Initialise les champs du formulaire
        form.querySelectorAll('input, select, textarea').forEach(field => {
            initializeField(field);
        });

        // Gestion de la soumission du formulaire
        form.addEventListener('submit', handleSubmit);
    }

    /**
     * Initialise un champ de formulaire
     */
    function initializeField(field) {
        // Validation en temps réel
        if (field.dataset.validate === 'true') {
            field.addEventListener('input', debounce(validateField, field.dataset.debounce || 500));
        }

        // Autocomplétion
        if (field.dataset.autocomplete === 'true') {
            initializeAutocomplete(field);
        }

        // Chargement différé
        if (field.dataset.lazy === 'true') {
            initializeLazyLoading(field);
        }

        // Validation initiale
        validateField.call(field);
    }

    /**
     * Valide un champ de formulaire
     */
    function validateField() {
        const field = this;
        const value = field.value;
        const rules = getValidationRules(field);
        const errors = [];

        // Validation des règles
        for (const [rule, param] of Object.entries(rules)) {
            if (!validateRule(value, rule, param)) {
                errors.push(getErrorMessage(rule, param));
            }
        }

        // Mise à jour de l'état du champ
        updateFieldState(field, errors);
    }

    /**
     * Récupère les règles de validation d'un champ
     */
    function getValidationRules(field) {
        const rules = {};
        const attributes = field.attributes;

        // Règles HTML5
        if (field.required) rules.required = true;
        if (field.type === 'email') rules.email = true;
        if (field.type === 'number') {
            if (field.min) rules.min = field.min;
            if (field.max) rules.max = field.max;
        }
        if (field.pattern) rules.pattern = field.pattern;

        // Règles personnalisées
        for (const attr of attributes) {
            if (attr.name.startsWith('data-validate-')) {
                const rule = attr.name.replace('data-validate-', '');
                rules[rule] = attr.value;
            }
        }

        return rules;
    }

    /**
     * Valide une règle
     */
    function validateRule(value, rule, param) {
        switch (rule) {
            case 'required':
                return value.trim() !== '';
            case 'email':
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            case 'min':
                return value.length >= parseInt(param);
            case 'max':
                return value.length <= parseInt(param);
            case 'pattern':
                return new RegExp(param).test(value);
            default:
                return true;
        }
    }

    /**
     * Met à jour l'état d'un champ
     */
    function updateFieldState(field, errors) {
        const container = field.closest('.form-group') || field.parentElement;
        const errorElement = container.querySelector('.error-message') || createErrorElement(container);

        if (errors.length > 0) {
            field.classList.add('is-invalid');
            errorElement.textContent = errors.join(', ');
        } else {
            field.classList.remove('is-invalid');
            errorElement.textContent = '';
        }
    }

    /**
     * Crée un élément d'erreur
     */
    function createErrorElement(container) {
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message text-danger mt-1';
        container.appendChild(errorElement);
        return errorElement;
    }

    /**
     * Gère la soumission du formulaire
     */
    async function handleSubmit(event) {
        event.preventDefault();
        const form = event.target;
        const fields = form.querySelectorAll('input, select, textarea');
        let isValid = true;

        // Validation de tous les champs
        for (const field of fields) {
            validateField.call(field);
            if (field.classList.contains('is-invalid')) {
                isValid = false;
            }
        }

        if (!isValid) {
            return;
        }

        // Désactive le bouton de soumission
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Envoi en cours...';
        }

        try {
            // Récupération des données du formulaire
            const formData = new FormData(form);

            // Envoi des données
            const response = await fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) {
                throw new Error('Erreur lors de la soumission du formulaire');
            }

            // Gestion de la réponse
            const result = await response.json();
            handleFormResponse(form, result);
        } catch (error) {
            console.error('Erreur:', error);
            showError(form, 'Une erreur est survenue lors de la soumission du formulaire');
        } finally {
            // Réactive le bouton de soumission
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Envoyer';
            }
        }
    }

    /**
     * Gère la réponse du formulaire
     */
    function handleFormResponse(form, result) {
        if (result.success) {
            showSuccess(form, result.message || 'Formulaire soumis avec succès');
            if (result.redirect) {
                window.location.href = result.redirect;
            }
        } else {
            showError(form, result.message || 'Erreur lors de la soumission du formulaire');
        }
    }

    /**
     * Affiche un message de succès
     */
    function showSuccess(form, message) {
        const alert = createAlert('success', message);
        form.insertAdjacentElement('beforebegin', alert);
        setTimeout(() => alert.remove(), 5000);
    }

    /**
     * Affiche un message d'erreur
     */
    function showError(form, message) {
        const alert = createAlert('danger', message);
        form.insertAdjacentElement('beforebegin', alert);
        setTimeout(() => alert.remove(), 5000);
    }

    /**
     * Crée une alerte
     */
    function createAlert(type, message) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        return alert;
    }

    /**
     * Fonction de debounce
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func.apply(this, args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
});
</script>

<style>
.optimized-form .is-invalid {
    border-color: #dc3545;
}

.optimized-form .is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.optimized-form .error-message {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.optimized-form button[type="submit"]:disabled {
    cursor: not-allowed;
    opacity: 0.7;
}
</style> 