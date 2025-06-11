<div class="container-fluid">
    <div class="row">
        <!-- Sélection de l'appartement -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="refAppTR">Appartement</label>
                                <select class="form-select" id="refAppTR" name="refAppTR">

                                    @foreach($appartements as $app)
                                    <option value="{{ $app->RefAppTR }}">
                                        {{ $app->RefAppTR }} - {{ $app->RefAppCli }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dateReleve">Date de relevé</label>
                                <input type="date" class="form-control" id="dateReleve" name="dateReleve">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation des types -->
        <div class="col-12 mb-4">
            <div class="nav nav-tabs">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <button id="chauffage" type="button" class="nav-link active">Chauffage</button>
                    </li>
                    <li class="nav-item">
                        <button id="eau" type="button" class="nav-link">Eaux</button>
                    </li>
                    <li class="nav-item">
                        <button id="gaz" type="button" class="nav-link">Gaz</button>
                    </li>
                    <li class="nav-item">
                        <button id="elec" type="button" class="nav-link">Electricité</button>
                    </li>
                </ul>
            </div>
        </div>
        <div id="parametres" class="col-12 mb-4">

        </div>

        <div id="saisie" class="col-12">

        </div>
    </div>
</div>

<script>
    const btnChauffage = document.getElementById('chauffage');
   const btnEau = document.getElementById('eau');
   const btnGaz = document.getElementById('gaz');
   const btnElec = document.getElementById('elec');

    function loadParametres(type) {
        const refAppTR = document.getElementById('refAppTR').value;
        const codeCli = '{{ $codeCli }}';

        axios.get('/parametres', {
            params: {
                type: type,
                codeCli: codeCli,
                refAppTR: refAppTR
            }
        })
        .then(response => {
            console.log('Réponse reçue:', response.data);
            document.getElementById('parametres').innerHTML = '';
            document.getElementById('parametres').innerHTML = response.data;
        })
        .catch(error => {
            console.error('Erreur:', error.response?.data || error.message);
            // document.getElementById('parametres').innerHTML = 
            //     '<div class="alert alert-danger">Erreur lors du chargement des paramètres</div>';
        });
    }

    function loadSaisie(type) {
        const refAppTR = document.getElementById('refAppTR').value;
        const codeCli = '{{ $codeCli }}';

        axios.get('/saisie', {
            params: {
                type: type,
                codeCli: codeCli,
                refAppTR: refAppTR
            }
        })
        .then(response => {
            console.log('Réponse reçue:', response.data);
            document.getElementById('saisie').innerHTML = '';
            document.getElementById('saisie').innerHTML = response.data;
        })
        .catch(error => {
            console.error('Erreur:', error.response?.data || error.message);
        });
    }

        // Chargement initial des paramètres pour le chauffage
    document.addEventListener('DOMContentLoaded', () => {
        loadParametres('chauffage');
        loadSaisie('chauffage');
    });

    btnChauffage.addEventListener('click', () => {
        btnChauffage.classList.add('active');
        btnEau.classList.remove('active');
        btnGaz.classList.remove('active');
        btnElec.classList.remove('active');
        loadParametres('chauffage');
        loadSaisie('chauffage');
    });

    btnEau.addEventListener('click', () => {
        btnChauffage.classList.remove('active');
        btnEau.classList.add('active');
        btnGaz.classList.remove('active');
        btnElec.classList.remove('active');
        loadParametres('eau');
        loadSaisie('eau');
    });

    btnGaz.addEventListener('click', () => {
        btnChauffage.classList.remove('active');
        btnEau.classList.remove('active');
        btnGaz.classList.add('active');
        btnElec.classList.remove('active');
        loadParametres('gaz');
        loadSaisie('gaz');
    });

    btnElec.addEventListener('click', () => {
        btnChauffage.classList.remove('active');
        btnEau.classList.remove('active');
        btnGaz.classList.remove('active');
        btnElec.classList.add('active');
        loadParametres('elec');
        loadSaisie('elec');
    });
</script>

<script>
    console.log('Script de paramètres chargé');
    
    function toggleInputs(isUnlocked) {
        const inputs = Array.from(document.getElementsByClassName('input_param'));
        console.log('Nombre d\'inputs trouvés:', inputs.length);
        
        inputs.forEach(input => {
            
                input.disabled = !isUnlocked;
                input.classList.toggle('input-lock', !isUnlocked);
                input.classList.toggle('input-unlock', isUnlocked);
                console.log('Input modifié:', input.name, 'État:', isUnlocked ? 'déverrouillé' : 'verrouillé');
           
        });
    }

    let isUnlocked = false;
    
    document.addEventListener('keydown', function(e) {
        if (e.key === '(' && !e.repeat) {
            console.log('Touche ( détectée');
            isUnlocked = !isUnlocked;
            toggleInputs(isUnlocked);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM chargé');
        toggleInputs(false); // S'assurer que les inputs sont verrouillés au chargement
    });
</script>

<script>
    console.log('Script de saisie chargé');
    
    function toggleInputsSaisie(isUnlocked) {
        const inputs_saisie = Array.from(document.getElementsByClassName('input_saisie'));
        console.log('Nombre d\'inputs trouvés:', inputs_saisie.length); // Correction: inputs_saisie au lieu de inputs
        
        inputs_saisie.forEach(input_saisie => {
            input_saisie.disabled = !isUnlocked;
            input_saisie.classList.toggle('input-lock', !isUnlocked);
            input_saisie.classList.toggle('input-unlock', isUnlocked);
            console.log('Input modifié:', input_saisie.name, 'État:', isUnlocked ? 'déverrouillé' : 'verrouillé');
        });
    }

    let isUnlockedSaisie = false; // Renommé pour éviter le conflit avec la variable isUnlocked du script précédent
    
    document.addEventListener('keydown', function(e) {
        if (e.key === '§' && !e.repeat) {
            console.log('Touche § détectée'); // Correction du message de log
            isUnlockedSaisie = !isUnlockedSaisie;
            toggleInputsSaisie(isUnlockedSaisie);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM chargé');
        toggleInputsSaisie(false);
    });

    console.log('Script de saisie test chargé');
    
    function toggleInputsSaisie_numRad(isUnlocked) {
        const inputs_saisie_numCal = Array.from(document.getElementsByClassName('input_saisie_numCal'));
        console.log('Nombre d\'inputs trouvés:', inputs_saisie_numCal.length);
        
        inputs_saisie_numCal.forEach(input_saisie_numCal => {
            input_saisie_numCal.disabled = !isUnlocked;
            input_saisie_numCal.classList.toggle('input-lock', !isUnlocked);
            input_saisie_numCal.classList.toggle('input-unlock', isUnlocked);
            console.log('Input modifié:', input_saisie_numCal.name, 'État:', isUnlocked ? 'déverrouillé' : 'verrouillé');
        });
    }

    let isUnlockedSaisie_numCal = false;
    
    document.addEventListener('DOMContentLoaded', function() {
        const btn_saisie = document.getElementsByClassName('btn_saisie');
        console.log('Boutons saisie trouvés:', btn_saisie);
        
        if (btn_saisie.length > 0) {
            Array.from(btn_saisie).forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Bouton saisie cliqué');
                    isUnlockedSaisie_numCal = !isUnlockedSaisie_numCal;
                    toggleInputsSaisie_numCal(isUnlockedSaisie_numCal);
                });
            });
        }

        console.log('DOM chargé');
        toggleInputsSaisie_numCal(false);
    });
