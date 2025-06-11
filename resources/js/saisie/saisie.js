import { initializeNavigation } from './saisieNavigation.js';
import { initializeAppartement } from './saisieAppartement.js';
import { saisieTable } from './saisieTable.js';
document.addEventListener("DOMContentLoaded", function() {
    if (!/^\/immeubles\/.+/.test(window.location.pathname)) return;

    

    // Initialiser les modules
    initializeNavigation();
    initializeAppartement();


    // Verrouiller tous les inputs par défaut
    const allInputs = document.querySelectorAll('input, select');
    allInputs.forEach(input => input.setAttribute('readonly', true));

    // Gestionnaire pour le déverrouillage des paramètres
    document.addEventListener('keydown', function(event) {
        if (event.key === '(') {
            toggleInputs('.section-params input, .section-params select');
        } else if (event.key === '§') {
            toggleInputs('#tableSaisie input, #tableSaisie select');
        }
    });
});

function toggleInputs(selector) {
    const inputs = document.querySelectorAll(selector);
    const isReadOnly = inputs[0]?.hasAttribute('readonly');
    
    inputs.forEach(input => {
        if (isReadOnly) {
            input.removeAttribute('readonly');
        } else {
            input.setAttribute('readonly', true);
        }
    });
}


