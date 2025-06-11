document.addEventListener('DOMContentLoaded', function() {
    // verifier si dans l'url contient immeuble/{codecli}/details regex 
    const url = window.location.pathname;
    const regex = /immeubles\/(\d+)\/details\/definition/;
    const match = url.match(regex);
  
    if(match){
    
         // recuperer le btn_edit 
        const btnEdit = document.getElementById('btn_edit');
        const btnSave = document.getElementById('btn_save');
       
        // recuperer les span display-value 
        const displayValue = document.querySelectorAll('.display-value');
        // recuperer les input edit-value   
        const editValue = document.querySelectorAll('.edit-value');

        // ajouter un event listener sur le btn_edit
        btnEdit.addEventListener('click', function() {
        // checker si on est en lecture ou en edition 
        if(btnEdit.innerText === 'Modifier'){
            // on est en lecture  on doit passé en édition les display-value display none et les edit-value display block
            displayValue.forEach(function(span){
                span.style.display = 'none';
            });
            editValue.forEach(function(input){
                input.style.display = 'block';
            }); 

            // on modifier le btn_edit pour qu'il affiche Annuler en modifiant le i il faut que le background soit rouge
            btnEdit.innerHTML = '';
            btnEdit.innerHTML = '<i class="fa-solid fa-xmark"></i> Annuler';
            btnEdit.style.backgroundColor = '#dc3545';
            // on afficher le btn_save
            btnSave.style.display = 'block';
        
        }else if(btnEdit.innerText === 'Annuler'){
            // on est en edition et on doit repasser en lecture les display-value display block et les edit-value display none
            displayValue.forEach(function(span){
                span.style.display = 'block';
            });
            editValue.forEach(function(input){
                input.style.display = 'none';
            });

            // on modifier le btn_edit pour qu'il affiche Modifier en modifiant le i
            btnEdit.innerHTML = '';
            btnEdit.innerHTML = '<i class="fa-solid fa-pen"></i> Modifier';
            btnEdit.style.backgroundColor = '#023c7b';

            // on masquer le btn_save
            btnSave.style.display = 'none';

        }
        });
    }
   
});
