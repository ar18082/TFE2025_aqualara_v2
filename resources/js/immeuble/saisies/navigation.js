// Constantes pour les touches du clavier utilisées dans l'application
const KEYBOARD_KEYS = {
    PARENTHESIS: '(',    // Touche pour activer le mode paramètres
    SECTION: '§',        // Touche pour activer le mode saisie
    ARROW_RIGHT: 'ArrowRight',  // Navigation vers la droite
    ARROW_LEFT: 'ArrowLeft',    // Navigation vers la gauche
    ARROW_UP: 'ArrowUp',        // Navigation vers le haut
    ENTER: 'Enter'              // Validation et navigation vers le bas
};

/**
 * Classe principale pour la gestion de la navigation et de la saisie dans le tableau
 * Gère les interactions utilisateur, la navigation au clavier et la soumission des données
 */
class TableNavigationManager {
    constructor() {
        this.initialize();
    }

    /**
     * Initialise la classe si le chemin d'URL est valide
     */
    initialize() {
        if (this.isValidPath()) {
            this.setupElements();
            this.setupEventListeners();
        }
    }

    /**
     * Vérifie si l'URL courante correspond à une page de saisie d'immeuble
     * @returns {boolean} Vrai si le chemin est valide
     */
    isValidPath() {
        const path = window.location.pathname;
        return path.includes('/immeubles/') && path.includes('/saisie');
    }

    /**
     * Configure les éléments DOM et les variables d'instance nécessaires
     */
    setupElements() {
        // Sélection des éléments DOM principaux
        this.inputParams = document.querySelectorAll('.inputParam');
        this.inputSaisie = document.querySelectorAll('.inputSaisie');
        this.saisieNvIdx = document.querySelectorAll('.saisieNvIdx');
        this.colTitleBtn = document.querySelectorAll('.col-title-btn');
        
        // Extraction des paramètres de l'URL
        this.codecli = window.location.pathname.split('/')[2];
        this.type = window.location.pathname.split('/')[4];
        
        // Initialisation du tableau de données
        this.formData = [];
    }

    /**
     * Configure les écouteurs d'événements principaux
     */
    setupEventListeners() {
        document.addEventListener('keydown', this.handleKeyboardNavigation.bind(this));
        this.setupColumnButtonListeners();
    }

    /**
     * Gère la navigation au clavier et les touches spéciales
     * @param {KeyboardEvent} event - L'événement clavier
     */
    handleKeyboardNavigation(event) {
        // Gestion des touches spéciales
        if (event.key === KEYBOARD_KEYS.PARENTHESIS) {
            this.handleParenthesisKey();
            return;
        }

        if (event.key === KEYBOARD_KEYS.SECTION) {
            this.handleSectionKey();
            return;
        }

        // Gestion de la navigation dans le tableau
        const activeElement = document.activeElement;
        if (!this.isValidInputElement(activeElement)) return;

        const navigationHandlers = {
            [KEYBOARD_KEYS.ARROW_RIGHT]: () => this.navigateRight(activeElement),
            [KEYBOARD_KEYS.ARROW_LEFT]: () => this.navigateLeft(activeElement),
            [KEYBOARD_KEYS.ARROW_UP]: () => this.navigateUp(activeElement),
            [KEYBOARD_KEYS.ENTER]: () => this.handleEnter(activeElement)
        };

        const handler = navigationHandlers[event.key];
        if (handler) handler();
    }

    /**
     * Gère l'appui sur la touche parenthèse (mode paramètres)
     */
    handleParenthesisKey() {
        const dateRlv = document.getElementById('dateRlv').value;
        if (!dateRlv) {
            alert('Vous n\'avez pas sélectionné de date de relevé');
            return;
        }

        let sendChecked = false;

        // Active/désactive les champs de paramètres
        this.inputParams.forEach((input, key) => {
            if (input.disabled) {
                input.disabled = false;
                sendChecked = false;
            } else {
                input.disabled = true;
                sendChecked = true;
            }
        });

        if(sendChecked) {
            this.sendParametres();
        }
        
        // Désactive les champs de saisie d'index
        this.saisieNvIdx.forEach(input => {
            input.disabled = true;
        });
    }

