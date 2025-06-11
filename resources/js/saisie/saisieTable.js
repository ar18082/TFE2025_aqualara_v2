import { typeConfig } from './config/types.js';

export function saisieTable(codeCli, refAppTR, type, typeRel) {
    console.log('saisieTable appelée avec:', { codeCli, refAppTR, type, typeRel });
    
    const config = typeConfig[type];
    if (!config || typeRel !== 'VISU') {
        console.log('Configuration non trouvée ou typeRel incorrect:', { config, typeRel });
        return;
    }

    const tableSaisie = document.getElementById('tableSaisie');
    if (!tableSaisie) {
        console.log('Table non trouvée');
        return;
    }

    console.log('Configuration trouvée:', config);
    createTable(tableSaisie, config, codeCli, refAppTR, type, typeRel);
}

function createTable(table, config, codeCli, refAppTR, type, typeRel) {
    console.log('Création de la table avec:', { config, codeCli, refAppTR, type, typeRel });
    table.innerHTML = '';
    table.appendChild(createHeader(config.columns));
    
    fetchAndPopulateData(table, config, codeCli, refAppTR, type, typeRel);
}

function createHeader(columns) {
    console.log('Création des en-têtes avec:', columns);
    const thead = document.createElement('thead');
    const tr = document.createElement('tr');
    
    columns.forEach((col, index) => {
        const th = document.createElement('th');
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'col-title-btn';
        button.dataset.col = index;
        button.textContent = col.title;
        th.appendChild(button);
        tr.appendChild(th);
    });
    
    thead.appendChild(tr);
    return thead;
}

function createCell(column, value, rowIndex) {
    console.log('Création cellule:', { column, value, rowIndex });
    const td = document.createElement('td');
    let input;

    if (column.type === 'select') {
        input = document.createElement('select');
        column.options.forEach(opt => {
            const option = document.createElement('option');
            option.value = opt;
            option.textContent = opt;
            input.appendChild(option);
        });
    } else {
        input = document.createElement('input');
        input.type = column.type || 'text';
        input.value = value || '';
    }

    input.name = column.field;
    input.className = `table-input ${column.class || ''}`.trim();
    if (column.readonly) input.readOnly = true;
    if (column.class === 'inputSaisieAncIdx') input.id = `${rowIndex}AncIdx`;
    if (column.class === 'inputSaisieNvIdx') input.id = `${rowIndex}_NvIdx`;

    td.appendChild(input);
    return td;
}

function calculateDifference(newValue, oldValue, diffInput) {
    const diff = parseFloat(newValue) - parseFloat(oldValue);
    diffInput.value = diff;
    
    if (parseFloat(newValue) < parseFloat(oldValue)) {
        alert('La valeur de l\'index nouveau est inférieure à la valeur de l\'index ancien');
    }
}

function fetchAndPopulateData(table, config, codeCli, refAppTR, type, typeRel) {
    console.log('Début fetchAndPopulateData avec:', { codeCli, refAppTR, type, typeRel });
    
    const params = { codeCli, refAppTR, type, typeRel };
    console.log('Paramètres de la requête:', params);

    axios.get('/ajax/saisieRelAjax', { params })
        .then(response => {
            console.log('Réponse reçue:', response);
            console.log('Données reçues:', response.data);

            if (!Array.isArray(response.data)) {
                console.error('Les données reçues ne sont pas un tableau:', response.data);
                return;
            }

            const tbody = document.createElement('tbody');
            response.data.forEach((row, rowIndex) => {
                console.log('Traitement ligne:', { rowIndex, row });
                const tr = document.createElement('tr');
                config.columns.forEach(column => {
                    tr.appendChild(createCell(column, row[column.field], rowIndex));
                });
                tbody.appendChild(tr);
            });
            
            table.appendChild(tbody);

            console.log('Table remplie avec succès');

            // Ajout des event listeners
            document.querySelectorAll('.inputSaisieNvIdx').forEach((input, index) => {
                input.addEventListener('change', function() {
                    const ancienIndex = document.getElementById(`${index}AncIdx`);
                    const diffInput = this.closest('tr').querySelector('[name="diff"]');
                    calculateDifference(this.value, ancienIndex.value, diffInput);
                });
            });
        })
        .catch(error => {
            console.error('Erreur lors de la requête:', error);
            console.error('Détails de l\'erreur:', error.response?.data);
        });
}
