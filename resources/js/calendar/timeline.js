import { Timeline } from 'vis-timeline/standalone';
import { DataSet } from 'vis-data';
import axios from "axios";

//import 'vis-timeline/styles/vis-timeline-graph2d.min.css';

export function addEventTimeline(date, techniciens) {

    // // var dateFormatted = new Date(date).toISOString().slice(0, 10);
    // var datas = {};
    //
    //
    //
    // axios.post('/ajax/eventTimelineAjax', { date: date})
    //     .then(response =>{
    //         var events = response.data;
    //
    //         for(let i = 0; i < events.length; i++){
    //
    //             if(events[i].techniciens.length > 0){
    //                 for(let j = 0; j < events[i].techniciens.length; j++){
    //                     if(!datas[events[i].techniciens[j].id] && events[i].techniciens[j].id in techniciens){
    //                         datas[events[i].techniciens[j].id] = [];
    //                     }
    //                     if(datas[events[i].techniciens[j].id]){
    //                         console.log(events[i]);
    //                         datas[events[i].techniciens[j].id].push({
    //                             id: events[i].id,
    //                             content: events[i].ordre + ' - ' + events[i].client.nom + ' - ' + events[i].type_event.abreviation,
    //                             start: events[i].start,
    //                             end: events[i].end,
    //                             priority: events[i].ordre,
    //                             className: events[i].className
    //                         });
    //                     }
    //
    //
    //                 }
    //             }
    //
    //         }
    //
    //
    //
    //         for (const [key, value] of Object.entries(datas)) {
    //
    //
    //             // ordonne les événements par priorité
    //             value.sort((a, b) => a.priority - b.priority);
    //
    //             const container = document.getElementById('timeline_' + key);
    //             container.innerHTML = '';
    //
    //
    //
    //             var options = {
    //                 // Vue initiale de la timeline
    //                 min: new Date(date +'T08:00:00'),
    //                 max: new Date(date +'T18:00:00'),
    //                 zoomMin: 1000 * 60 * 60,  // Limite de zoom minimum (1 heure)
    //                 zoomMax: 1000 * 60 * 60 * 24,  // Limite de zoom maximum (1 jour)
    //             };
    //
    //
    //
    //             const timeline = new Timeline(container, new DataSet(value), options);
    //             timeline.on('click', function(properties) {
    //                 if (properties.item) {
    //                     const item = timeline.itemsData.get(properties.item);
    //
    //                 }
    //             });
    //         }
    //
    //
    //
    //     })
    //     .catch(error  => {
    //         console.log(error);
    //     });


    // function setTimelineForDay() {
    //     var selectedDate = document.getElementById("selectedDate").value;
    //
    //     var minTime = new Date(selectedDate + 'T08:00:00');
    //     var maxTime = new Date(selectedDate + 'T18:00:00');
    //
    //     // Mise à jour de la timeline avec la plage horaire et la date sélectionnée
    //     timeline.setOptions({
    //         min: minTime,
    //         max: maxTime,
    //         start: minTime,
    //         end: maxTime
    //     });
    // }
}

