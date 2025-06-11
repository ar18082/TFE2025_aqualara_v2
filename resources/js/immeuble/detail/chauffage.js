document.addEventListener('DOMContentLoaded', function() {
    // Vérification de la page
    const url = window.location.pathname;
    const regex = /immeubles\/(\d+)\/details\/chauffage/;
    const match = url.match(regex);
    
    if(match) {
        // Initialisation des variables
        const checkboxPourcentage = document.getElementById('pourcentage');
        const checkboxMontant = document.getElementById('montant');
        const inputPctPrive = document.getElementById('PctPrive');
        const inputPctCom = document.getElementById('PctCom');
        const inputConsommationPrive = document.getElementById('consommationPrive');
        const inputConsommationCommun = document.getElementById('consommationCommun');
        const inputConsommation = document.getElementById('Consom');

        const btnEdit = document.getElementById('btn_edit');
        const btnSave = document.getElementById('btn_save');

        // Gestion de la touche § pour activer/désactiver les champs
        document.addEventListener('keydown', function(e) {
            if(e.key === '§') {
                const inputs = document.querySelectorAll('.inputChauffage');
                inputs.forEach(input => {
                    // controler si l'input est disabled
                    if(input.disabled){
                        input.disabled = false;
                    }else{
                        input.disabled = true;
                    }
                });
                if(btnEdit.innerText === 'Modifier'){
                    btnEdit.innerText = 'Annuler';
                    btnEdit.style.backgroundColor = '#dc3545';
                    btnEdit.style.color = 'white';
                    btnSave.style.display = 'block';
                }else{
                    btnEdit.innerText = 'Modifier';
                    btnEdit.style.backgroundColor = '#023c7b';
                    btnEdit.style.color = 'white';
                    btnSave.style.display = 'none';
                }
            }
        });

        // Gestion du bouton modifier
        btnEdit.addEventListener('click', function() {
            const inputs = document.querySelectorAll('.inputChauffage');
            // si on est en lecture on doit passer en edition 
            if(this.innerText === 'Modifier'){
                inputs.forEach(input => {
                    input.disabled = false;
                });
                   this.innerText = 'Annuler';
                   this.style.backgroundColor = '#dc3545';
                   this.style.color = 'white';
                   btnSave.style.display = 'block';
            }else{
                inputs.forEach(input => {
                    input.disabled = true;
                });
                this.innerText = 'Modifier';
                this.style.backgroundColor = '#023c7b';
                this.style.color = 'white';
                btnSave.style.display = 'none';
            }

        });
    

        // Mode Pourcentage
        checkboxPourcentage.addEventListener('change', function() {
            if (checkboxPourcentage.checked) {
                // Désactiver le mode montant
                checkboxMontant.checked = false;
                inputConsommationPrive.disabled = true;
                inputConsommationCommun.disabled = true;
                
                // Activer le mode pourcentage
                inputPctPrive.disabled = false;
                inputPctCom.disabled = false;

                // Calculs automatiques pour le pourcentage privé
                inputPctPrive.addEventListener('change', function() {
                    const pctPrive = parseFloat(inputPctPrive.value) || 0;
                    const consommation = parseFloat(inputConsommation.value) || 0;
                    
                    inputPctCom.value = 100 - pctPrive;
                    inputConsommationCommun.value = (consommation / 100) * (100 - pctPrive);
                    inputConsommationPrive.value = (consommation / 100) * pctPrive;
                });

                // Calculs automatiques pour le pourcentage commun
                inputPctCom.addEventListener('change', function() {
                    const pctCom = parseFloat(inputPctCom.value) || 0;
                    const consommation = parseFloat(inputConsommation.value) || 0;
                    
                    inputPctPrive.value = 100 - pctCom;
                    inputConsommationCommun.value = (consommation / 100) * pctCom;
                    inputConsommationPrive.value = (consommation / 100) * (100 - pctCom);
                });
            }
        });

        // Mode Montant
        checkboxMontant.addEventListener('change', function() {
            if (checkboxMontant.checked) {
                // Désactiver le mode pourcentage
                checkboxPourcentage.checked = false;
                inputPctPrive.disabled = true;
                inputPctCom.disabled = true;
                
                // Activer le mode montant
                inputConsommationPrive.disabled = false;
                inputConsommationCommun.disabled = false;

                // Calculs automatiques pour le montant privé
                inputConsommationPrive.addEventListener('change', function() {
                    const consommationPrive = parseFloat(inputConsommationPrive.value) || 0;
                    const consommation = parseFloat(inputConsommation.value) || 0;
                    
                    inputConsommationCommun.value = consommation - consommationPrive;
                    inputPctPrive.value = Math.round((consommationPrive / consommation) * 100);
                    inputPctCom.value = 100 - inputPctPrive.value;
                });

                // Calculs automatiques pour le montant commun
                inputConsommationCommun.addEventListener('change', function() {
                    const consommationCommun = parseFloat(inputConsommationCommun.value) || 0;
                    const consommation = parseFloat(inputConsommation.value) || 0;
                    
                    inputConsommationPrive.value = consommation - consommationCommun;
                    inputPctCom.value = Math.round((consommationCommun / consommation) * 100);
                    inputPctPrive.value = 100 - inputPctCom.value;
                });
            }
        });

        // Gestion des changements de consommation totale
        inputConsommation.addEventListener('change', function() {
            const consommation = parseFloat(inputConsommation.value) || 0;
            
            if (checkboxPourcentage.checked) {
                const pctPrive = parseFloat(inputPctPrive.value) || 0;
                inputConsommationPrive.value = (consommation / 100) * pctPrive;
                inputConsommationCommun.value = (consommation / 100) * (100 - pctPrive);
            } else if (checkboxMontant.checked) {
                const consommationPrive = parseFloat(inputConsommationPrive.value) || 0;
                inputConsommationCommun.value = consommation - consommationPrive;
            }
        });
    }
});

