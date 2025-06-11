// Import du fichier commun
import './common.js';

document.addEventListener('DOMContentLoaded', function() {
    // Vérification de la page
    const url = window.location.pathname;
    const regex = /immeubles\/(\d+)\/details\/eau/;
    const match = url.match(regex);
    
    if(match) {
        // Initialisation des variables spécifiques à l'eau si nécessaire
    }
}); 