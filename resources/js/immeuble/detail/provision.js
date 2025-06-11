document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des variables
    const btnEdit = document.getElementById('btn_edit');
    const btnSave = document.getElementById('btn_save');
    const provisionInputs = document.querySelectorAll('.table_input_provision');
    const allInputs = document.querySelectorAll('.inputProvision');

    // Fonction pour gérer le déverrouillage des inputs
    function toggleProvisionInputs(enable) {
        // Toggle tous les inputs
        allInputs.forEach(input => {
            input.disabled = !enable;
        });

        // Toggle spécifique pour les inputs de provision
        provisionInputs.forEach(input => {
            // Toggle background color of parent td
            const parentTd = input.closest('td');
            if (parentTd) {
                parentTd.style.backgroundColor = enable ? '#d4edda' : 'transparent';
            }

            // Toggle input appearance
            input.style.backgroundColor = enable ? '#fff' : '#f8f9fa';
            input.style.border = enable ? 'none' : '1px solid #ced4da';
            input.style.borderRadius = enable ? '0' : '0.25rem';
            input.style.width = '100%';
            input.style.padding = enable ? '0.375rem 0.75rem' : '0.5rem 0.75rem';
        });

        // Toggle submit button
        if (btnSave) {
            btnSave.disabled = !enable;
            btnSave.style.opacity = enable ? '0.65' : '1';
            btnSave.style.cursor = enable ? 'not-allowed' : 'pointer';
            btnSave.style.display = enable ? 'block' : 'none';
        }

        // Toggle edit button
        if (btnEdit) {
            btnEdit.innerHTML = enable ? 
                '<i class="fa-solid fa-xmark"></i> Annuler' : 
                '<i class="fa-solid fa-pen"></i> Modifier';
            btnEdit.style.backgroundColor = enable ? '#dc3545' : '#023c7b';
            btnEdit.style.color = 'white';
        }

        // Focus sur le premier input provision si déverrouillé
        if (enable && provisionInputs.length > 0) {
            provisionInputs[0].focus();
        }
    }

    // Gestion de la touche § pour activer/désactiver les champs
    document.addEventListener('keydown', function(event) {
        if (event.key === '§') {
            event.preventDefault();
            const isCurrentlyDisabled = allInputs[0]?.disabled;
            toggleProvisionInputs(isCurrentlyDisabled);
        }
    });

    // Gestion du bouton modifier
    if (btnEdit) {
        btnEdit.addEventListener('click', function() {
            const isCurrentlyEditing = this.innerHTML.includes('Annuler');
            toggleProvisionInputs(!isCurrentlyEditing);
        });
    }
});
