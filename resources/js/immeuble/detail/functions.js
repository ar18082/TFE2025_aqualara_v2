import axios from 'axios';

// Fonction pour afficher le loader
export function showLoader(element) {
    if (element) {
        console.log('Showing loader');
        element.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Chargement...</span></div></div>';
    }
}

