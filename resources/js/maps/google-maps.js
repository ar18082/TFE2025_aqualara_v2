import { Loader } from "@googlemaps/js-api-loader";
import axios from 'axios';
import { Timeline } from 'vis-timeline/standalone';
import { DataSet } from 'vis-data';


const loader = new Loader({
    apiKey: import.meta.env.VITE_GOOGLE_MAPS_API_KEY,
    version: "weekly",
    libraries: ["places"],
});


let markersTechnicien = {};
let markersEvent = {};

// function d'initialisation de la map
function initMap() {
    let map;

    const belgium = { lat: 50.6402809, lng: 4.6667145 };
    const mapOptions = { zoom: 9, center: belgium };
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    var btnDate = document.getElementById('btnDate');//btn chercher
    var searchDate = document.getElementById('searchDate');

    btnDate.addEventListener('click', () => {
        hideMarkers(Object.values(markersEvent));
        markersEvent = {};

        var date = searchDate.value;
        createEvent(map, date);


        // affiche tout les events sur la carte

        showMarkers(map, Object.values(markersEvent));

        // checker quel technicien est coché et afficher les événements sur la timeline
        var inputTechniciens = Array.from(document.getElementsByClassName('inputTechnicien'));
        var techniciensChecked = inputTechniciens.filter(input => input.checked);
        var techniciensCheckedId = techniciensChecked.map(tech => tech.id);



        //remove timeline
        techniciensCheckedId.forEach(tech => {
            document.getElementById('timeline_' + techniciensCheckedId);
            addEventTimeline(date, tech);

        });
        //add timeline



    });

    createTechnicien(map);
    showMarkers(map, Object.values(markersTechnicien));




}

function createEvent(map, date) {
    axios.get('/cartography/getEventsCartography/', { params: { date: date }})
        .then(response => {
            const events = response.data;

            // Récupérer les IDs des techniciens cochés
            var inputTechniciens = Array.from(document.getElementsByClassName('inputTechnicien'));
            var techniciensChecked = inputTechniciens.filter(input => input.checked);
            var techniciensCheckedId = techniciensChecked.map(tech => tech.id);

            if(events.length >= 0) {
                events.forEach(item => {
                    console.log(item.techniciens);
                    // Filtrer les événements pour n'afficher que ceux qui sont assignés aux techniciens cochés
                    // ou qui n'ont pas de technicien assigné
                    if (item.techniciens.length === 0 || item.techniciens.some(tech => techniciensCheckedId.includes(tech.id.toString()))) {
                        var icon;
                        if (item.techniciens.length > 0) {
                            icon = {
                                path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
                                scale: 6,
                                fillColor: item.techniciens[0].color_technicien.code_hexa,
                                fillOpacity: 1,
                                strokeWeight: 1,
                            }
                        } else {
                            icon = '';
                        }

                        const position = {
                            lat: parseFloat(item.client.latitude),
                            lng: parseFloat(item.client.longitude)
                        };

                        const title = item.client.nom;
                        const animation = google.maps.Animation.DROP;
                        const type = 'event';

                        var marker = addMarker(item, position, title, map, icon, animation, type);
                        addInfoWindow(marker, item, map, Object.values(markersTechnicien));
                    }
                });
            }
        })
        .catch(console.log);
}

