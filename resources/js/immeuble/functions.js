// ecrire les fonctions pour les immeubles

// Cache pour les requêtes AJAX
const cache = new Map();

// Constantes pour les URLs
const API_URLS = {
    appartements: '/immeubles/ajaxRequest/getAppartements',
    details: '/immeubles/ajaxRequest/getDetails'
};

// Fonction utilitaire pour gérer les erreurs
function handleError(error, context) {
    console.error(`Erreur dans ${context}:`, error);
    showNotification(`Une erreur est survenue lors de ${context}`, 'error');
}

// Fonction pour afficher les notifications
function showNotification(message, type = 'info') {
    // Vous pouvez implémenter votre système de notification ici
    console.log(`${type.toUpperCase()}: ${message}`);
}

// Fonction pour afficher le loader
export function showLoader(element) {
    if (element) {
        element.innerHTML = `
            <div class="d-flex justify-content-center align-items-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>
        `;
    }
}

export async function getAppartements(codecli) {
    const cacheKey = `appartements_${codecli}`;
    
    // Vérifier le cache
    if (cache.has(cacheKey)) {
        return cache.get(cacheKey);
    }

    try {
        const response = await axios.get(`${API_URLS.appartements}/${codecli}`);
        const data = response.data;
        
        // Mettre en cache
        cache.set(cacheKey, data);
        
        return data;
    } catch (error) {
        handleError(error, 'la récupération des appartements');
        throw error;
    }
}

export async function getDetail(codecli) {
    const cacheKey = `detail_${codecli}`;
    
    // Vérifier le cache
    if (cache.has(cacheKey)) {
        return cache.get(cacheKey);
    }

    try {
        const response = await axios.get(`${API_URLS.details}/${codecli}`);
        const html = response.data;
        
        // Mettre en cache
        cache.set(cacheKey, html);
        
        // Afficher le contenu dans le conteneur
        const container = document.getElementById('show_immeuble_content');
        if (container) {
            container.innerHTML = html;
            
            // Déclencher l'événement contentChanged
            const event = new Event('immeubleContentChanged');
            document.dispatchEvent(event);
        }
        
        return html;
    } catch (error) {
        if (error.response && error.response.status === 404) {
            console.error('Client non trouvé');
            // Afficher un message d'erreur à l'utilisateur
            const container = document.getElementById('show_immeuble_content');
            if (container) {
                container.innerHTML = '<div class="alert alert-danger">Client non trouvé</div>';
            }
        } else {
            console.error('Erreur lors de la récupération des détails:', error);
            handleError(error, 'la récupération des détails');
        }
        throw error;
    }
}

// Fonction pour mettre à jour l'interface des détails
function updateDetailUI(data) {
    const updates = {
        'codeImmeubleValue': `<span style="color: grey">Code immeuble :</span> ${data.Codecli}`,
        'referenceTRValue': `<span style="color: grey">Référence T.R. :</span> ${data.Codecli}`,
        'nameImmeuble': `<span style="color: grey">Nom :</span> ${data.nom}`,
        'addressImmeuble': `<span style="color: grey">Rue : </span> ${data.rue}`,
        'codePaysImmeuble': `<span style="color: grey">Code Pays :</span> ${data.codepays}`,
        'cpImmeuble': `<span style="color: grey">Postal :</span> ${data.codepost} ${data.code_postelbs?.[0]?.Localite || ''}`,
        'langueDecompteImmeuble': `<span style="color: grey">Langue Décompte :</span> ${data.gerant_imms?.[0]?.contacts?.[0]?.codlng || 'FR'}`,
        'phoneImmeuble': `<span style="color: grey">Téléphone :</span> ${data.tel || 'Non renseigné'}`,
        'nbAppart': `<span style="color: grey">Nombre d'appartements :</span> ${data.nbAppartement ?? 0}`
    };

    // Mise à jour des champs
    Object.entries(updates).forEach(([id, content]) => {
        const element = document.getElementById(id);
        if (element) {
            element.innerHTML = content;
        }
    });

    // Mise à jour du champ remarque
    const remarqueElement = document.getElementById('remarque');
    if (remarqueElement) {
        remarqueElement.value = data.remarque || '';
    }

    // Mise à jour des types d'appareils
    updateTypeAppareils(data);
}

// Fonction pour mettre à jour les types d'appareils
function updateTypeAppareils(data) {
    const typeAppareilPresent = document.getElementById('typeAppareilPresent');
    if (!typeAppareilPresent) return;

    typeAppareilPresent.innerHTML = '';
    
    const appareils = [
        { condition: data.clichaufs.length > 0, title: 'Chauffage' },
        { condition: data.cli_eaus.length > 0, title: 'Eau' },
        { condition: data.DecompteUnite === 1, title: 'Decompte unitaire', icon: true }
    ];

    appareils.forEach(({ condition, title, icon }) => {
        if (condition) {
            const li = document.createElement('li');
            const titleh5 = document.createElement('h5');
            titleh5.className = 'card-title';
            titleh5.innerHTML = icon 
                ? `${title} <span style="color: green"><i class="fa-solid fa-circle-check"></i></span>`
                : title;
            li.appendChild(titleh5);
            typeAppareilPresent.appendChild(li);
        }
    });
}


