document.addEventListener('DOMContentLoaded', function() {
    if (window.location.pathname.includes('/admin/event')) {

    // apparition de la checkbox pour les interventions de type 6 (placement)
        var typeIntervention = document.getElementById('typeIntervention');
        var startDate = document.getElementById('startDate');
        var endDate = document.getElementById('endDate');

        var firstPlt = document.getElementById('firstPlt');
        if (firstPlt) {
            firstPlt.style.display = 'none';
        }
        if (typeIntervention) {
            typeIntervention.addEventListener('change', function() {
                if(typeIntervention.value === '6') {

                    firstPlt.style.display = 'block';
                }else {
                    firstPlt.style.display = 'none';
                }
            });
        }


        if(startDate){
            startDate.addEventListener('change', function() {
                 endDate.value = startDate.value ;
            });
        }



        // const selectShift = document.getElementById('selectShift');
        // const startTimeInput = document.getElementById('startTime');
        // const endTimeInput = document.getElementById('endTime');
        // if (selectShift != null){
        //
        //     selectShift.addEventListener('change', function() {
        //         // Obtenez la valeur sélectionnée dans le select
        //         const selectedValue = selectShift.value;
        //
        //         // Mettez à jour les valeurs des champs d'heure en fonction de la sélection
        //         switch(selectedValue) {
        //             case 'allDay':
        //                 startTimeInput.value = '08:30';
        //                 endTimeInput.value = '17:00';
        //                 break;
        //             case 'AM':
        //                 startTimeInput.value = '08:30';
        //                 endTimeInput.value = '12:00';
        //                 break;
        //             case 'PM':
        //                 startTimeInput.value = '12:30';
        //                 endTimeInput.value = '16:30';
        //                 break;
        //             default:
        //                 startTimeInput.value = '';
        //                 endTimeInput.value = '';
        //                 break;
        //         }
        //     });
        // }

        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('formEvent');
            document.getElementById('submitFormEvent').addEventListener('click', function () {
                form.submit();

            });

        });

        var btnDropdownAppartements = document.getElementById('btnDropdownAppartements');
        btnDropdownAppartements.style.display = 'none';

        // Écoutez l'événement 'select2:select' sur le select avec l'id 'clientSelect'
        $('#clientSelect').on('select2:select', function (e) {
            // Obtenez l'id du client sélectionné
            var clientId = e.params.data.id;


            // Faites une requête AJAX pour obtenir les appartements de ce client
            $.ajax({
                url: 'appartementsAjax/' + clientId,
                type: 'GET',
                success: function(response) {
                    btnDropdownAppartements.style.display = 'block';
                    var dropdownAppartements = document.getElementById('dropdownAppartements');
                    dropdownAppartements.innerHTML = '';


                    // Parcourez chaque appartement dans la réponse
                    response.forEach(function(appartement) {

                        // Créez une nouvelle case à cocher et un label pour chaque appartement
                        var checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'appartements[]';
                        checkbox.value = appartement.id;
                        checkbox.id = 'appartement' + appartement.id;
                        checkbox.checked = true;


                        var label = document.createElement('label');
                        label.htmlFor = 'appartement' + appartement.id;
                        label.textContent = 'Appartement - ' + appartement.RefAppTR + ' - ' + appartement.proprietaire ;

                        // Créez un nouveau div pour contenir la case à cocher et le label
                        var div = document.createElement('div');
                        div.className = 'form-check';
                        div.appendChild(checkbox);
                        div.appendChild(label);

                        var li = document.createElement('li');
                        li.appendChild(div);
                        dropdownAppartements.appendChild(li);

                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });


    };
});


$(document).ready(function() {
    // Définir un intervalle pour exécuter la fonction tous les jours
    setInterval(function() {
        $.ajax({
            url: 'admin/eventSecondPassage',
            type: 'GET',
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }, 24 * 60 * 60 * 1000); // 24 heures en millisecondes
});


$(document).ready(function() {
    // Définir un intervalle pour exécuter la fonction tous les jours
    setInterval(function() {
        $.ajax({
            url: 'admin/eventTroisiemePassage',
            type: 'GET',
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }, 24 * 60 * 60 * 1000); // 24 heures en millisecondes
});