    /**
     * Gère l'appui sur la touche section (mode saisie)
     */
    handleSectionKey() {
        const dateRlv = document.getElementById('dateRlv').value;
        if (!dateRlv) {
            alert('Vous n\'avez pas sélectionné de date de relevé');
            return;
        }

        // Désactive les champs de paramètres
        this.inputParams.forEach(input => {
            input.disabled = true;
        });

        // Active/désactive les champs de saisie d'index
        this.saisieNvIdx.forEach((input, key) => {
            input.disabled = !input.disabled;
            if (!input.disabled && key === 0) input.focus();
        });
    }

    /**
     * Vérifie si l'élément est un champ de saisie valide
     * @param {HTMLElement} element - L'élément à vérifier
     * @returns {boolean} Vrai si l'élément est valide
     */
    isValidInputElement(element) {
        return element && element.classList.contains('inputSaisie');
    }

    /**
     * Récupère le contexte du tableau pour un élément donné
     * @param {HTMLElement} element - L'élément pour lequel récupérer le contexte
     * @returns {Object} Le contexte du tableau
     */
    getTableContext(element) {
        const currentRow = element.closest('tr');
        const currentCell = element.closest('td');
        return {
            row: currentRow,
            cell: currentCell,
            allCells: Array.from(currentRow.cells),
            tableBody: currentRow.closest('tbody'),
            currentIndex: Array.from(currentRow.cells).indexOf(currentCell)
        };
    }

    /**
     * Méthodes de navigation dans différentes directions
     */
    navigateRight(element) {
        const context = this.getTableContext(element);
        const nextElement = this.findNextElement(context, 'right');
        this.focusElement(nextElement);
    }

    navigateLeft(element) {
        const context = this.getTableContext(element);
        const nextElement = this.findNextElement(context, 'left');
        this.focusElement(nextElement);
    }

    navigateUp(element) {
        const context = this.getTableContext(element);
        const nextElement = this.findNextElement(context, 'up');
        this.focusElement(nextElement);
    }

    /**
     * Gère la touche Entrée pour la navigation et le traitement des données
     */
    handleEnter(element) {
        const context = this.getTableContext(element);
        const nextElement = this.findNextElement(context, 'down');
        
        if (nextElement) {
            this.focusElement(nextElement);
            this.processRowData(context.row);
        } else {
            this.handleLastRow(context);
        }
    }

    /**
     * Trouve le prochain élément selon la direction donnée
     * @param {Object} context - Le contexte du tableau
     * @param {string} direction - La direction de navigation
     * @returns {HTMLElement} Le prochain élément à focus
     */
    findNextElement(context, direction) {
        const { row, currentIndex, allCells, tableBody } = context;
        const allRows = Array.from(tableBody.rows);
        const currentRowIndex = allRows.indexOf(row);

        switch (direction) {
            case 'right':
                return this.getNextRightElement(currentIndex, allCells, currentRowIndex, allRows);
            case 'left':
                return this.getNextLeftElement(currentIndex, allCells, currentRowIndex, allRows);
            case 'up':
                return this.getNextUpElement(currentIndex, currentRowIndex, allRows);
            case 'down':
                return this.getNextDownElement(currentIndex, currentRowIndex, allRows);
            default:
                return null;
        }
    }

    /**
     * Méthodes pour trouver le prochain élément dans chaque direction
     */
    getNextRightElement(currentIndex, allCells, currentRowIndex, allRows) {
        if (currentIndex < allCells.length - 1) {
            return allCells[currentIndex + 1].querySelector('.inputSaisie');
        }
        if (currentRowIndex < allRows.length - 1) {
            return allRows[currentRowIndex + 1].cells[0].querySelector('.inputSaisie');
        }
        return null;
    }

    getNextLeftElement(currentIndex, allCells, currentRowIndex, allRows) {
        if (currentIndex > 0) {
            return allCells[currentIndex - 1].querySelector('.inputSaisie');
        }
        if (currentRowIndex > 0) {
            const previousRow = allRows[currentRowIndex - 1];
            return previousRow.cells[previousRow.cells.length - 1].querySelector('.inputSaisie');
        }
        return null;
    }

