var dropdownParent = $('#modal-body').length ? $('#modal-body') : null;

$('.client_id').select2({
    dropdownParent: dropdownParent,
    placeholder: 'entrez le numero ou le nom du client ',
    ajax: {
        url: '/searchByNameOrCodecli',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {

            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.Codecli + ': ' + item.nom,
                        id: item.id
                    }
                })
            };
        },
        cache: true
    }
});



$('.cp_localite').select2({
    placeholder: 'entrez un code postal ou une localité ',
    ajax: {
        url: '/searchByCPOrLocalite',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            console.log(data);
            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.codePost + ' ' + item.Localite,
                        id: item.id
                    }
                })
            };
        },
        cache: true
    }
});

$('.rue').select2({
    placeholder: 'entrez une rue',
    ajax: {
        url: '/searchByStreet',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            console.log(data);
            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.rue,
                        id: item.id
                    }
                })
            };
        },
        cache: true
    }
});

$('.TypeInter').select2({
    placeholder: 'entrez un type d\'Intervention',
    ajax: {
        url: '/searchByTypeInter',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            console.log(data);
            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
        },
        cache: true
    }
});

$('.materiel').select2({

    placeholder: 'Choisir un materiel',
    ajax: {
        url: '/searchByMateriel',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            console.log(data);
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





