// import {click} from "@tarekraafat/autocomplete.js/src/controllers/listController.js";
// import axios from 'axios';
//
//
// export function buttonBonDeRoute() {
//
//
//         var btnModal = document.getElementById('btnBonRouteModal');
//         var modal = document.getElementById("BonRouteModal");
//         var btnCloseModal = document.getElementById('btnCloseModal');
//
//         btnModal.addEventListener('click', function(){
//             modal.style.display = 'block';
//             modal.classList.add('show');
//         });
//
//         btnCloseModal.addEventListener('click', function(){
//             modal.style.display = 'none';
//             modal.classList.remove('show');
//
//         });
//
//         btnSubmitModal.addEventListener('click', function () {
//
//             modal.style.display = 'none';
//             modal.classList.remove('show');
//
//
//             var dateDebut = document.getElementById('DateDebutModal').value;
//             var dateFin = document.getElementById('DateFinModal').value;
//
//
//             axios.post('documents/BonDeRouteAjax', {
//                 dateDebut: dateDebut,
//                 dateFin: dateFin
//             })
//                 .then(function (response) {
//                     // Gérer la réponse de la requête
//                     console.log('Requête réussie:', response);
//                 })
//                 .catch(function (error) {
//                     // Gérer les erreurs de la requête
//                     console.error('Erreur de requête:', error);
//                 });
//
//         });
//
//
// }
//
//