    getNextUpElement(currentIndex, currentRowIndex, allRows) {
        if (currentRowIndex > 0) {
            return allRows[currentRowIndex - 1].cells[currentIndex].querySelector('.inputSaisie');
        }
        return null;
    }

    getNextDownElement(currentIndex, currentRowIndex, allRows) {
        if (currentRowIndex < allRows.length - 1) {
            const targetRow = allRows[currentRowIndex + 1];
            return targetRow.cells[currentIndex]?.querySelector('.inputSaisie') ||
                   allRows[currentRowIndex + 2]?.cells[currentIndex]?.querySelector('.inputSaisie');
        }
        return null;
    }

    /**
     * Focus sur un élément s'il est valide et non désactivé
     */
    focusElement(element) {
        if (element && !element.disabled) {
            element.focus();
        }
    }

    /**
     * Envoie les paramètres au serveur
     * @param {HTMLElement} this.inputParams - L'élément input contenant les paramètres
     */
    async sendParametres() {
        const refAppTR = document.getElementById('refAppTR').value;
        const dateRlv = document.getElementById('dateRlv').value;
        const params = {};
        this.inputParams.forEach(input => {
            params[input.name] = input.value;
        });
        try {
            const response = await axios.post(`/immeubles/${this.codecli}/saisie/getParametres`, {
                refAppTR,
                dateRlv,
                codecli: this.codecli,
                type: this.type,
                params: params
            });
            console.log(response.data);
        } catch (error) {
            console.error('Erreur lors de l\'envoi des paramètres:', error);
        }
    }

    /**
     * Configuration des boutons de colonne
     */
    setupColumnButtonListeners() {
        this.colTitleBtn.forEach(btn => {
            btn.addEventListener('click', () => this.handleColumnButtonClick(btn));
        });
    }

    /**
     * Gère le clic sur un bouton de colonne
     */
    handleColumnButtonClick(btn) {
        const col = btn.getAttribute('data-col');
        const inputs = document.querySelectorAll(`.table-input_${col}`);
        
        inputs.forEach((input, index) => {
            input.disabled = !input.disabled;
            if (!input.disabled) {
                if(index === 0) {
                    input.focus();

                }
                this.setupStatutChangeListener(input);
                
            }
        });
    }

    /**
     * Configure l'écouteur de changement de statut
     */
    setupStatutChangeListener(input) {
        
        input.addEventListener('change', () => {
            const statut = input.value;

            // recuperer la valeur de la première colonne de la cellule de la meme ligne  
            const cell0 = input.closest('tr').cells[0].querySelector('.inputSaisie').value;
            
            
            if (['nouveau', 'remplace', 'refix', 'supprime'].includes(statut)) {
                this.openStatutModal(statut, cell0);
            }
        });
    }

    /**
     * Ouvre la modal de statut
     */
    openStatutModal(statut, cell0) {
        $('#modalStatut').modal('show');
        document.getElementById('btnSubmitFormStatut').addEventListener('click', () => {
            this.handleStatutSubmit(statut, cell0);
        });
    }

    /**
     * Gère la soumission du statut
     */
    async handleStatutSubmit(statut, cell0) {
       
        const data = {
            statut : statut,
            numeroSerie: document.getElementById('numeroSerie').value,
            date: document.getElementById('date').value,
            index: document.getElementById('index').value,
            type: this.type,
            codecli: this.codecli,
            cell0: cell0,
            refAppTR : document.getElementById('refAppTR').value

        };

        try {
            const response = await axios.post(`/immeubles/${this.codecli}/saisie/statut/${statut}`, data);
            console.log(response.data);
            $('#modalStatut').modal('hide');
        } catch (error) {
            console.error('Erreur lors de la soumission du statut:', error);
        }
    }

    /**
     * Traite les données d'une ligne
     */
    processRowData(row) {
        const values = this.extractRowValues(row);
        if (!values) return;

        const difference = this.calculateDifference(values);
        if (difference === null) return;

        this.updateDifferenceField(row, difference);
        this.collectRowData(row, values, difference);
    }

