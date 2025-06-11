if(window.location.pathname.includes("/immeubles/") /*|| window.location.pathname.includes("/admin/event")*/) {


    var url = window.location.pathname;
    var id = url.split('/')[2];

    // var btnNouveau = document.getElementById('btnNouveau');
    // // récupérer les données dans le href
    // var url = btnNouveau;
    //
    // // recupérer la valeur qui est apres le signe =
    // var id = url.split('=')[1];



    var techniciens = [];

    var btnSubmitFormEvent = document.getElementById('submitFormEvent');
    var inputDate = document.getElementById('date');
    var inputType = document.getElementById('TypeInter');
    axios.get('/admin/ShowEventImmeublesAjax', {
        params: {
            id: id
        }
    })
    .then(response => {
        // composer l'affichage des données
        var events = response.data;

        const tableBody = document.getElementById('eventBody');
        tableBody.innerHTML = '';
        events.forEach(event =>{
            populateTable(event, tableBody);
        })

        // search form event by date and type
        btnSubmitFormEvent.addEventListener('click', function () {
            tableBody.innerHTML = '';
            events.forEach(event => {
                if (inputDate.value === '' && inputType.value === '') {
                    populateTable(event, tableBody);
                }else if (inputDate.value === '' && inputType.value !== '') {
                    if (event.type_event.id === parseInt(inputType.value)) {
                        populateTable(event, tableBody);
                    }
                } else if (inputDate.value !== '' && inputType.value === '') {
                    if (new Date(event.start).toISOString().slice(0, 10) === inputDate.value) {

                        populateTable(event, tableBody);
                    }
                }else {
                    if (new Date(event.start).toISOString().slice(0, 10) === inputDate.value && event.type_event.id === parseInt(inputType.value)) {
                        populateTable(event, tableBody);
                    }
                }



            });
        });

    })
    .catch(error => {
        console.log(error);
    });
}

function populateTable(event, tableBody) {


    const row = document.createElement('tr');
    row.innerHTML = `
            <td>${new Date(event.start).toLocaleString('fr-FR', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
            })}</td>
            <td>${event.quart}</td>
            <td>${event.client.Codecli}</td>
            <td>${event.client.nom}</td>
            <td>${event.client.rue}</td>
            <td>${event.client.codepost}</td>
            <td>${event.type_event.name}</td>
            <td>${event.techniciens.map(tech => `${tech.nom} ${tech.prenom}`).join(', ')}</td>
            <td>${event.commentaire ? event.commentaire.replace(/\n/g, '<br>') : ''}</td>
            <td>
                <div class="d-inline">
                    <a href="/cartography?date=${event.start}&techId=${event.techniciens.length > 0 ? event.techniciens[0].id : ''}" class="btn btn-primary" id="btnMap">
                        <i class="fa-solid fa-map"></i>
                    </a>
                </div>
                <div class="d-inline">
                    <a href="/calendar?date=${event.start}" class="btn btn-primary"><i class="fa-solid fa-calendar"></i></a>
                </div>
                <div class="d-inline">
                    <a href="/admin/event/${event.id}/edit" class="btn btn-primary"><i class="fa fa-pen"></i></a>
                </div>
                <div class="d-inline">
                    <button class="btn btn-primary" onclick="deleteEvent(${event.id})"><i class="fa fa-trash"></i></button>
                </div>
            </td>
        `;

    tableBody.appendChild(row);

}
