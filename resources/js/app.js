import './bootstrap';

import Alpine from 'alpinejs';

import './appartement/appartementNav';
import './utils/propertyForm';
import './core/changeDate';
import './core/search';
import './event';
import './facture/facture';
import './maps/google-maps';
import './calendar/calendar';
import './core/typeErreur';
import './materiel/formMateriel';

// import './immeuble/detail/detailNav';
import './materiel/assigneMateriel';
import './calendar/timeline';
// import './immeuble/EventImmeuble';
import './utils/mailContents';
// import './saisie/saisie';

// import './immeuble/navigation';


// details
import './immeuble/detail/definition';
import './immeuble/detail/common';
import './immeuble/detail/chauffage';
import './immeuble/detail/eau';
import './immeuble/detail/gaz';
import './immeuble/detail/electricite';
import './immeuble/detail/provision';
import './immeuble/detail/infoAppart';

// Saisies
import './immeuble/saisies/parametres';
import './immeuble/saisies/navigation';
import './immeuble/saisies/creationDate';





window.Alpine = Alpine;

Alpine.start();

// const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
// const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

// Filter Compteurs eaux
// document.addEventListener('DOMContentLoaded', function() {
//     var dropdownItems = document.querySelectorAll('#eautype li a');
//     var inputField = document.getElementById('eautype');
//     var form = document.getElementById('filterform');
//
//     dropdownItems.forEach(function(item) {
//         item.addEventListener('click', function(e) {
//             e.preventDefault();
//             var inputValue = this.getAttribute('data-input');
//             inputField.value = inputValue;
//             form.submit(); // Soumet le formulaire
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', function() {
    var dropdownItemsEau = document.querySelectorAll('#eautype_ul li a');
    var inputFieldEau = document.getElementById('eautype');
    var dropdownItemsChauf = document.querySelectorAll('#chauftype_ul li a');
    var inputFieldChauf = document.getElementById('chauftype');
    var form = document.getElementById('filterform'); // Assurez-vous que c'est le bon ID de formulaire

    var updateInputAndSubmit = function(inputField, value) {
        inputField.value = value;
        form.submit();
    };

    dropdownItemsEau.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            updateInputAndSubmit(inputFieldEau, this.getAttribute('data-input'));
        });
    });

    dropdownItemsChauf.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            updateInputAndSubmit(inputFieldChauf, this.getAttribute('data-input'));
        });
    });
});

// document.addEventListener('DOMContentLoaded', () => {
//     initializeSaisieEau();
// });
