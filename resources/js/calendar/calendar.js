import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interaction, { Draggable } from '@fullcalendar/interaction';
import axios from 'axios';

import * as templateDocument from '../templateDocument.js';

if(window.location.pathname === '/calendar') {
    axios.get('ajax/user')
        .then(response => {
            let user = response.data;

            axios.get('/event/eventAjax')
                .then(response => {
                    let events = response.data;
                    const userRole = user.role;
                    const urlParams = new URLSearchParams(window.location.search);
                    if(urlParams.has('date')){
                        var date = new Date(urlParams.get('date')).toISOString().slice(0, 10);
                    }


                    if (userRole === 'technicien') {
                        let calendarEl = document.querySelector('#calendar');
                        let calendar = new Calendar(calendarEl, {
                            plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interaction],
                            initialView: 'timeGridWeek',
                            locale: 'fr',
                            timeZone: 'Europe/Paris',
                            hiddenDays: [0, 6],
                            eventOrder: 'color',
                            nowIndicator: true,
                            editable: true,
                            droppable: true,
                            selectable: true,
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'timeGridWeek'
                            },
                            buttonText: {
                                today: 'Aujourd\'hui',
                                week: 'Semaine',

                            },
                            views: {
                                week: {
                                    buttonText: 'Semaine',
                                    slotMinTime: '06:00:00',
                                    slotMaxTime: '18:00:00',
                                    eventContent: function (arg) {
                                        let techniciensStr = '';
                                        let techniciens = arg.event.extendedProps.techniciens;
                                        for (let key in techniciens) {
                                            techniciensStr += techniciens[key].nom + ' ' + techniciens[key].prenom + ', ';
                                        }
                                        techniciensStr = techniciensStr.slice(0, -2);

                                        var nbr = arg.event.extendedProps.client.appareils.length;
                                        return {
                                            html: '<div>' +
                                                '<b>' + arg.event.extendedProps.client.nom + ' ' + arg.event.extendedProps.type_event.abreviation + ' ' + nbr + ' X ' + 'Materiel' + '</b>' +
                                                '<br>' +
                                                'Début: ' + arg.event.start.toLocaleString() +
                                                '<br>' +
                                                'Assigné à: ' + techniciensStr +
                                                '<br>' +
                                                '</div>',
                                        };
                                    },
                                }
                            },
                            // select: function(info) {
                            //     document.getElementById('app').style.display = 'block';
                            //     initialiseMap(info.startStr);
                            //
                            // },

                            eventClick:  (info) => {

                                const id = info.event.id;
                                const clientId = info.event.extendedProps.client_id;

                                // Retrieving client
                                const codeCli = info.event.extendedProps.client.Codecli;
                                const titre = info.event.extendedProps.client.nom;
                                const appartements = info.event.extendedProps.client.appartements;
                                const eventAppartements = info.event.extendedProps.event_appartements;
                                const appareils = info.event.extendedProps.client.appareils;





                                // Retrieving dates and times
                                const dateDebut = info.event.start;
                                const formattedDate = dateDebut.toISOString().split('T')[0];
                                const heureDebut  = ('0' + dateDebut.getHours()).slice(-2);
                                const minutesDebut = ('0' + dateDebut.getMinutes()).slice(-2);
                                const TimeDebut = heureDebut + ':' + minutesDebut;


                                const dateFin = info.event.end;
                                var Timefin = '';
                                if (dateFin) {
                                    const heureFin = ('0' + dateFin.getHours()).slice(-2);
                                    const minutesFin = ('0' + dateFin.getMinutes()).slice(-2);
                                    Timefin = heureFin + ':' + minutesFin;
                                } else {
                                    Timefin = '';
                                }

                                //Retrieving comment and typeInter
                                const commentaire = info.event.extendedProps.client.remarque;
                                const typeIntervention = info.event.extendedProps.type_event.id;
                                //Retrieving technicien
                                const techniciens = info.event.extendedProps.techniciens;


                                $('#modal').modal('show');

                                $('#modal-body [name="client_id"] option').each(function() {

                                     $(this).val(clientId);
                                    $(this).text(codeCli + " : " + titre);
                                });

                                $('#modal-body [name="typeIntervention"] option').each(function() {
                                    if ($(this).val() == typeIntervention) {
                                        $(this).prop('selected', true);
                                    }
                                });

                                $('#modal-body [name="typeIntervention"]').trigger('change.select2');

                               // $('#modal-body [id="appareils"]').empty();
                                let cptApp = 0;

                                $('#modal-body [id="btn_appareils"]').append('Nombre d\'appareils : ' + appareils.length);
                                for (let i = 0; i < appareils.length; i++) {
                                    if (i === 0) {
                                        cptApp = 1;
                                        $('#modal-body [id="appareils"]').append('<li>' + cptApp + ' X ' + appareils[i].materiel_id + ' </li>');

                                    }else {
                                        if (appareils[i].materiel_id != appareils[i - 1].materiel_id) {
                                            cptApp = 1;
                                            $('#modal-body [id="appareils"]').append('<li> ' + cptApp + ' X ' + appareils[i].materiel_id + '</li>');
                                        } else {
                                            cptApp++;

                                            $('#modal-body [id="appareils"] li:last').remove();
                                            $('#modal-body [id="appareils"]').append('<li>' + cptApp + ' X ' + appareils[i].materiel_id + '</li>');


                                        }
                                    }

                                }

                                 $('#modal-body [id="appartements"]').empty();
                                 for (let i = 0; i < appartements.length; i++) {

                                    $('#modal-body [id="appartements"]').append('<div class="col-6 appartement_item"><input type="checkbox" name="appartement[]" value="' + appartements[i].id+ '" id="appartement' + appartements[i].id +'" ' +'><label for="appartement' + appartements[i].id + '">Appartement ' + (i+1) + '</label></div>' );
                                 }

                                $('#modal-body input[name="appartement[]"]').prop('checked', false);
                                for (let appartement in eventAppartements) {

                                    $(`#modal-body input[id="appartement${eventAppartements[appartement].appartement_id}"]`).prop('checked', true);
                                }

                                var initialAppartementsState = [];

                                $(document).ready(function() {
                                    $('#modal-body input[name="appartement[]"]').each(function() {
                                        initialAppartementsState[$(this).val()] = $(this).prop('checked');
                                    });
                                });


                                $('#modal-body [name="eventId"]').val(id);
                                $('#modal-body [name="startDate"]').val(formattedDate);
                                $('#modal-body [name="startTime"]').val(TimeDebut);
                                $('#modal-body [name="endTime"]').val(Timefin);


                                $('#modal-body [name="commentaire"]').val(commentaire);


                                $('#modal-body input[name="techniciens[]"]').prop('checked', false);
                                for (let technicienId in techniciens) {

                                    $(`#modal-body input[id="technicien${techniciens[technicienId].id}"]`).prop('checked', true);
                                }

                                var initialTechniciensState = [];

                                $(document).ready(function() {
                                    $('#modal-body input[name="techniciens[]"]').each(function() {
                                        initialTechniciensState[$(this).val()] = $(this).prop('checked');
                                    });
                                });

                                $('.btnEdit').on('click', function(info) {

                                    if (confirm("Êtes-vous sûr de vouloir modifier cet événement ?")) {
                                       // var techiciens_modal = $('#modal-body [name="techniciens[]"]').val();

                                        var typeIntervention_modal = $('#typeIntervention').val();
                                        var commentaire_modal = $('#modal-body [name="commentaire"]').val();
                                        var startDate_modal =  $('#modal-body [name="startDate"]').val();
                                        var TimeDebut_modal =  $('#modal-body [name="startTime"]').val();
                                        var TimeFin_modal =  $('#modal-body [name="endTime"]').val();
                                        var client_id_modal = $('#modal-body [name= "client_id"]').val();
                                        var eventId_modal = $('#modal-body [name="eventId"]').val();

                                        var selectedAppartements = {};
                                        var selectedTechniciens = {};

                                        $('#modal-body input[name="techniciens[]"]').each(function() {
                                            var technicienId = $(this).val();
                                            var isChecked = $(this).prop('checked');
                                            selectedTechniciens[technicienId] = isChecked;
                                        });

                                        var techiciens_modal = Object.keys(selectedTechniciens).filter(function(technicienId) {
                                            return selectedTechniciens[technicienId] === true;
                                        });

                                        $('#modal-body input[name="appartement[]"]').each(function() {
                                            var appartementId = $(this).val();
                                            var isChecked = $(this).prop('checked');
                                            selectedAppartements[appartementId] = isChecked;
                                        });

                                        var appartements_modal = Object.keys(selectedAppartements).filter(function(appartementId) {
                                            return selectedAppartements[appartementId] === true;
                                        });

                                        axios.post('event/update_eventAjax  ', {
                                            client_id: client_id_modal,
                                            eventId :  eventId_modal,
                                            typeIntervention: typeIntervention_modal,
                                            startDate: startDate_modal,
                                            startTime: TimeDebut_modal+':00',
                                            endTime : TimeFin_modal+':00',
                                            commentaire : commentaire_modal,
                                            techniciens : techiciens_modal,
                                            appartement : appartements_modal,



                                        })
                                        .then(response => {
                                            window.location.reload(true);
                                        })
                                        .catch(error => {
                                            console.error('Erreur lors de la mise à jour de l\'événement :', error);
                                            //info.revert();
                                        });


                                    }else{

                                        info.revert();
                                    }
                                });

                            },
                            datesSet: function (info) {
                                //console.log(info);
                            },



                        });

                        events.forEach(eventData => {
                            let eventColor = '';
                            if (eventData.techniciens.length > 1) {
                                eventColor = '#ff0000';
                            } else {
                                eventData.techniciens.forEach(technicien => {
                                    eventColor = technicien.color_technicien.code_hexa;
                                });
                            }
                            calendar.addEvent({
                                ...eventData,
                                backgroundColor: eventColor,
                                borderColor: eventColor,
                                textColor: 'white',
                            });


                        });

                        calendar.render();
                    }else {
                        var calendarEl = document.querySelector('#calendar');
                        var calendar = new Calendar(calendarEl, {
                            plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interaction],
                            initialView: 'timeGridWeek',
                            initialDate: date !== '' ? date : new Date(),
                            locale: 'fr',
                            timeZone: 'Europe/Paris',
                            hiddenDays: [0, 6],
                            eventOrder: 'color',
                            nowIndicator: true,
                            editable: true,
                            droppable: true,
                            selectable: true,
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'timeGridWeek,listWeek,dayGridDay'
                            },
                            buttonText: {
                                today: 'Aujourd\'hui',
                                // month: 'Mois',
                                week: 'Semaine',
                                list: 'Liste',
                                day: 'Jour'
                            },
                            views: {
                                week: {
                                    slotMinTime: '06:00:00',
                                    slotMaxTime: '19:00:00',
                                    eventContent: function (arg) {
                                        // let techniciensStr = '';
                                        // let techniciens = arg.event.extendedProps.techniciens;
                                        // for (let key in techniciens) {
                                        //     techniciensStr += techniciens[key].nom + ' ' + techniciens[key].prenom + ', ';
                                        // }
                                        // techniciensStr = techniciensStr.slice(0, -2);

                                        var nbr = 0;
                                        if (arg.event.extendedProps.client.appartements) {
                                            nbr = arg.event.extendedProps.client.appartements.length;
                                        }
                                        if(arg.event.extendedProps.type_event.abreviation === 'Congé' || arg.event.extendedProps.type_event.abreviation === 'Malade' ){
                                            return {
                                                html: '<div >' +
                                                    '<b>' + arg.event.extendedProps.client.nom + ' '+ arg.event.extendedProps.type_event.abreviation + '</b>' +
                                                    '</div>',
                                            };
                                        }else{
                                            return {
                                                html: '<div >' +
                                                    '<b>' + arg.event.extendedProps.client.nom + ' '+ arg.event.extendedProps.type_event.abreviation + ' ' + nbr + ' X '+ 'Materiel'+ '</b>' +
                                                    '</div>',
                                            };
                                        }
                                    },
                                },
                                list: {

                                    eventContent: function (arg) {
                                        // let techniciensStr = '';
                                        //
                                        // let techniciens = arg.event.extendedProps.techniciens;
                                        //
                                        // for (let key in techniciens) {
                                        //     techniciensStr += techniciens[key].nom + ' ' + techniciens[key].prenom + ', ';
                                        //
                                        //
                                        //
                                        // }
                                        // techniciensStr = techniciensStr.slice(0, -2);

                                        var nbr = 0;
                                        if (arg.event.extendedProps.client.appartements) {
                                            nbr = arg.event.extendedProps.client.appartements.length;
                                        }

                                        if(arg.event.extendedProps.type_event.abreviation === 'Congé' || arg.event.extendedProps.type_event.abreviation === 'Malade' ){
                                            return {
                                                html: '<div >' +
                                                    '<b>' + arg.event.extendedProps.client.nom + ' '+ arg.event.extendedProps.type_event.abreviation + '</b>' +
                                                    '</div>',
                                            };
                                        }else{
                                            return {
                                                html: '<div >' +
                                                    '<b>' + arg.event.extendedProps.client.nom + ' '+ arg.event.extendedProps.type_event.abreviation + ' ' + nbr + ' X '+ 'Materiel'+ '</b>' +
                                                    '</div>',
                                            };
                                        }


                                    },
                                    listDayFormat: { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' },

                                },
                                day: {

                                    eventContent: function (arg) {
                                        var nbr = 0;
                                        if (arg.event.extendedProps.client.appartements) {
                                            nbr = arg.event.extendedProps.client.appartements.length;
                                        }
                                        if(arg.event.extendedProps.type_event.abreviation === 'Congé' || arg.event.extendedProps.type_event.abreviation === 'Malade' ){
                                            return {
                                                html: '<div >' +
                                                    '<b>' + arg.event.extendedProps.client.nom + ' '+ arg.event.extendedProps.type_event.abreviation + '</b>' +
                                                    '</div>',
                                            };
                                        }else{
                                            return {
                                                html: '<div >' +
                                                    '<b>' + arg.event.extendedProps.client.nom + ' '+ arg.event.extendedProps.type_event.abreviation + ' ' + nbr + ' X '+ 'Materiel'+ '</b>' +
                                                    '</div>',
                                            };
                                        }
                                    },
                                    listDayFormat: { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' },

                                },
                            },
                            // select: function(info) {
                            //     document.getElementById('app').style.display = 'block';
                            //     initialiseMap(info.startStr);
                            //
                            // },
                            eventReceive: function(info) {
                                // Accédez aux données de l'événement en utilisant info.event
                                var eventData = info.event;

                                axios.post('event/update_eventAjax', {
                                        datas: info.event,

                                })
                                    .then(response => {
                                        console.log('Événement créé avec succès:', response);
                                    })
                                    .catch(error => {
                                        console.error('Erreur lors de la création de l\'événement:', error);
                                    });
                            },
                            eventDrop: (info) => {

                                if (confirm("Êtes-vous sûr de vouloir modifier cet événement ?")) {

                                    axios.post('/event/updateTime_eventAjax', {
                                        datas: info.event,

                                    })
                                    .then(response => {
                                        console.log('Événement mis à jour avec succès : ', response);
                                        window.location.reload(true);
                                    })
                                    .catch(error => {
                                        console.error('Erreur lors de la mise à jour de l\'événement :', error);
                                       // info.revert();
                                    });

                                }else{

                                    info.revert();
                                }

                            },
                            eventResize: (info) => {
                                if (confirm("Êtes-vous sûr de vouloir modifier cet événement ?")) {

                                    axios.post('/event/updateTime_eventAjax  ', {
                                        datas: info.event,

                                    })
                                        .then(response => {
                                            console.log(response);
                                            window.location.reload(true);
                                        })
                                        .catch(error => {
                                            console.error('Erreur lors de la mise à jour de l\'événement :', error);

                                        });
                                }else{
                                    info.revert();
                                }
                            },
                            eventClick:  (info) => {

                                const id = info.event.id;
                                const clientId = info.event.extendedProps.client_id;

                                // Retrieving client
                                const codeCli = info.event.extendedProps.client.Codecli;
                                const titre = info.event.extendedProps.client.nom;
                                const appartements = info.event.extendedProps.client.appartements;
                                const eventAppartements = info.event.extendedProps.event_appartements;
                                const appareils = info.event.extendedProps.client.appareils;


                                // Retrieving dates and times
                                const dateDebut = info.event.start;
                                const formattedDate = dateDebut.toISOString().split('T')[0];
                                const heureDebut  = ('0' + dateDebut.getHours()).slice(-2);
                                const minutesDebut = ('0' + dateDebut.getMinutes()).slice(-2);
                                const TimeDebut = heureDebut + ':' + minutesDebut;


                                const dateFin = info.event.end;
                                var Timefin = '';
                                if (dateFin) {
                                    const heureFin = ('0' + dateFin.getHours()).slice(-2);
                                    const minutesFin = ('0' + dateFin.getMinutes()).slice(-2);
                                    Timefin = heureFin + ':' + minutesFin;
                                } else {
                                    Timefin = '';
                                }

                                //Retrieving comment and typeInter
                                const commentaire = info.event.extendedProps.client.remarque;
                                const typeIntervention = info.event.extendedProps.type_event.id;
                                const typeInterventionName = info.event.extendedProps.type_event.name;
                                //Retrieving technicien
                                const techniciens = info.event.extendedProps.techniciens;


                                $('#modal').modal('show');

                                $('#modal-body [name="client_id"] option').each(function() {

                                     $(this).val(clientId);
                                    $(this).text(codeCli + " : " + titre);
                                });

                                $('#modal-body [name="typeIntervention"] option').each(function() {
                                    if ($(this).val() == typeIntervention) {
                                        $(this).prop('selected', true);
                                    }
                                });

                                $('#modal-body [name="typeIntervention"]').trigger('change.select2');

                               // $('#modal-body [id="appareils"]').empty();
                                let cptApp = 0;

                                $('#modal-body [id="btn_appareils"]').append('Nombre d\'appareils : ' + appareils.length);
                                for (let i = 0; i < appareils.length; i++) {
                                    if (i === 0) {
                                        cptApp = 1;
                                        $('#modal-body [id="appareils"]').append('<li>' + cptApp + ' X ' + appareils[i].materiel_id + ' </li>');

                                    }else {
                                        if (appareils[i].materiel_id != appareils[i - 1].materiel_id) {
                                            cptApp = 1;
                                            $('#modal-body [id="appareils"]').append('<li> ' + cptApp + ' X ' + appareils[i].materiel_id + '</li>');
                                        } else {
                                            cptApp++;

                                            $('#modal-body [id="appareils"] li:last').remove();
                                            $('#modal-body [id="appareils"]').append('<li>' + cptApp + ' X ' + appareils[i].materiel_id + '</li>');


                                        }
                                    }

                                }

                                 $('#modal-body [id="appartements"]').empty();
                                 for (let i = 0; i < appartements.length; i++) {
                                     const isChecked = typeInterventionName === 'Relevé Généraux' ? 'checked' : '';
                                     $('#modal-body [id="appartements"]').append(
                                         `<div class="col-6 appartement_item">
                                            <input type="checkbox" ${isChecked} name="appartement[]" value="${appartements[i].id}" id="appartement${appartements[i].id}">
                                            <label for="appartement${appartements[i].id}">Appartement ${i + 1}</label>
                                        </div>`
                                     );
                                 }

                                // $('#modal-body input[name="appartement[]"]').prop('checked', false);
                                // for (let appartement in eventAppartements) {
                                //
                                //     $(`#modal-body input[id="appartement${eventAppartements[appartement].appartement_id}"]`).prop('checked', true);
                                // }

                                var initialAppartementsState = [];

                                $(document).ready(function() {
                                    $('#modal-body input[name="appartement[]"]').each(function() {
                                        initialAppartementsState[$(this).val()] = $(this).prop('checked');
                                    });
                                });


                                $('#modal-body [name="eventId"]').val(id);
                                $('#modal-body [name="startDate"]').val(formattedDate);
                                $('#modal-body [name="startTime"]').val(TimeDebut);
                                $('#modal-body [name="endTime"]').val(Timefin);


                                $('#modal-body [name="commentaire"]').val(commentaire);


                                $('#modal-body input[name="techniciens[]"]').prop('checked', false);
                                for (let technicienId in techniciens) {

                                    $(`#modal-body input[id="technicien${techniciens[technicienId].id}"]`).prop('checked', true);
                                }

                                var initialTechniciensState = [];

                                $(document).ready(function() {
                                    $('#modal-body input[name="techniciens[]"]').each(function() {
                                        initialTechniciensState[$(this).val()] = $(this).prop('checked');
                                    });
                                });

                                $('.btnEdit').on('click', function(info) {

                                    if (confirm("Êtes-vous sûr de vouloir modifier cet événement ?")) {
                                       // var techiciens_modal = $('#modal-body [name="techniciens[]"]').val();

                                        var typeIntervention_modal = $('#typeIntervention').val();
                                        var commentaire_modal = $('#modal-body [name="commentaire"]').val();
                                        var startDate_modal =  $('#modal-body [name="startDate"]').val();
                                        var TimeDebut_modal =  $('#modal-body [name="startTime"]').val();
                                        var TimeFin_modal =  $('#modal-body [name="endTime"]').val();
                                        var client_id_modal = $('#modal-body [name= "client_id"]').val();
                                        var eventId_modal = $('#modal-body [name="eventId"]').val();

                                        var selectedAppartements = {};
                                        var selectedTechniciens = {};

                                        $('#modal-body input[name="techniciens[]"]').each(function() {
                                            var technicienId = $(this).val();
                                            var isChecked = $(this).prop('checked');
                                            selectedTechniciens[technicienId] = isChecked;
                                        });

                                        var techiciens_modal = Object.keys(selectedTechniciens).filter(function(technicienId) {
                                            return selectedTechniciens[technicienId] === true;
                                        });

                                        $('#modal-body input[name="appartement[]"]').each(function() {
                                            var appartementId = $(this).val();
                                            var isChecked = $(this).prop('checked');
                                            selectedAppartements[appartementId] = isChecked;
                                        });

                                        var appartements_modal = Object.keys(selectedAppartements).filter(function(appartementId) {
                                            return selectedAppartements[appartementId] === true;
                                        });

                                        axios.post('event/update_eventAjax  ', {
                                            client_id: client_id_modal,
                                            eventId :  eventId_modal,
                                            typeIntervention: typeIntervention_modal,
                                            startDate: startDate_modal,
                                            startTime: TimeDebut_modal+':00',
                                            endTime : TimeFin_modal+':00',
                                            commentaire : commentaire_modal,
                                            techniciens : techiciens_modal,
                                            appartement : appartements_modal,



                                        })
                                        .then(response => {
                                            window.location.reload(true);
                                        })
                                        .catch(error => {
                                            console.error('Erreur lors de la mise à jour de l\'événement :', error);
                                            //info.revert();
                                        });


                                    }else{

                                        info.revert();
                                    }
                                });

                            },
                            eventDidMount: function(info) {
                                info.event.extendedProps.techniciens.forEach(technicien => {
                                    var technicienCheckbox_all = document.getElementById('technicienCheckbox_all');
                                    var techniciens = document.querySelectorAll('input[id^="technicienCheckbox-"]');
                                    technicienCheckbox_all.addEventListener('click', function() {
                                        if(technicienCheckbox_all.checked){
                                            // récuperer tout les inputs que l'id commence par technicienCheckbox- et les checked

                                            techniciens.forEach(technicien => {
                                                technicien.checked = true;
                                                info.el.style.display = 'block';
                                            });

                                        }else {

                                            techniciens.forEach(technicien => {
                                                technicien.checked = false;
                                                info.el.style.display = 'none';

                                            });
                                        }
                                    });
                                    var technicienCheckbox = document.getElementById('technicienCheckbox-' + technicien.id);
                                    if (technicienCheckbox) {
                                        technicienCheckbox.addEventListener('click', function() {
                                            if (technicienCheckbox.checked) {
                                                info.el.style.display = 'block';
                                            } else {
                                                info.el.style.display = 'none';
                                            }
                                        });
                                    }
                                });


                            },

                        });

                        events.forEach(eventData => {
                            let eventColor = '';
                            if (eventData.techniciens.length > 1) {
                                eventColor = '#ff0000';
                            } else {
                                eventData.techniciens.forEach(technicien => {
                                    eventColor = technicien.color_technicien.code_hexa;
                                });
                            }
                            calendar.addEvent({
                                ...eventData,
                                backgroundColor: eventColor,
                                borderColor: eventColor,
                                textColor: 'white',
                            });

                        });

                        $('#technicienModalBtn').on('click', function() {

                            $('#technicienModal').modal('show');
                        });
                        $('#technicienModalBtnClose').on('click', function() {

                            $('#technicienModal').modal('hide');
                        });





                        var btnSaveChanges = document.getElementById('technicienModalBtnSave');
                        btnSaveChanges.addEventListener('click', function() {
                            var startDate = document.getElementById('startDate').value;
                            var newDate = document.getElementById('newDate').value;
                            var techniciens = document.getElementsByName('technicien');
                            var selectedTechniciens = [];
                            for (var i = 0; i < techniciens.length; i++) {
                                if (techniciens[i].checked) {
                                    selectedTechniciens.push(techniciens[i].value);
                                }
                            }
                            var data = {
                                startDate: startDate,
                                newDate: newDate,
                                techniciens: selectedTechniciens
                            };

                            axios.post('event/updateAllDay_eventAjax', data)
                                .then(function(response) {
                                    window.location.reload(true);
                                    console.log(response.data);
                                })
                                .catch(function(error) {

                                    console.error(error);
                                });
                        });

                        calendar.render();
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des événements:', error);
                });
        })
        .catch(error => {
            console.error('Erreur lors de la vérification du rôle utilisateur:', error);
        });
};
