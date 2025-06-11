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


function initMap() {
    let map;
    let optionTechniciens = '';

    const belgium = { lat: 50.6402809, lng: 4.6667145 };
    const mapOptions = { zoom: 9, center: belgium };
    map = new google.maps.Map(document.getElementById("map"), mapOptions);

    axios.get('event/eventAjax').then(response => {
        const data = response.data;
        const btnDate = document.getElementById('btnDate');
        const dateStr = document.getElementById('searchDate');
        const ulTechniciens = document.getElementById('ulTechniciens');
        const contentTimeline = document.getElementById('contentTimeline');


        axios.get('admin/techniciensAjax').then(response => {
            const techniciens = response.data.techniciens;
            const events = response.data.events;

            console.log(events);

            contentTimeline.innerHTML = '';
            techniciens.forEach(tech => {

                // create a list of techniciens with checkbox sidebar
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


                // listening to checkbox change
                inputTechnicien.addEventListener('change', () => {

                    if (inputTechnicien.checked) {

                        // create timeline for technicien
                        const containerTechnicien = document.createElement('div');
                        containerTechnicien.className = 'containerTechnicien row';
                        containerTechnicien.style = `background-color: ${tech.color_technicien.code_hexa} `;
                        containerTechnicien.id = `contentTechnicien_${tech.id}`;
                        const technicienTimeline = document.createElement('h6');
                        technicienTimeline.className = 'col-2 ';
                        technicienTimeline.style = `color: white; `;
                        technicienTimeline.innerHTML = `${tech.nom} ${tech.prenom}`;
                        const timeline = document.createElement('div');
                        timeline.className = 'timeline col-10';
                        timeline.style = `background-color: ${tech.color_technicien.code_hexa} `;
                        timeline.id = `timeline_${tech.id}`;
                        containerTechnicien.appendChild(technicienTimeline);
                        containerTechnicien.appendChild(timeline);
                        contentTimeline.appendChild(containerTechnicien);




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
                        var marker = addMarker(tech, position, title, map, icon, animation, 'technicien');


                        addEventTimeline(dateStr, events);


                        const contentInfoWindow = `<div class='container'><div class='row'><div class='col-12'><h5 class='text-center'>${tech.nom} ${tech.prenom}</h5></div></div></div>`;
                        addInfoWindow(marker, contentInfoWindow, 'technicien', tech)

                        optionTechniciens = '';

                    }else{
                        document.getElementById(`contentTechnicien_${tech.id}`).remove();
                        markersTechnicien[tech.id].setMap(null);
                        if (tech.id in markersTechnicien) {
                            delete markersTechnicien[tech.id];
                            optionTechniciens = '';
                        }
                    }

                    // create option for select technicien
                    for(let i = 0; i < Object.values(markersTechnicien).length; i++){
                        optionTechniciens += `<option id='${Object.keys(markersTechnicien)[i]}' value='${Object.keys(markersTechnicien)[i]}'>${Object.values(markersTechnicien)[i].title}</option>`;
                    }

                    showMarkers(map, Object.values(markersTechnicien));

                    /*****************************************************************************************************************************/
                    // // test avant intégration dans function saveDataAndReload
                    // // récuperer l'input checked technicien
                    // var searchDate = document.getElementById('searchDate').value;
                    // var inputTechniciens = Array.from(document.getElementsByClassName('inputTechnicien'));
                    // var techniciensChecked = inputTechniciens.filter(input => input.checked);
                    // console.log(techniciensChecked);
                    //
                    // localStorage.setItem([
                    //     'techniciensChecked', JSON.stringify(techniciensChecked),
                    //     'searchDate', JSON.stringify(searchDate),
                    // ]);
                    //
                    // window.onload = function() {
                    //     var techniciensChecked = JSON.parse(localStorage.getItem('techniciensChecked'));
                    //     var searchDate = JSON.parse(localStorage.getItem('searchDate'));
                    //
                    //     console.log(techniciensChecked);
                    //     console.log(searchDate);
                    // }


                    /*****************************************************************************************************************************/
                });

            });


            data.forEach(item => {

                    const itemDate = new Date(item.start).toISOString().split('T')[0];
                    var contentInfoWindow = '';
                    btnDate.addEventListener('click', () => {
                        // if(date !== dateStr.value){
                        //     hideMarkers(Object.values(markersEvent));
                        // }

                        if (itemDate === dateStr.value) {
                            var icon;
                            if (item.ordre !== null) {
                                icon = {
                                    path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
                                    scale: 5,
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


                            const StartFormatted = new Date(item.start).toLocaleDateString('fr-FR', {
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

                            contentInfoWindow =
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
                                        <input type='text' class='form-control' id='date' name='date' value='${StartFormatted}' readonly>
                                    </div>
                                    <div class='form-group'>
                                        <label for='date'>Heure </label>
                                        <input type='text' class='form-control' id='heure' name='heure' value='${startTimeFormatted}' readonly>
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
                                    <div class='form-group'>
                                        <label for='ordre'>Ordre</label>
                                        <input type='number' name='ordre' class='form-control' id='ordre'>
                                    </div>
                                    <div class='form-group mt-4'>
                                        <button type='button' id='submitFormMarker' class='btn btn-primary'>assigner</button>
                                    </div>
                                </form>`;


                            if(item.type_event.abreviation !== 'Malade') {
                                if (item.type_event.abreviation !== 'Congé') {

                                    var marker = addMarker(item, position, title, map, icon, animation, type);
                                    addInfoWindow(marker, contentInfoWindow, 'event', item);
                                }
                            }


                            showMarkers(map, Object.values(markersEvent));
                        }

                        var date = dateStr.value;
                    });

            });
        }).catch(console.log);
    }).catch(console.log);
}

function addEventTimeline (date, events) {

    for (const [key, value] of Object.entries(events)) {


        // ordonne les événements par priorité
        value.sort((a, b) => a.priority - b.priority);

        const container = document.getElementById('timeline_' + key);
        container.innerHTML = '';



        var options = {
            // Vue initiale de la timeline
            min: new Date(date +'T08:00:00'),
            max: new Date(date +'T18:00:00'),
            zoomMin: 1000 * 60 * 60,  // Limite de zoom minimum (1 heure)
            zoomMax: 1000 * 60 * 60 * 24,  // Limite de zoom maximum (1 jour)

        };

        const timeline = new Timeline(container, new DataSet(value), options);
        timeline.on('click', function(properties) {
            if (properties.item) {
                const item = timeline.itemsData.get(properties.item);

            }
        });
    }

}

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

function addMarker( item, position, title, map, icon={}, animation, type) {

    const marker = new google.maps.Marker({
        position,
        map,
        title : title,
        icon: icon,
        animation: animation,
    });

    if(type === 'technicien') {
        markersTechnicien[item.id] = marker;

    }else {
        markersEvent[item.id] = marker;
    }

    return marker;
}

function addInfoWindow(marker, content, type, item) {
    const infoWindow = new google.maps.InfoWindow({
        content: content,
    });
    marker.addListener("click", () => {
        infoWindow.open(map, marker);
        if(type === 'event'){
            google.maps.event.addListenerOnce(infoWindow, 'domready', () => {

                if(item.techniciens.length > 0){
                    document.getElementById(item.techniciens[0].id).selected = true;
                }
                document.getElementById('ordre').value = item.ordre;
                const submitFormMarker = document.getElementById('submitFormMarker');
                submitFormMarker.addEventListener('click', () => {
                    const datas = {
                        client: document.getElementById('client').value,
                        codeCli: document.getElementById('codeCli').value,
                        eventId: document.getElementById('eventId').value,
                        quart: document.getElementById('quart').value,
                        technicien: document.getElementById('technicien').value,
                        ordre: document.getElementById('ordre').value,
                        date : document.getElementById('searchDate').value,
                        duree: document.getElementById('duree').value,
                        heure: document.getElementById('heure').value,


                    };


                    axios.post('admin/ordreEvent', datas).then(response => {
                        if(response.status === 200){
                            alert(response.data.response);
                            var events = response.data.events;
                            addEventTimeline(datas.date, events);

                            saveDataAndReload();
                        }

                    })
                    .catch(console.log);
                    infoWindow.close();


                });
            });
        }
    });
}

function saveDataAndReload() {
    // test avant intégration dans function saveDataAndReload
    // récuperer l'input checked technicien
    var searchDate = document.getElementById('searchDate').value;
    var inputTechniciens = Array.from(document.getElementsByClassName('inputTechnicien'));
    var techniciensChecked = inputTechniciens.filter(input => input.checked);

    localStorage.setItem([
        'techniciensChecked', JSON.stringify(techniciensChecked),
        'searchDate', JSON.stringify(searchDate),
    ]);

    window.location.reload();

}




if(window.location.pathname === '/cartography'){
    loader.load().then(initMap);
}




