document.addEventListener('DOMContentLoaded', function() {
    if (window.location.pathname === '/facturation/tri') {
        try {
            // Sélectionnez tous les boutons ayant un id qui commence par "facturable-"
            var buttons = document.querySelectorAll('[id^="facturable-"]');

            // Parcourez tous les boutons et ajoutez un écouteur d'événements à chacun
            buttons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var eventId = button.id.split('-').pop(); // Récupérez l'ID de l'événement à partir de l'ID du bouton
                    var inputId = 'facturable-' + eventId; // Construisez l'ID de l'input correspondant
                    var inputValue;

                    // Déterminez la valeur en fonction de l'ID du bouton
                    switch (button.id.split('-')[1]) {
                        case 'oui':
                            inputValue = 1;
                            break;
                        case 'non':
                            inputValue = 2;
                            break;
                        case 'planifier':
                            inputValue = 3;
                            break;
                    }

                    // Vérifiez si le bouton est déjà sélectionné
                    if (button.classList.contains('btn-success')) {
                        // Désélectionnez le bouton et réinitialisez la valeur de l'input
                        button.classList.remove('btn-success');
                        inputValue = ''; // Supprimez la valeur si le bouton est désélectionné
                    } else {
                        // Sélectionnez le bouton et mettez à jour la valeur de l'input
                        button.classList.add('btn-success');
                    }

                    // Désélectionnez les autres boutons du même groupe
                    buttons.forEach(function (btn) {
                        if (btn.id !== button.id && btn.id.includes('-' + eventId)) {
                            btn.classList.remove('btn-success');
                        }
                    });

                    // Mettez à jour la valeur de l'input
                    document.getElementById(inputId).value = inputValue;
                });


            });
        } catch (e) {

        }
        try {


            document.getElementById('submitTriSelect').addEventListener('click', function () {
                var selectedValues = []; // Tableau pour stocker les objets {id_event, action}

                // Parcourez tous les boutons de facturation
                buttons.forEach(function (button) {
                    var eventId = button.id.split('-').pop(); // Récupérez l'ID de l'événement à partir de l'ID du bouton
                    var inputId = 'facturable-' + eventId; // Construisez l'ID de l'input correspondant

                    // Vérifiez si le bouton est sélectionné
                    if (button.classList.contains('btn-success')) {

                        selectedValues.push({
                            id_event: eventId,
                            action: document.getElementById(inputId).value
                        });
                    }
                });


                // Exemple d'envoi des données à un backend via Axios
                axios.post('resultTriAjax', selectedValues)
                    .then(function (response) {
                        console.log(response.data);
                        window.location.reload();
                    })
                    .catch(function (error) {
                        console.error(error);
                    });


            });


        } catch (e) {

        }

    }
});







