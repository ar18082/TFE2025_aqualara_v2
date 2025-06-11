document.addEventListener('DOMContentLoaded', function() {
    if(window.location.pathname.match(/immeubles\/(\d+)\/saisie/)) {
        const createDate = document.getElementById('createDate');
        const dateRlv = document.getElementById('dateRlv');
        const messageContainer = document.getElementById('message-container');
        const alertMessage = document.getElementById('alert-message');
        
        // Function to display messages
        function showMessage(message, type) {
            alertMessage.textContent = message;
            alertMessage.className = `alert alert-${type}`;
            messageContainer.style.display = 'block';
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                messageContainer.style.display = 'none';
            }, 5000);
        }
        
        document.addEventListener('keydown', function(e) {
            const codecli = window.location.pathname.split('/')[2];
            if(e.key === '+') {
                e.preventDefault();
                // create a new option in the dateRlv select
                const newOption = document.createElement('option');
                const formattedDate = new Date(createDate.value).toLocaleDateString('fr-FR').replace(/\//g, '-');                
                newOption.value = formattedDate;
                newOption.textContent = formattedDate;
                newOption.selected = true;
                dateRlv.appendChild(newOption);
                // focus on the new option
                newOption.focus();

                console.log(createDate.value);
                axios.post('/immeubles/'+codecli+'/saisie/getDateReleve', {
                    date: createDate.value
                })
                .then(response => {
                    if (response.data.success) {
                        showMessage(response.data.message || 'Date de décompte ajoutée avec succès', 'success');
                    } else {
                        showMessage(response.data.message || 'Erreur lors de l\'ajout de la date de décompte', 'warning');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('Une erreur est survenue lors de la communication avec le serveur ' + error, 'danger');
                });
            }
            if(e.key === '-') {
                e.preventDefault();
                // remove the option selected in the dateRlv select
                // get the selected option
                const selectedOption = dateRlv.querySelector('option:checked');
                console.log(selectedOption.value);
                if(selectedOption) {
                    axios.post('/immeubles/'+codecli+'/saisie/removeDateReleve', {
                        date: selectedOption.value
                    })
                    .then(response => {
                        if (response.data.success) {
                            showMessage('Date de décompte supprimée', 'info');
                            selectedOption.remove();
                        } else {
                            showMessage(response.data.message || 'Erreur lors de la suppression de la date de décompte', 'warning');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('Une erreur est survenue lors de la communication avec le serveur', 'danger');
                    });
                    
                }
            }
        });
    }
});