</script>

<script>
    // Gestionnaire global pour les événements de saisie
    document.addEventListener('keydown', function(e) {
        if (e.key === '§' && !e.repeat) {
            console.log('Touche § détectée globalement');
            const inputs_saisie = document.getElementsByClassName('input_saisie');
            const isUnlocked = inputs_saisie[0]?.classList.contains('input-lock') ?? false;
            
            Array.from(inputs_saisie).forEach(input => {
                input.disabled = !isUnlocked;
                input.classList.toggle('input-lock', !isUnlocked);
                input.classList.toggle('input-unlock', isUnlocked);
                console.log('Input modifié:', input.name, 'État:', isUnlocked ? 'déverrouillé' : 'verrouillé');
            });
        }
    });

    // Fonction pour déverrouiller une colonne
    function unlockColumn(button, columnIndex) {
        const table = button.closest('table');
        const rows = table.querySelectorAll('tbody tr');
        
        // Déverrouiller tous les inputs de la colonne
        rows.forEach(row => {
            const cell = row.children[columnIndex];
            const input = cell.querySelector('input');
            input.classList.remove('input-lock');
            input.disabled = false;
        });
    }

    // Gestionnaire global pour les boutons de colonnes
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn_saisie')) {
            e.preventDefault();
            const button = e.target;
            const columnIndex = Array.from(button.closest('tr').children).indexOf(button.closest('th'));
            button.classList.toggle('active');
            
            if (button.classList.contains('active')) {
                unlockColumn(button, columnIndex);
                const firstInput = button.closest('table').querySelector('tbody tr:first-child td:nth-child(' + (columnIndex + 1) + ') input');
                if (firstInput) {
                    firstInput.focus();
                }
            } else {
                const rows = button.closest('table').querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const cell = row.children[columnIndex];
                    const input = cell.querySelector('input');
                    input.classList.add('input-lock');
                    input.disabled = true;
                });
            }
        }
    });

    // Gestionnaire global pour la navigation avec les flèches
    document.addEventListener('keydown', function(e) {
        console.log('Touche directionnelle pressée:', e.key);
        if (['ArrowUp', 'Enter', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
            e.preventDefault();
            console.log('Touche directionnelle pressée:', e.key);
            
            const currentInput = document.activeElement;
            // Vérifier si c'est un input dans le tableau
            if (!currentInput.closest('table')) {
                console.log('Pas dans un tableau, on ignore');
                return;
            }

            const currentCell = currentInput.closest('td');
            if (!currentCell) {
                console.log('Pas de cellule parente trouvée');
                return;
            }

            const currentRow = currentCell.closest('tr');
            const table = currentRow.closest('table');
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const currentRowIndex = rows.indexOf(currentRow);
            const currentRowCells = Array.from(currentRow.querySelectorAll('td'));
            const currentCellIndex = currentRowCells.indexOf(currentCell);

            let nextInput = null;

            switch(e.key) {
                case 'ArrowRight':
                    for (let i = currentCellIndex + 1; i < currentRowCells.length; i++) {
                        const input = currentRowCells[i].querySelector('input');
                        if (input && !input.disabled && !input.classList.contains('input-lock')) {
                            nextInput = input;
                            break;
                        }
                    }
                    break;
                    
                case 'ArrowLeft':
                    for (let i = currentCellIndex - 1; i >= 0; i--) {
                        const input = currentRowCells[i].querySelector('input');
                        if (input && !input.disabled && !input.classList.contains('input-lock')) {
                            nextInput = input;
                            break;
                        }
                    }
                    break;
                    
                case 'Enter':
                    for (let i = currentRowIndex + 1; i < rows.length; i++) {
                        const input = rows[i].querySelectorAll('td')[currentCellIndex]?.querySelector('input');
                        if (input && !input.disabled && !input.classList.contains('input-lock')) {
                            nextInput = input;
                            break;
                        }
                    }
                    break;
                    
                case 'ArrowUp':
                    for (let i = currentRowIndex - 1; i >= 0; i--) {
                        const input = rows[i].querySelectorAll('td')[currentCellIndex]?.querySelector('input');
                        if (input && !input.disabled && !input.classList.contains('input-lock')) {
                            nextInput = input;
                            break;
                        }
                    }
                    break;
            }()

            if (nextInput) {
                console.log('Focus sur le prochain input:', nextInput);
                nextInput.focus();
            } else {
                console.log('Pas de prochain input trouvé');
            }
        }
        if (e.key === '§') {
            e.preventDefault();
            console.log('Touche § détectée pour déverrouiller les colonnes statut et nvIdx');
            const firstTable = document.querySelector('.table');
            if (firstTable) {
                // Gérer la colonne statut
                const statutButton = firstTable.querySelector('.btn_saisie.statut');
                if (statutButton) {
                    const statutColumnIndex = Array.from(statutButton.closest('tr').children).indexOf(statutButton.closest('th'));
                    statutButton.classList.toggle('active');
                    
                    if (statutButton.classList.contains('active')) {
                        unlockColumn(statutButton, statutColumnIndex);
                    } else {
                        const rows = statutButton.closest('table').querySelectorAll('tbody tr');
                        rows.forEach(row => {
                            const cell = row.children[statutColumnIndex];
                            const input = cell.querySelector('input');
                            input.classList.add('input-lock');
                            input.disabled = true;
                        });
                    }
                }

                // Gérer la colonne nvIdx
                const nvIdxButton = firstTable.querySelector('.btn_saisie.nvIdx');
                if (nvIdxButton) {
                    const nvIdxColumnIndex = Array.from(nvIdxButton.closest('tr').children).indexOf(nvIdxButton.closest('th'));
                    const isCurrentlyLocked = nvIdxButton.classList.contains('active');
                    nvIdxButton.classList.toggle('active');
                    
                    if (nvIdxButton.classList.contains('active')) {
                        unlockColumn(nvIdxButton, nvIdxColumnIndex);
                        // Focuser le premier input de la colonne nvIdx seulement si elle était verrouillée
                        if (!isCurrentlyLocked) {
                           console.log('nvIdxButton est verrouillé');
                            const firstInput = firstTable.querySelector('tbody tr:first-child td:nth-child(' + (nvIdxColumnIndex + 1) + ') input');                            
                            if (firstInput) {
                                firstInput.focus();
                            }
                        }
                    } else {
                        const rows = nvIdxButton.closest('table').querySelectorAll('tbody tr');
                        rows.forEach(row => {
                            const cell = row.children[nvIdxColumnIndex];
                            const input = cell.querySelector('input');
                            input.classList.add('input-lock');
                            input.disabled = true;
                        });
                    }
                }
            }
        }
    });
</script>