<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration de l'Intersection Observer
    const observerOptions = {
        root: null,
        rootMargin: '50px',
        threshold: 0.1
    };

    // Observer pour les images
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy-load');
                observer.unobserve(img);
            }
        });
    }, observerOptions);

    // Observer pour les composants
    const componentObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const component = entry.target;
                loadComponent(component);
                observer.unobserve(component);
            }
        });
    }, observerOptions);

    // Initialisation du lazy loading pour les images
    document.querySelectorAll('img.lazy-load').forEach(img => {
        imageObserver.observe(img);
    });

    // Initialisation du lazy loading pour les composants
    document.querySelectorAll('div.lazy-load[data-component]').forEach(component => {
        componentObserver.observe(component);
    });

    // Fonction pour charger un composant
    async function loadComponent(element) {
        try {
            const componentName = element.dataset.component;
            const props = JSON.parse(element.dataset.props || '{}');

            // Appel à l'API pour charger le composant
            const response = await fetch(`/api/components/${componentName}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(props)
            });

            if (!response.ok) {
                throw new Error('Erreur lors du chargement du composant');
            }

            const html = await response.text();
            element.innerHTML = html;

            // Initialisation des scripts du composant si nécessaire
            initializeComponentScripts(element);
        } catch (error) {
            console.error('Erreur lors du chargement du composant:', error);
            element.innerHTML = '<div class="error">Erreur lors du chargement du composant</div>';
        }
    }

    // Fonction pour initialiser les scripts d'un composant
    function initializeComponentScripts(element) {
        // Recherche des scripts dans le composant
        const scripts = element.getElementsByTagName('script');
        
        // Exécution de chaque script
        Array.from(scripts).forEach(oldScript => {
            const newScript = document.createElement('script');
            
            // Copie des attributs
            Array.from(oldScript.attributes).forEach(attr => {
                newScript.setAttribute(attr.name, attr.value);
            });
            
            // Copie du contenu
            newScript.textContent = oldScript.textContent;
            
            // Remplacement de l'ancien script
            oldScript.parentNode.replaceChild(newScript, oldScript);
        });
    }
});
</script>

<style>
.lazy-load {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.lazy-load.loaded {
    opacity: 1;
}
</style> 