// function qui affiche les techniciens sur la carte et sur la sidebar avec checkbox
function createTechnicien(map) {

    axios.get('/admin/techniciensAjax')
        .then(response => {
            const techniciens = response.data.techniciens;
            const user = response.data.user;

            var markerTechnicien = [];

            function createTechnicienLI(tech) {
                console.log(tech);
                const liTechnicien = document.createElement('li');
                liTechnicien.className = 'list-group-item';
                const labelTechnicien = document.createElement('label');
                labelTechnicien.className = 'techniciens';

                const inputTechnicien = document.createElement('input');
                inputTechnicien.type = 'checkbox';
                inputTechnicien.value = tech.id;
                inputTechnicien.id = tech.id;
                inputTechnicien.name = 'technicien_' + tech.id;
                inputTechnicien.className = 'inputTechnicien';
                labelTechnicien.appendChild(inputTechnicien);
                labelTechnicien.appendChild(document.createTextNode(`  ${tech.nom} ${tech.prenom} `));
                liTechnicien.appendChild(labelTechnicien);
                ulTechniciens.appendChild(liTechnicien);

                inputTechnicien.addEventListener('change', () => {
                    if (inputTechnicien.checked) {

                        createTechnicienMap(tech, map);

                        showTechnicienTimeline(tech);


                    } else {
                        document.getElementById(`contentTechnicien_${tech.id}`).remove();
                        markersTechnicien[tech.id].setMap(null);
                        if (tech.id in markersTechnicien) {
                            delete markersTechnicien[tech.id];


                        }
                    }


                });


            }

            if (user.role === 'admin' || user.role === 'bureau') {
                techniciens.forEach(tech => {
                    createTechnicienLI(tech);

                });



            } else {
                techniciens.forEach(tech => {
                    if (user.technicien_id === tech.id) {

                        createTechnicienMap(tech, map);

                        showTechnicienTimeline(tech);
                    }
                });

            }

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('date') && urlParams.has('techId')) {
                var date = new Date(urlParams.get('date')).toISOString().slice(0, 10);
                var techId = urlParams.get('techId');
                var inTechnicien = document.getElementById(techId);

                inTechnicien.checked = true;
                inTechnicien.dispatchEvent(new Event('change'));
                searchDate.value = date;
                btnDate.click();

            }

        })
        .catch(console.log);
}

// function pour afficher les techniciens sur la carte
function createTechnicienMap(tech, map)
{

    const position = { lat: parseFloat(tech.latitude), lng: parseFloat(tech.longitude) };
    const title = `${tech.nom} ${tech.prenom}`;
    const icon = {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 10,
        fillColor: tech.color_technicien.code_hexa,
        fillOpacity: 1,
        strokeWeight: 1,
    };
    const animation = false;
    addMarker(tech, position, title, map, icon, animation, 'technicien');


}

function showTechnicienTimeline(tech)
{
    // create timeline for technicien
    const containerTechnicien = document.createElement('div');
    containerTechnicien.className = 'containerTechnicien row';
    containerTechnicien.style = `background-color: ${tech.color_technicien.code_hexa} `;
    containerTechnicien.id = `contentTechnicien_${tech.id}`;
    const technicienTimeline = document.createElement('h6');
    technicienTimeline.className = 'col-2 mt-4 ';
    technicienTimeline.style = `color: white; `;
    technicienTimeline.innerHTML = `${tech.nom} ${tech.prenom}`;
    const timeline = document.createElement('div');
    timeline.className = 'timeline col-10';
    timeline.style = `background-color: ${tech.color_technicien.code_hexa} `;
    timeline.id = `timeline_${tech.id}`;
    containerTechnicien.appendChild(technicienTimeline);
    containerTechnicien.appendChild(timeline);
    contentTimeline.appendChild(containerTechnicien);


}


function addEventTimeline(date, technicienId) {

    axios.get('/cartography/getEventsCartography/', { params: { date: date, technicien_id: technicienId }})
        .then(response => {
            const events = response.data;
            var elements = [];

            events.forEach(item => {
                // Filtrer les événements pour n'afficher que ceux qui sont assignés aux techniciens cochés

                    // convert string on number
                    technicienId = parseInt(technicienId);

                    if(item.techniciens[0].id === technicienId) {

                        elements.push({
                            id: item.id,
                            content: item.client.Codecli + ' - ' + item.client.nom + ' - ' + item.type_event.abreviation,
                            start: item.start,
                            end: item.end,
                            quart: item.quart,
                        });

                        const container = document.getElementById('timeline_' + item.techniciens[0].id);
                        // remove content container
                        container.innerHTML = '';


                        var options = {
                            // Vue initiale de la timeline
                            min: new Date(date + 'T08:00:00'),
                            max: new Date(date + 'T18:00:00'),
                            zoomMin: 1000 * 60 * 60,  // Limite de zoom minimum (1 heure)
                            zoomMax: 1000 * 60 * 60 * 24,  // Limite de zoom maximum (1 jour)
                        };


                        new Timeline(container, new DataSet(elements), options);
                    }
            });
        })
        .catch(console.log);
}

// function qui affiche les markers sur la carte
function showMarkers(map, markers) {
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function hideMarkers(markers) {
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(null);

    }
}

