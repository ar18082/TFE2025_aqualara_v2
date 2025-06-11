// import { saisieTable } from './saisieTable.js';
// import { infoParam } from './saisieParametres.js';
// import { initializeSaisieEau } from './saisieEau.js';

// // Ajouter le token CSRF à toutes les requêtes AJAX
// //axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// export function initializeNavigation() {
//     const navigationConfig = {
//         btnChauff: { text: 'Chauffage', type: 'chauffage' },
//         btnEau: { text: 'Eau', type: 'eau' },
//         btnGaz: { text: 'Gaz', type: 'gaz' },
//         btnElec: { text: 'Electricité', type: 'elec' }
//     };

//     const title = document.getElementById('title');
//     title.innerText = 'Chauffage'; // État initial

//     // Initialiser les boutons de navigation
//     Object.entries(navigationConfig).forEach(([btnId, config]) => {
//         const button = document.getElementById(btnId);
//         if (!button) return;

//         button.addEventListener('click', () => {
//             // Réinitialiser tous les boutons
//             Object.keys(navigationConfig).forEach(id => {
//                 document.getElementById(id)?.classList.remove('active');
//             });

//             // Activer le bouton cliqué
//             button.classList.add('active');
//             title.innerText = config.text;

//             // Récupérer les paramètres nécessaires
//             const codeCli = parseInt(window.location.pathname.split('/')[2]);
//             const refAppTR = document.getElementById('currentRefAppTR')?.value || "1";
//             const typeRel = document.querySelector('[name="typeRel"]')?.value || "VISU";

//             // Émettre l'événement de changement de type
//             document.dispatchEvent(new CustomEvent('typeChanged', { 
//                 detail: { type: config.type }
//             }));

//             // Si c'est le type eau, initialiser la vue spéciale eau
//             if (config.type === 'eau') {
//                 initializeSaisieEau();
//             } else {
//                 // Sinon, mettre à jour les paramètres et la table normalement
//                 infoParam(codeCli, refAppTR, config.type);
//                 saisieTable(codeCli, refAppTR, config.type, typeRel);
//             }
//         });
//     });

//     // Gérer la sauvegarde des données
//     initializeSaveFunction();
// }

// function initializeSaveFunction() {
//     const btnSave = document.getElementById('btnSave');
//     if (!btnSave) return;

//     btnSave.addEventListener('click', async () => {
//         try {
//             if (!confirm('Voulez-vous enregistrer les données ?')) return;

//             const saveData = collectTableData();
//             await saveAndNavigateToNext(saveData);
//         } catch (error) {
//             console.error('Erreur lors de la sauvegarde:', error);
//             alert('Une erreur est survenue lors de la sauvegarde');
//         }
//     });
// }

// function collectTableData() {
//     const rows = document.querySelectorAll('#tableSaisie tbody tr');
//     const tableData = [];
    
//     rows.forEach(row => {
//         const rowData = {};
//         row.querySelectorAll('input, select').forEach(input => {
//             if (input.name) {
//                 rowData[input.name] = input.value;
//             }
//         });
//         if (Object.keys(rowData).length > 0) {
//             tableData.push(rowData);
//         }
//     });

//     return tableData;
// }

// async function saveAndNavigateToNext(saveData) {
//     try {
//         const codeCli = document.getElementById('codeCli');
//         const currentRefAppTR = document.getElementById('currentRefAppTR');
//         const dateReleve = document.getElementById('dateReleve');
//         const title = document.getElementById('title');
//         const typeRelInput = document.querySelector('[name="typeRel"]');
        

//         // Vérification de l'existence des éléments
//         if (!codeCli || !currentRefAppTR || !dateReleve || !title || !typeRelInput) {
//             throw new Error('Éléments manquants dans le formulaire');
//         }

//         // Log des valeurs pour le débogage
//         console.log('codeCli:', codeCli.value);
//         console.log('currentRefAppTR:', currentRefAppTR.value);
//         console.log('dateReleve:', dateReleve.value);
//         console.log('tableData:', saveData);

//         // Vérification des données obligatoires
//         if (!codeCli.value || !currentRefAppTR.value || !dateReleve.value || saveData.length === 0) {
//             let missingData = [];
//             if (!codeCli.value) missingData.push('codeCli');
//             if (!currentRefAppTR.value) missingData.push('currentRefAppTR');
//             if (!dateReleve.value) missingData.push('dateReleve');
//             if (saveData.length === 0) missingData.push('tableData');
//             throw new Error(`Données manquantes: ${missingData.join(', ')}`);
//         }

//         axios.post('/ajax/storeSaisie', {
//             codeCli: codeCli.value,
//             refAppTR: currentRefAppTR.value,
//             dateReleve: dateReleve.value,
//             tableData: saveData,
//             type: title.innerText.toLowerCase(),
//             typeRel: typeRelInput.value
//         })
//         .then(response => {
//             console.log(response.status);
//             if(response.status === 200){
//                 alert('Données sauvegardées avec succès');

//             }else{
//                 alert('Erreur lors de la sauvegarde');
//             }
//         })
//         .catch(error => {
//             console.error('Erreur lors de la sauvegarde:', error);
//             throw error;
//         });

//         // Passer au RefAppTR suivant
//         const nextResponse = await axios.get('/ajax/getNextRefAppTR', {
//             params: { codeCli: codeCli.value, currentRefAppTR: currentRefAppTR.value },
//         });

//         if (nextResponse.data.success && nextResponse.data.nextRefAppTR) {
//             currentRefAppTR.value = nextResponse.data.nextRefAppTR;
            
//             const refAppTRSelect = document.querySelector('select[name="refAppTR"]');
//             if (refAppTRSelect) {
//                 refAppTRSelect.value = nextResponse.data.nextRefAppTR;
//             }

//             const type = document.getElementById('title').innerText.toLowerCase();
//             const typeRel = document.querySelector('[name="typeRel"]').value;
//             await saisieTable(codeCli.value, nextResponse.data.nextRefAppTR, type, typeRel);
//         } else {
//             alert('Vous avez terminé tous les appartements');
//         }

//     } catch (error) {
//         console.error('Erreur lors de la sauvegarde:', error);
//         throw error;
//     }
// }

// // Initialiser la navigation quand le DOM est chargé
// document.addEventListener('DOMContentLoaded', initializeNavigation); 