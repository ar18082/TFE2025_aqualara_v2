document.addEventListener('DOMContentLoaded', function() {
    // Vérification de la page
    const url = window.location.pathname;
    const regex = /immeubles\/(\d+)\/details\/(chauffage|eau|gaz|electricite)/;
    const match = url.match(regex);
    
    if(match) {
        const type = match[2];
        // Correction de la classe pour l'électricité
        const inputClass = type === 'electricite' ? 'inputElectricite' : `input${type.charAt(0).toUpperCase() + type.slice(1)}`;
        
        // Initialisation des variables
        const btnEdit = document.getElementById('btn_edit');
        const btnSave = document.getElementById('btn_save');

        // Fonction pour activer/désactiver les champs
        function toggleInputs(enable) {
            const inputs = document.querySelectorAll(`.${inputClass}`);
            inputs.forEach(input => {
                input.disabled = !enable;
            });
            
            if(enable) {
                btnEdit.innerHTML = '<i class="fa-solid fa-xmark"></i> Annuler';
                btnEdit.style.backgroundColor = '#dc3545';
                btnEdit.style.color = 'white';
                btnSave.style.display = 'block';
            } else {
                btnEdit.innerHTML = '<i class="fa-solid fa-pen"></i> Modifier';
                btnEdit.style.backgroundColor = '#023c7b';
                btnEdit.style.color = 'white';
                btnSave.style.display = 'none';
            }
        }

        // Gestion de la touche § pour activer/désactiver les champs
        document.addEventListener('keydown', function(e) {
            if(e.key === '§') {
                const inputs = document.querySelectorAll(`.${inputClass}`);
                const isDisabled = inputs[0].disabled;
                toggleInputs(isDisabled);
            }
        });

        // Gestion du bouton modifier
        btnEdit.addEventListener('click', function() {
            const isCurrentlyEditing = this.innerHTML.includes('Annuler');
            toggleInputs(!isCurrentlyEditing);
        });
    }
}); 