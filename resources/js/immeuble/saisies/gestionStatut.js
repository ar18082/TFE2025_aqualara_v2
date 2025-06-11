document.addEventListener('DOMContentLoaded', function() {
    if(window.location.pathname.includes('immeubles') && window.location.pathname.includes('saisies') && window.location.pathname.includes('chauffage')){
        const statutChauff = document.getElementById('saisieStatut');
        statutChauff.addEventListener('change', function() {
            console.log(statutChauff.value);
            // ouvrir une modal avec un formulaire 
            switch(statutChauff.value){
                case 'nouveau':
                    // ouvrir la modal avec le formulaire de nouveau
                    break;
                case 'remplacer':
                    // ouvrir la modal avec le formulaire de remplacer
                    break;
                case 'refix':
                    // ouvrir la modal avec le formulaire de refix
                    break;
                case 'supprimer':
                   
                    break;
            }
        });
    }

    if(window.location.pathname.includes('immeubles') && window.location.pathname.includes('saisies') && window.location.pathname.includes('eau')){
        const statutEau = document.getElementById('saisieStatut');
        statutEau.addEventListener('change', function() {
            console.log(statutEau.value);
        });
    }
});