// Fonction pour mettre à jour les paramètres
function updateParametres(refAppTR, parametres) {

    const params = Object.values(parametres).find(p => {
        return String(p.RefAppTR) === String(refAppTR); 
    });

    if (params) {
      
        document.getElementById('fraisDiv').value = params.FraisDiv || '';
        document.getElementById('nbFraisTR').value = params.NbFraisTR || '';
        document.getElementById('pctFraisAnn').value = params.PctFraisAnn || '';
        document.getElementById('appQuot').value = params.AppQuot || '';
        document.getElementById('nbRad').value = params.NbRad || '';
        document.getElementById('nbCptEauFroid').value = params.NbCptFroid || '';
        document.getElementById('nbCptEauChaud').value = params.NbCptChaud || '';
        document.getElementById('provision').value = params.Provision || '';
        document.getElementById('nbCpt').value = params.NbCpt || '';
        
    }
}

// Fonction pour gérer l'affichage des champs en fonction du type sélectionné
function handleTypeSelection(type) {
    // Masquer tous les groupes de paramètres spécifiques
    const paramChauff = document.querySelectorAll('.paramChauff');
    const paramEau = document.querySelectorAll('.paramEau');
    const paramGazElec = document.querySelectorAll('.paramGazElec');
    
    // Réinitialiser tous les affichages
    paramChauff.forEach(el => {
        // Supprimer les styles inline pour éviter les conflits
        el.removeAttribute('style');
        el.style.display = 'none';
    });
    
    paramEau.forEach(el => {
        el.removeAttribute('style');
        el.style.display = 'none';
    });
    
    paramGazElec.forEach(el => {
        el.removeAttribute('style');
        el.style.display = 'none';
    });
    
    // Afficher les champs appropriés en fonction du type
    switch(type) {
        case 'chauffage':
            paramChauff.forEach(el => el.style.display = 'block');
            break;
        case 'eau':
            paramEau.forEach(el => el.style.display = 'block');
            break;
        case 'gaz':
        case 'elec':
            paramGazElec.forEach(el => el.style.display = 'block');
            break;
    }
}

// Initialiser les paramètres avec le premier RefAppTR
document.addEventListener('DOMContentLoaded', function() {
    // if window.location.pathname == regex /immeubles/3/saisie/chauffage
    if (window.location.pathname.includes('/immeubles/') && window.location.pathname.includes('/saisie/')) {
        const parametres = window.parametres || [];
        
        // Écouter le changement de RefAppTR
        document.getElementById('refAppTR').addEventListener('change', function(e) {
                // remove les options selected et selected celui qui a la valeur de e.target.valu
                updateParametres(e.target.value, parametres);
        });

        // Écouter les clics sur les boutons de type
        const btnChauff = document.getElementById('btnChauff');
        const btnEau = document.getElementById('btnEau');
        const btnGaz = document.getElementById('btnGaz');
        const btnElec = document.getElementById('btnElec');
        
        if (btnChauff) {
            btnChauff.addEventListener('click', function() {
                handleTypeSelection('chauffage');
            });
        }
        
        if (btnEau) {
            btnEau.addEventListener('click', function() {
                handleTypeSelection('eau');
            });
        }
        
        if (btnGaz) {
            btnGaz.addEventListener('click', function() {
                handleTypeSelection('gaz');
            });
        }
        
        if (btnElec) {
            btnElec.addEventListener('click', function() {
                handleTypeSelection('elec');
            });
        }
    
        const refAppTRSelect = document.getElementById('refAppTR');
        if (refAppTRSelect.value) {
            updateParametres(refAppTRSelect.value, parametres);
        }
        
        // Déterminer le type actuel à partir de l'URL
        const path = window.location.pathname;
        if (path.includes('/chauffage')) {
            handleTypeSelection('chauffage');
        } else if (path.includes('/eau')) {
            handleTypeSelection('eau');
        } else if (path.includes('/gaz')) {
            handleTypeSelection('gaz');
        } else if (path.includes('/elec')) {
            handleTypeSelection('elec');
        }
    }
}); 