    /**
     * Extrait les valeurs d'une ligne
     */
    extractRowValues(row) {
        try {
            if (this.type === 'eau') {
                return {
                    value0: row.cells[0].querySelector('.inputSaisie').value,
                    value1: row.cells[1].querySelector('.inputSaisie').value,
                    value2: row.cells[2].querySelector('.inputSaisie').value,
                    value3: row.cells[3].querySelector('.inputSaisie').value,
                    ancIdx: row.cells[4].querySelector('.saisieAncIdx').value,
                    nvIdx: row.cells[5].querySelector('.saisieNvIdx').value,
                    type: 'eau'
                };
            } else {
                return {
                    value0: row.cells[0].querySelector('.inputSaisie').value,
                    value1: row.cells[1].querySelector('.inputSaisie').value,
                    value2: row.cells[2].querySelector('.inputSaisie').value,
                    value3: row.cells[3].querySelector('.inputSaisie').value,
                    value4: row.cells[4].querySelector('.inputSaisie').value,
                    value5: row.cells[5].querySelector('.inputSaisie').value,
                    ancIdx: row.cells[6].querySelector('.saisieAncIdx').value,
                    nvIdx: row.cells[7].querySelector('.saisieNvIdx').value,
                    type: 'other'
                };
            }
        } catch (error) {
            console.error('Erreur lors de l\'extraction des valeurs:', error);
            return null;
        }
    }

    /**
     * Calcule la différence entre les index
     */
    calculateDifference(values) {
        const ancIdx = parseFloat(values.ancIdx);
        const nvIdx = parseFloat(values.nvIdx);
        const coef = parseFloat(values.type === 'eau' ? values.value3 : values.value5);

        if (nvIdx < ancIdx) {
            alert('Attention: La nouvelle valeur d\'index est inférieure à l\'ancienne valeur. Veuillez vérifier votre saisie.');
            return null;
        }

        return (nvIdx - ancIdx) * coef;
    }

    /**
     * Met à jour le champ de différence
     */
    updateDifferenceField(row, difference) {
        const diffField = this.type === 'eau' 
            ? row.cells[6].querySelector('.saisieDiff')
            : row.cells[8].querySelector('.saisieDiff');
        
        if (diffField) {
            diffField.value = difference;
        }
    }

    /**
     * Collecte les données d'une ligne
     */
    collectRowData(row, values, difference) {
        const rowData = this.type === 'eau'
            ? [values.type, values.value0, values.value1, values.value2, values.value3, values.ancIdx, values.nvIdx, difference]
            : [values.value0, values.value1, values.value2, values.value3, values.value4, values.value5, values.ancIdx, values.nvIdx, difference];

        this.formData.push(rowData);
    }

    /**
     * Gère la dernière ligne du tableau
     */
    handleLastRow() {
        this.disableAllInputs();
        this.focusRefAppTR();
        this.sendFormData();
    }

    /**
     * Désactive tous les champs de saisie
     */
    disableAllInputs() {
        this.inputParams.forEach(input => input.disabled = true);
        this.inputSaisie.forEach(input => input.disabled = true);
    }

    /**
     * Focus sur le champ RefAppTR
     */
    focusRefAppTR() {
        const refAppTR = document.getElementById('refAppTR');
        if (refAppTR) refAppTR.focus();
    }

    /**
     * Envoie les données du formulaire au serveur
     */
    async sendFormData() {
        try {
            const data = {
                formData: this.formData,
                refAppTR: document.getElementById('refAppTR').value,
                dateRlv: document.getElementById('dateRlv').value,
                type: this.type,
                codecli: this.codecli
            };

            const response = await axios.post(`/immeubles/${this.codecli}/saisie/getSaisies`, data);
            console.log('Données envoyées avec succès:', response.data);
        } catch (error) {
            console.error('Erreur lors de l\'envoi des données:', error);
        }
    }
}

// Initialisation de l'application
document.addEventListener('DOMContentLoaded', () => {
    new TableNavigationManager();
});
