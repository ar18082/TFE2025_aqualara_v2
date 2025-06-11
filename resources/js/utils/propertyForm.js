
document.addEventListener('DOMContentLoaded', function() {
    if (/^\/admin\/.+/.test(window.location.pathname)) {
        var addRow = document.getElementById('addRow');
        var isFormFrozen = true;
        var tbody = document.getElementById('tbody');
        var i = 0;

        addRow.addEventListener('click', function () {
            var newRow = tbody.insertRow();
            newRow.className = 'row';

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            var cell7 = newRow.insertCell(6);


            cell1.className = 'col-2';
            cell1.innerHTML = '<input type="text"  class="form-control" name="serialNumber_' + i + '">';
            cell2.className = 'col-2';
            cell2.innerHTML = '<input type="text" class="form-control" name="type_' + i + '">';
            cell3.className = 'col-1';
            cell3.innerHTML = '<input type="text" class="form-control" name="status_' + i + '">';
            cell4.className = 'col-2';
            cell4.innerHTML = '<input type="text" class="form-control" name="situation_' + i + '">';
            cell5.className = 'col-2';
            cell5.innerHTML = '<input type="text" class="form-control" name="coefficient_' + i + '">';
            cell6.className = 'col-2';
            cell6.innerHTML = '<select class="form-control materiel col-5" name="materiel_id_'+ i + '"></select>';
            cell7.className = 'col-1';
            cell7.innerHTML = '<div class="form-check form-switch"> <input class="form-check-input" type="checkbox" role="switch" id="actif_' + i + '" name="actif_' + i + '" checked> </div>';


            // Reinitialize select2 on the new select element
            $('.materiel').select2({

                placeholder: 'Choisir un materiel',
                ajax: {
                    url: '/searchByMateriel',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {

                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.nom + ' - ' + item.genre + ' - ' + item.type + ' - ' + item.dimension + ' - ' + item.communication,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            i++;
        });
    }
});





