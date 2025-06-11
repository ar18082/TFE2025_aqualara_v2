document.addEventListener('DOMContentLoaded', function() {

    var typeErreurs = document.querySelectorAll('.typeErreur');

    //console.log(typeErreurs);

    typeErreurs.forEach(function(typeErreur){
        typeErreur.addEventListener('change', function (event){
            var selectedOption = event.target.options[event.target.selectedIndex].value;
            var typeErreurId = event.target.id;
            var idParts = typeErreurId.split('-');
            var prefix = idParts[0];
            var suffix = idParts[1];
            var appartement_Codecli = document.getElementById('appartement_Codecli').value;
            var appartement_RefAppTR = document.getElementById('appartement_RefAppTR').value;


            axios.post('/getTypeErreur', {
                prefix: prefix,
                suffix: suffix,
                typeId: typeErreurId,
                selectedOption: selectedOption,
                appartement_Codecli: appartement_Codecli,
                appartement_RefAppTR: appartement_RefAppTR,

            })
                .then(function(response) {
                    console.log('Controller response: ', response.data);
                })
                .catch(function(error) {
                    console.error('Error sending request: ', error);
                });

        });
    });
});