// function pour créer les markers sur la carte
function addMarker( item, position, title, map, icon={}, animation, type) {

    const marker = new google.maps.Marker({
        position,
        map,
        title : title,
        icon : icon,
        animation: animation,

    });

    if(type === 'technicien') {
        markersTechnicien[item.id] = marker;

    }else {
        markersEvent[item.id] = marker;
    }

    return marker

}

// function qui affiche dans la modal le formulaire pour assigner un technicien et une heure à un événement
function addInfoWindow(marker, item, map, markersTechnicien) {

    let optionTechniciens = '';
    for(let i = 0; i < markersTechnicien.length; i++){
        optionTechniciens += `<option id='${Object.keys(markersTechnicien)[i]}' value='${Object.keys(markersTechnicien)[i]}'>${Object.values(markersTechnicien)[i].title}</option>`;
    }
    const startFormatted = new Date(item.start).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'numeric',
        year: 'numeric',
    });

    const startTime = new Date(item.start).getTime();
    const endTime = new Date(item.end).getTime();
    const duration = endTime - startTime;
    const time = new Date(duration).toISOString().slice(11, 16);

    const startTimeFormatted = new Date(item.start).toLocaleTimeString('fr-FR', {
        hour: 'numeric',
        minute: 'numeric',
    });

    var contentInfoWindow =
        `
        <form id='formOrdre'>

            <div class='form-group'>
                <label for='client'>Client</label>
                <input type='text' class='form-control' id='client' name='client' value='${item.client.nom}' readonly>
                <input type='hidden' class='form-control' id='codeCli' name='codecli' value='${item.client.id}' readonly>
                <input type='hidden' class='form-control' id='eventId' name='eventId' value='${item.id}' readonly>
            </div>
            <div class='form-group'>
                <label for='adresse'>Adresse</label>
                <input type='text' class='form-control' id='adresse' name='adresse' value='${item.client.rue}' readonly>
            </div>
            <div class='form-group'>
                <label for='date'>Date</label>
                <input type='text' class='form-control' id='date' name='date' value='${startFormatted}' readonly>
            </div>
            <div class='form-group'>
                <label for='date'>Heure </label>
                <input type='text' class='form-control' id='heure' name='heure' value='${startTimeFormatted}'>
            </div>
            <div class='form-group'>
                <label for='date'>Durée </label>
                <input type='time' class='form-control' id='duree' name='duree' value='${time}' readonly>
            </div>
            <div class='form-group'>
                <label for='quart'>Quart</label>
                <input class='form-control' id='quart' name='quart' value='${item.quart}'>
            </div>
            <div class='form-group'>
                <label for='technicien'>Technicien</label>
                <select class='form-control' id='technicien' name='technicien'>
                    ${optionTechniciens}
                </select>
            </div>
            <div class='form-group mt-4'>
                <button type='button' id='submitFormMarker' class='btn btn-primary'>assigner</button>
            </div>
        </form>`;


    const infoWindow = new google.maps.InfoWindow({
        content: contentInfoWindow,
    });
    marker.addListener("click", () => {
        infoWindow.open(map, marker);

        google.maps.event.addListenerOnce(infoWindow, 'domready', () => {

            if(item.techniciens.length > 0){

                document.getElementById(item.techniciens[0].id).selected = true;
            }
            // document.getElementById('ordre').value = item.ordre;
            const submitFormMarker = document.getElementById('submitFormMarker');
            submitFormMarker.addEventListener('click', () => {

                const datas = {
                    client: document.getElementById('client').value,
                    codeCli: document.getElementById('codeCli').value,
                    eventId: document.getElementById('eventId').value,
                    quart: document.getElementById('quart').value,
                    technicien: document.getElementById('technicien').value,
                    date : document.getElementById('searchDate').value,
                    duree: document.getElementById('duree').value,
                    heure: document.getElementById('heure').value,


                };

                axios.post('admin/ordreEvent', datas).then(response => {
                    if(response.status === 200){
                        alert(response.data.response);
                        infoWindow.close();
                        formOrdre.submit();


                    }

                })
                .catch(console.log);



            });
        });

    });
}

if(window.location.pathname.includes( '/cartography')){
    loader.load().then(initMap);


}




