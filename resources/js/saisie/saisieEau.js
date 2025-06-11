import { apiService } from './services/apiService.js';
import { infoParam } from './saisieParametres.js';
import { typeConfig } from './config/types.js';

export function initializeSaisieEau() {
    const table = document.getElementById('tableEau');
    if (!table) return;

    const codeCli = window.location.pathname.split('/')[2];
    const refAppTR = document.getElementById('currentRefAppTR')?.value || "1";
    
    // Initialiser les paramètres pour l'eau
    infoParam(codeCli, refAppTR, 'eau');
    
    // Initialiser le tableau
    initializeTable(table);
    fetchAndPopulateData(table, codeCli, refAppTR);
    initializeEventListeners(table);
}

function initializeTable(table) {
    // Créer l'en-tête du tableau
    const thead = table.querySelector('thead');
    thead.innerHTML = '';
    const headerRow = document.createElement('tr');
    
    typeConfig.eau.columns.forEach(column => {
        const th = document.createElement('th');
        th.textContent = column.title;
        headerRow.appendChild(th);
    });
    
    thead.appendChild(headerRow);
}

async function fetchAndPopulateData(table, codeCli, refAppTR) {
    try {
        // Récupérer les données d'eau froide et chaude
        const [eauFroideData, eauChaudeData] = await Promise.all([
            apiService.getParameters(codeCli, refAppTR, 'eaufroide'),
            apiService.getParameters(codeCli, refAppTR, 'eauchaude')
        ]);

        const tbody = table.querySelector('tbody');
        tbody.innerHTML = '';

        // Fusionner et organiser les données
        const compteurs = new Map();
        
        // Traiter l'eau froide
        eauFroideData.relEauFs?.forEach(compteur => {
            compteurs.set(compteur.NumCpt, {
                NoCpt: compteur.NoCpt,
                NumCpt: compteur.NumCpt,
                Statut: compteur.Statut,
                Sit: compteur.Sit,
                AncIdxF: compteur.AncIdx,
                NvIdxF: compteur.NvIdx
            });
        });

        // Traiter l'eau chaude
        eauChaudeData.relEauCs?.forEach(compteur => {
            const existing = compteurs.get(compteur.NumCpt) || {
                NoCpt: compteur.NoCpt,
                NumCpt: compteur.NumCpt,
                Statut: compteur.Statut,
                Sit: compteur.Sit
            };
            
            existing.AncIdxC = compteur.AncIdx;
            existing.NvIdxC = compteur.NvIdx;
            
            compteurs.set(compteur.NumCpt, existing);
        });

        // Créer les lignes du tableau
        compteurs.forEach((data, numCpt) => {
            const tr = document.createElement('tr');
            
            typeConfig.eau.columns.forEach(column => {
                const td = document.createElement('td');
                
                if (column.type === 'select') {
                    const select = document.createElement('select');
                    select.name = `${column.field}_${numCpt}`;
                    select.className = 'form-control';
                    
                    column.options.forEach(option => {
                        const opt = document.createElement('option');
                        opt.value = option;
                        opt.textContent = option;
                        opt.selected = data[column.field] === option;
                        select.appendChild(opt);
                    });
                    
                    td.appendChild(select);
                } else {
                    const input = document.createElement('input');
                    input.type = column.type || 'text';
                    input.name = `${column.field}_${numCpt}`;
                    input.value = data[column.field] || '';
                    input.className = `form-control ${column.class || ''}`;
                    input.readOnly = column.readonly || false;
                    
                    td.appendChild(input);
                }
                
                tr.appendChild(td);
            });
            
            tbody.appendChild(tr);
        });

    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
    }
}

function initializeEventListeners(table) {
    // Gérer le déverrouillage des colonnes
    document.addEventListener('keydown', (event) => {
        if (event.key === '§') {
            const inputs = table.querySelectorAll('.inputSaisieNvIdx');
            inputs.forEach(input => {
                input.readOnly = !input.readOnly;
                input.classList.toggle('unlocked');
            });
        }
    });

    // Calculer les différences et valider les index
    table.addEventListener('change', (event) => {
        if (event.target.classList.contains('inputSaisieNvIdx')) {
            const tr = event.target.closest('tr');
            const newValue = parseFloat(event.target.value);
            const oldValue = parseFloat(
                event.target.name.includes('NvIdxF') 
                    ? tr.querySelector('[name^="AncIdxF"]').value 
                    : tr.querySelector('[name^="AncIdxC"]').value
            );
            
            if (newValue < oldValue) {
                alert('La valeur du nouvel index est inférieure à l\'ancien index');
            }
        }
    });
} 