
document.addEventListener('DOMContentLoaded', function () {
    if(window.location.pathname === '/admin/materiel/create'){
        var materiel = document.getElementById('materiel');
        var formMat_p2 = document.getElementById('formMateriel_p2');
        var formMat_p3 = document.getElementById('formMateriel_p3');
        var contentIntModel = document.getElementById('contentIntModel');

        materiel.addEventListener('change', function () {
            //remove content formMat_p2 and formMat_p3
            formMat_p2.innerHTML = '';
            formMat_p3.innerHTML = '';
            var type = materiel.value;
            console.log(type);
            $.ajax({
                url: '/ajax/form-part/' + type,
                method: 'GET',
                success: function (response) {
                    formMat_p2.innerHTML = "";
                    formMat_p2.innerHTML = response;

                    switch (type) {
                        case 'Compteur_eau' :
                            var genreCpt = document.getElementById('cpt_genre');
                            if (genreCpt) {
                                genreCpt.addEventListener('change', function () {
                                    var genre = genreCpt.value;
                                    console.log(genre);
                                    $.ajax({
                                        url: '/ajax/form-part-genre/' + genre,
                                        method: 'GET',
                                        success: function (response) {
                                                formMat_p3.innerHTML = "";
                                                formMat_p3.innerHTML = response;


                                            var cpt_commu_digit = document.getElementById('cpt_commu_digit');
                                            var cpt_commu_modul = document.getElementById('cpt_commu_modul');



                                            if (cpt_commu_digit) {
                                                cpt_commu_digit.addEventListener('change', function () {
                                                    var model = cpt_commu_digit.value;
                                                    console.log(cpt_commu_digit.value);
                                                    switch (model) {
                                                        case 'Visuel':
                                                            document.getElementById('cpt_digit_model').value = 'SQ1-O';
                                                            break;
                                                        case 'Lora':
                                                            document.getElementById('cpt_digit_model').value = 'SQ1-L';
                                                            break;
                                                        case 'WM-Bus':
                                                            document.getElementById('cpt_digit_model').value = 'SQ1-W';
                                                            break;
                                                        case 'R-Sontex':
                                                            document.getElementById('cpt_digit_model').value = 'SQ1-R';
                                                            break;
                                                    }

                                                });

                                            } else if (cpt_commu_modul) {
                                                cpt_commu_modul.addEventListener('change', function () {
                                                    var model = cpt_commu_modul.value;
                                                    var cpt_modul_model = document.getElementById('cpt_modul_model');


                                                    cpt_modul_model.innerHTML = '';
                                                    switch (model) {
                                                        case 'Visuel':
                                                            cpt_modul_model.innerHTML += '<option value=" ">aucun modèle</option>';
                                                            break;
                                                        case 'M-Bus':
                                                            cpt_modul_model.innerHTML += '<option value=" ">aucun modèle</option>';
                                                            break;
                                                        case 'Impulsion':
                                                            cpt_modul_model.innerHTML += '<option value=" ">aucun modèle</option>';
                                                            break;
                                                        case 'Lora':
                                                            cpt_modul_model.innerHTML += '<option value="W1-L">W1-L</option>';
                                                            break;
                                                        case 'WM-Bus':

                                                            cpt_modul_model.innerHTML += '<option value="587">587</option>';
                                                            cpt_modul_model.innerHTML += '<option value="W1-O">W1-O</option>';
                                                            break;
                                                        case 'R-Sontex':
                                                            cpt_modul_model.innerHTML += '<option value="581">581</option>';
                                                            cpt_modul_model.innerHTML += '<option value="W1-R">W1-R</option>';
                                                            break;

                                                        default:
                                                            cpt_modul_model.innerHTML += '<option value="">Sélectionnez un modèle</option>';
                                                    }

                                                });
                                            }

                                        },
                                        error: function (xhr) {
                                            console.error('Erreur lors du chargement du formulaire:', xhr);
                                        }
                                    });


                                });

                            }

                            break;
                        case 'Calorimetre' :
                            formMat_p2.innerHTML = '';
                            formMat_p3.innerHTML = '';
                            console.log('Calorimetre')

                            break;
                        case 'Integrateur' :
                            var cpt_genre = document.getElementById('cpt_genre');
                            if (cpt_genre) {
                                cpt_genre.addEventListener('change', function () {

                                   var cpt_modul_model = document.getElementById('cpt_modul_model');
                                    // ajouter les options de type de modèle

                                    switch (cpt_genre.value) {
                                        case 'sontex':
                                            cpt_modul_model.innerHTML = '';
                                            cpt_modul_model.innerHTML += '<option value=" ">aucun modèle</option>';
                                            cpt_modul_model.innerHTML += '<option value="739">739</option>';
                                            cpt_modul_model.innerHTML += '<option value="789">789</option>';
                                            cpt_modul_model.innerHTML += '<option value="supercal_5">Supercal 5</option>';
                                            cpt_modul_model.innerHTML += '<option value="supercal_531">Supercal 531</option>';

                                            cpt_modul_model.addEventListener('change', function () {
                                               switch (cpt_modul_model.value) {
                                                   case '739':
                                                       formMat_p3.innerHTML = '';
                                                        $.ajax({
                                                           url: '/ajax/form-part-model',
                                                           method: 'GET',
                                                           success: function (response) {
                                                               formMat_p3.innerHTML = "";
                                                               formMat_p3.innerHTML = response;

                                                           },
                                                           error: function (xhr) {
                                                                console.error('Erreur lors du chargement du formulaire:', xhr);
                                                           }
                                                        });

                                                        $.ajax({
                                                            url: '/ajax/form-part-commu-sontex',
                                                            method: 'GET',
                                                            success: function (response) {
                                                                formMat_p3.innerHTML += response;
                                                            },
                                                            error: function (xhr) {
                                                                console.error('Erreur lors du chargement du formulaire:', xhr);
                                                            }
                                                        });

                                                       break;
                                                   case '789':
                                                       formMat_p3.innerHTML = '';
                                                       $.ajax({
                                                           url: '/ajax/form-part-model',
                                                           method: 'GET',
                                                           success: function (response) {
                                                               formMat_p3.innerHTML = "";
                                                               formMat_p3.innerHTML = response;

                                                           },
                                                           error: function (xhr) {
                                                               console.error('Erreur lors du chargement du formulaire:', xhr);
                                                           }
                                                       });

                                                       $.ajax({
                                                           url: '/ajax/form-part-commu-sontex',
                                                           method: 'GET',
                                                           success: function (response) {
                                                               formMat_p3.innerHTML += response;
                                                           },
                                                           error: function (xhr) {
                                                               console.error('Erreur lors du chargement du formulaire:', xhr);
                                                           }
                                                       });

                                                       break;
                                                   case 'supercal_5':
                                                       formMat_p3.innerHTML = '';
                                                       $.ajax({
                                                           url: '/ajax/form-part-commu-sontex',
                                                           method: 'GET',
                                                           success: function (response) {
                                                               formMat_p3.innerHTML += response;
                                                           },
                                                           error: function (xhr) {
                                                               console.error('Erreur lors du chargement du formulaire:', xhr);
                                                           }
                                                       });


                                                       break;
                                                   case 'supercal_531':
                                                       formMat_p3.innerHTML = '';
                                                       $.ajax({
                                                           url: '/ajax/form-part-commu-sontex2',
                                                           method: 'GET',
                                                           success: function (response) {
                                                               formMat_p3.innerHTML += response;
                                                           },
                                                           error: function (xhr) {
                                                               console.error('Erreur lors du chargement du formulaire:', xhr);
                                                           }
                                                       });
                                                       break;
                                                   case ' ':
                                                       formMat_p3.innerHTML = '';

                                                       break;
                                               }
                                            });
                                            break;
                                        case 'engelmann':
                                            cpt_modul_model.innerHTML = '';
                                            cpt_modul_model.innerHTML = '<option value="SensoStar U (ultrasons)">SensoStar U (ultrasons)</option>';
                                            $.ajax({
                                                url: '/ajax/form-part-model',
                                                method: 'GET',
                                                success: function (response) {
                                                    formMat_p3.innerHTML = "";
                                                    formMat_p3.innerHTML = response;
                                                    var type_compteur = document.getElementById('type_compteur');
                                                    type_compteur.innerHTML = '';
                                                    type_compteur.innerHTML = '<option value="choisirType">Choisir type</option>';
                                                    type_compteur.innerHTML += '<option value="sonde5mm">Sonde 5 mm</option>';
                                                    type_compteur.innerHTML += '<option value="sonde5.2mm">Sonde 5.2 mm</option>';

                                                },
                                                error: function (xhr) {
                                                    console.error('Erreur lors du chargement du formulaire:', xhr);
                                                }
                                            });

                                            $.ajax({
                                                url: '/ajax/form-part-commu-sontex',
                                                method: 'GET',
                                                success: function (response) {
                                                    formMat_p3.innerHTML += response;
                                                    var cpt_commu_modul = document.getElementById('cpt_commu_modul');
                                                    cpt_commu_modul.innerHTML = '';
                                                    cpt_commu_modul.innerHTML = '<option value="model">Choisir un modèle</option>';
                                                    cpt_commu_modul.innerHTML += '<option value="visuel">visuel</option>';
                                                    cpt_commu_modul.innerHTML += '<option value="M-Bus">M-Bus</option>';
                                                    cpt_commu_modul.innerHTML += '<option value="M-Bus-3EP">M-Bus + 3 entrées puls</option>';
                                                    cpt_commu_modul.innerHTML += '<option value="impulsion">impulsion</option>';
                                                    cpt_commu_modul.innerHTML += '<option value="WM-Bus">WM-Bus</option>';
                                                    cpt_commu_modul.innerHTML += '<option value="WM-Bus-3EP">WM-Bus + 3 entrées puls</option>';

                                                },
                                                error: function (xhr) {
                                                    console.error('Erreur lors du chargement du formulaire:', xhr);
                                                }
                                            });



                                            break;
                                        case 'deltamess':
                                            cpt_modul_model.innerHTML = '';
                                            cpt_modul_model.innerHTML = '<option value="TKS WM">TKS WM</option>';
                                            $.ajax({
                                                url: '/ajax/form-part-model',
                                                method: 'GET',
                                                success: function (response) {
                                                    formMat_p3.innerHTML = "";
                                                    formMat_p3.innerHTML = response;
                                                    var contentDimension = document.getElementById('contentDimension');
                                                    contentDimension.innerHTML = '';

                                                    var type_compteur = document.getElementById('type_compteur');
                                                    type_compteur.innerHTML = '';
                                                    type_compteur.innerHTML = '<option value="choisirType">Choisir type</option>';
                                                    type_compteur.innerHTML += '<option value="sonde5.2mm">Sonde 5.2 mm</option>';
                                                    type_compteur.innerHTML += '<option value="sonde6mm">Sonde 6 mm</option>';

                                                },
                                                error: function (xhr) {
                                                    console.error('Erreur lors du chargement du formulaire:', xhr);
                                                }
                                            });

                                            $.ajax({
                                                url: '/ajax/form-part-commu-sontex',
                                                method: 'GET',
                                                success: function (response) {
                                                    formMat_p3.innerHTML += response;
                                                    var cpt_commu_modul = document.getElementById('cpt_commu_modul');
                                                    cpt_commu_modul.innerHTML = '';
                                                    cpt_commu_modul.innerHTML = '<option value="model">Choisir un modèle</option>';
                                                    cpt_commu_modul.innerHTML += '<option value="visuel">visuel</option>';
                                                    cpt_commu_modul.innerHTML += '<option value="M-Bus">WM-Bus</option>';


                                                },
                                                error: function (xhr) {
                                                    console.error('Erreur lors du chargement du formulaire:', xhr);
                                                }
                                            });


                                            break;

                                        case 'chosirMarque':
                                            type_modele.innerHTML = '';
                                            break;

                                    }
                                });
                            }

                        break;

                    }




                },
                error: function (xhr) {
                    console.error('Erreur lors du chargement du formulaire:', xhr);
                }
            });


        });

    }

});


