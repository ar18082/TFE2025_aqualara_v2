export function getDetail(codeCliImmeuble){
    axios.get('/ajax/getDetail/'+codeCliImmeuble)
        .then(function(response) {
            console.log(response.data);
            var data = response.data;
            document.getElementById('codeImmeubleValue').innerHTML = '<span style="color: grey">Code immeuble :</span>' + ' ' + data.Codecli;
            document.getElementById('referenceTRValue').innerHTML ='<span style="color: grey">Référence T.R. :</span>' + ' ' + data.Codecli;
            document.getElementById('nameImmeuble').innerHTML ='<span style="color: grey">Nom :</span>' + ' ' + data.nom;
            document.getElementById('addressImmeuble').innerHTML = '<span style="color: grey">Rue : </span>'+ ' ' +data.rue;
            document.getElementById('codePaysImmeuble').innerHTML = '<span style="color: grey">Code Pays :</span>' + ' ' + data.codepays;
            document.getElementById('cpImmeuble').innerHTML = '<span style="color: grey">Postal :</span> ' + ' ' + data.codepost + ' ' + data.code_postelbs[0].Localite;
            document.getElementById('langueDecompteImmeuble').innerHTML = '<span style="color: grey">Langue Décompte :</span> ' + (data.gerant_imms[0].contacts.length > 0 ? data.gerant_imms[0].contacts[0].codlng : 'FR');
            document.getElementById('phoneImmeuble').innerHTML = '<span style="color: grey">Téléphone :</span>' + ' ' + (data.tel === null ? 'Non renseigné' : data.tel);
            document.getElementById('remarque').value = data.remarque;
            document.getElementById('nbAppart').innerHTML = '<span style="color: grey">Nombre d\'appartements :</span>' + ' ' + (data.nbAppartement ?? 0);
            const typeAppareilPresent = document.getElementById('typeAppareilPresent');
            typeAppareilPresent.innerHTML = '';
            if (data.clichaufs.length > 0 || data.cli_eaus.length > 0 || data.DecompteUnite === 1) {
                if (data.clichaufs.length > 0) {
                    var li = document.createElement('li');
                    var titleh5 = document.createElement('h5');
                    titleh5.className = 'card-title';
                    titleh5.innerHTML = 'Chauffage';
                    li.appendChild(titleh5);
                    typeAppareilPresent.appendChild(li);
                }
                if (data.cli_eaus.length > 0) {
                    var li2 = document.createElement('li');
                    var titleh5_2 = document.createElement('h5');
                    titleh5_2.className = 'card-title';
                    titleh5_2.innerHTML = 'Eau';
                    li2.appendChild(titleh5_2);
                    typeAppareilPresent.appendChild(li2);
                }

                if (data.DecompteUnite === 1) {
                    var li3 = document.createElement('li');
                    var titleh5_3 = document.createElement('h5');
                    titleh5_3.className = 'card-title';
                    titleh5_3.innerHTML = `Decompte unitaire  <span style="color: green"><i class="fa-solid fa-circle-check"></i></span>`;
                    li3.appendChild(titleh5_3);
                    typeAppareilPresent.appendChild(li3);
                }
            }

        })
        .catch(function (error) {
            console.log(error);
        });
}
