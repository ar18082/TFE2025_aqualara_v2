document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si nous sommes sur la bonne page
    const currentPath = window.location.pathname;
    const immeubleDetailsRegex = /^\/immeubles\/\d+\/details\/infoAppart$/;
    
    if (!immeubleDetailsRegex.test(currentPath)) {
        return; // Sortir si nous ne sommes pas sur la bonne page
    }

    // Initialisation des variables
    const btnEdit = document.getElementById('btn_edit');
    const btnSave = document.getElementById('btn_save');
    const allInputs = document.querySelectorAll('.inputInfoAppart');
    const table = document.getElementById('tableInfoApp');
    const colButtons = document.querySelectorAll('.col-title-btn');
    const nbAppartementsInput = document.getElementById('nbAppartements');
    const tbody = table.querySelector('tbody');

    // Fonction pour gérer le déverrouillage des inputs
    function toggleInfoAppartInputs() {
        const isCurrentlyDisabled = allInputs[0]?.disabled;

        // Toggle tous les inputs
        allInputs.forEach(input => {
            input.disabled = !isCurrentlyDisabled;
            input.readOnly = !isCurrentlyDisabled;
            
            // Gestion visuelle des inputs
            if (isCurrentlyDisabled) {
                // Déverrouillage
                input.style.backgroundColor = '#fff';
                input.style.border = '1px solid #ced4da';
                input.style.borderRadius = '0.25rem';
                input.style.padding = '0.5rem 0.75rem';
                input.style.width = '100%';
            } else {
                // Verrouillage
                input.style.backgroundColor = '#f8f9fa';
                input.style.border = 'none';
                input.style.borderRadius = '0';
                input.style.padding = '0.375rem 0.75rem';
                input.style.width = '100%';
            }
        });

        // Toggle submit button
        if (btnSave) {
            if (isCurrentlyDisabled) {
                // Déverrouillage
                btnSave.style.display = 'block';
                btnSave.disabled = false;
                btnSave.style.opacity = '1';
                btnSave.style.cursor = 'pointer';
            } else {
                // Verrouillage
                btnSave.style.display = 'none';
                btnSave.disabled = true;
                btnSave.style.opacity = '0.65';
                btnSave.style.cursor = 'not-allowed';
            }
        }

        // Toggle edit button
        if (btnEdit) {
            if (isCurrentlyDisabled) {
                // Déverrouillage
                btnEdit.innerHTML = '<i class="fa-solid fa-xmark"></i> Annuler';
                btnEdit.style.backgroundColor = '#dc3545';
                btnEdit.style.color = 'white';
            } else {
                // Verrouillage
                btnEdit.innerHTML = '<i class="fa-solid fa-pen"></i> Modifier';
                btnEdit.style.backgroundColor = '#023c7b';
                btnEdit.style.color = 'white';
            }
        }

        // Focus sur le premier input si déverrouillé
        if (isCurrentlyDisabled && allInputs.length > 0) {
            allInputs[0].focus();
        }
    }

    // Gestion de la touche § pour activer/désactiver les champs
    document.addEventListener('keydown', function(event) {
        if (event.key === '§') {
            event.preventDefault();
            toggleInfoAppartInputs();
        }
    });

    // Gestion du bouton modifier
    if (btnEdit) {
        btnEdit.addEventListener('click', function() {
            toggleInfoAppartInputs();
        });
    }

    // Gestion du tri des colonnes
    colButtons.forEach(button => {
        button.addEventListener('click', function() {
            const colIndex = parseInt(this.dataset.col);
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // Trier les lignes
            rows.sort((a, b) => {
                const aValue = a.cells[colIndex].querySelector('input').value;
                const bValue = b.cells[colIndex].querySelector('input').value;
                
                // Gestion des dates
                if (colIndex === 10) { // Colonne Date fin
                    return new Date(aValue.split('-').reverse().join('-')) - new Date(bValue.split('-').reverse().join('-'));
                }
                
                // Gestion des nombres
                if (!isNaN(aValue) && !isNaN(bValue)) {
                    return parseFloat(aValue) - parseFloat(bValue);
                }
                
                // Gestion des chaînes de caractères
                return aValue.localeCompare(bValue);
            });
            
            // Réorganiser les lignes dans le tableau
            rows.forEach(row => tbody.appendChild(row));
            
            // Mettre à jour l'ordre des RefAppTR
            rows.forEach((row, index) => {
                const refAppTRInput = row.cells[0].querySelector('input');
                refAppTRInput.value = index + 1;
            });
        });
    });

    // Navigation avec les flèches directionnelles
    table.addEventListener('keydown', function(event) {
        const activeElement = document.activeElement;
        if (!activeElement.classList.contains('inputInfoAppart')) return;

        const currentRow = activeElement.closest('tr');
        const currentCell = activeElement.closest('td');
        const currentRowIndex = Array.from(currentRow.parentElement.children).indexOf(currentRow);
        
        // Obtenir tous les inputs de la ligne courante
        const currentRowInputs = Array.from(currentRow.querySelectorAll('.inputInfoAppart'));
        const currentInputIndex = currentRowInputs.indexOf(activeElement);

        let nextInput;
        switch (event.key) {
            case 'ArrowRight':
                event.preventDefault();
                // Chercher le prochain input dans la même ligne
                nextInput = currentRowInputs[currentInputIndex + 1];
                if (!nextInput) {
                    // Si pas d'input suivant dans la ligne, aller à la première cellule de la ligne suivante
                    const nextRow = currentRow.nextElementSibling;
                    if (nextRow) {
                        nextInput = nextRow.querySelector('.inputInfoAppart');
                    }
                }
                break;

            case 'ArrowLeft':
                event.preventDefault();
                // Chercher l'input précédent dans la même ligne
                nextInput = currentRowInputs[currentInputIndex - 1];
                if (!nextInput) {
                    // Si pas d'input précédent dans la ligne, aller à la dernière cellule de la ligne précédente
                    const prevRow = currentRow.previousElementSibling;
                    if (prevRow) {
                        const prevRowInputs = prevRow.querySelectorAll('.inputInfoAppart');
                        nextInput = prevRowInputs[prevRowInputs.length - 1];
                    }
                }
                break;

            case 'Enter':
                event.preventDefault();
                // Chercher l'input dans la même colonne de la ligne suivante
                const nextRow = currentRow.nextElementSibling;
                if (nextRow) {
                    const nextRowInputs = nextRow.querySelectorAll('.inputInfoAppart');
                    nextInput = nextRowInputs[currentInputIndex];
                }
                break;

            case 'ArrowUp':
                event.preventDefault();
                // Chercher l'input dans la même colonne de la ligne précédente
                const prevRow = currentRow.previousElementSibling;
                if (prevRow) {
                    const prevRowInputs = prevRow.querySelectorAll('.inputInfoAppart');
                    nextInput = prevRowInputs[currentInputIndex];
                }
                break;
        }

        if (nextInput && !nextInput.disabled) {
            nextInput.focus();
        }
    });

    // Fonction pour créer une nouvelle ligne
    function createNewRow(index) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="text" id="${index}_tableInfoApp_a" class="table-input inputInfoAppart"
                    name="refAppTR_${index}" value="${index + 1}">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_b" class="table-input inputInfoAppart"
                    name="refAppCli_${index}" value="">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_c" class="table-input inputInfoAppart"
                    name="prop_${index}" value="">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_d" class="table-input inputInfoAppart"
                    name="loc_${index}" value="">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_e" class="table-input inputInfoAppart"
                    name="Quot_${index}" value="0">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_f" class="table-input inputInfoAppart"
                    name="NbRad_${index}" value="0">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_g" class="table-input inputInfoAppart"
                    name="NbCptFroid_${index}" value="0">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_h" class="table-input inputInfoAppart"
                    name="NbCptChaud_${index}" value="0">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_i" class="table-input inputInfoAppart"
                    name="Gaz_${index}" value="0">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_j" class="table-input inputInfoAppart"
                    name="Elec_${index}" value="0">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_k" class="table-input inputInfoAppart"
                    name="datefin_${index}" value="">
            </td>
            <td>
                <input type="text" id="${index}_tableInfoApp_l" class="table-input inputInfoAppart"
                    name="bloc_${index}" value="">
            </td>
        `;
        return tr;
    }

    // Gestionnaire d'événement pour l'input nbAppartements
    if (nbAppartementsInput) {
        nbAppartementsInput.addEventListener('change', function() {
            const newCount = parseInt(this.value) || 0;
            const currentRows = tbody.querySelectorAll('tr');
            const currentCount = currentRows.length;

            if (newCount > currentCount) {
                // Ajouter des lignes
                for (let i = currentCount; i < newCount; i++) {
                    const newRow = createNewRow(i);
                    tbody.appendChild(newRow);
                }
            } else if (newCount < currentCount) {
                // Supprimer des lignes
                for (let i = currentCount - 1; i >= newCount; i--) {
                    tbody.removeChild(currentRows[i]);
                }
            }

            // Mettre à jour les RefAppTR
            const updatedRows = tbody.querySelectorAll('tr');
            updatedRows.forEach((row, index) => {
                const refAppTRInput = row.querySelector('input[name^="refAppTR_"]');
                if (refAppTRInput) {
                    refAppTRInput.value = index + 1;
                }
            });
        });
    }
});
