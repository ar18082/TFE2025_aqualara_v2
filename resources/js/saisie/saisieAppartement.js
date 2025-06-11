import { infoParam } from './saisieParametres.js';
import { apiService } from './services/apiService.js';

export function initializeAppartement() {
    const codeCli = window.location.pathname.split('/')[2];
    const refAppTR = document.getElementById('refAppTR');
    const refAppCli = document.getElementById('refAppCli');

    if (!refAppTR || !refAppCli) return;

    apiService.getClientData(codeCli)
        .then(data => {
            initializeSelects(data, refAppTR, refAppCli);
            initializeEventListeners(data, refAppTR, refAppCli);
            initializeDateHandling();
        })
        .catch(console.error);
}

function initializeSelects(data, refAppTR, refAppCli) {
    // Création des options pour les select
    data.appartements.forEach(appartement => {
        const optionTR = createOption(appartement.RefAppTR, appartement.RefAppTR, 'optionTR');
        const optionCli = createOption(appartement.RefAppTR, appartement.RefAppCli);
        
        refAppTR.appendChild(optionTR);
        refAppCli.appendChild(optionCli);
    });

    // Sélection par défaut
    refAppTR.querySelector('option[value="1"]')?.setAttribute('selected', 'selected');
    refAppCli.querySelector('option[value="1"]')?.setAttribute('selected', 'selected');

    infoParam(data.Codecli, refAppTR.value, document.getElementById('title').innerText.toLowerCase());
}

function createOption(value, text, className = '') {
    const option = document.createElement('option');
    option.value = value;
    option.text = text;
    if (className) option.className = className;
    return option;
}

function initializeEventListeners(data, refAppTR, refAppCli) {
    refAppTR.addEventListener('change', function() {
        handleSelectChange(this.value, refAppTR, refAppCli);
        infoParam(data.Codecli, this.value, document.getElementById('title').innerText.toLowerCase());
    });

    refAppCli.addEventListener('change', function() {
        handleSelectChange(this.value, refAppTR, refAppCli);
    });
}

function handleSelectChange(selectedValue, refAppTR, refAppCli) {
    const selects = [refAppTR, refAppCli];
    selects.forEach(select => {
        select.querySelectorAll('option').forEach(option => {
            option.selected = option.value === selectedValue;
        });
    });
}

function initializeDateHandling() {
    document.addEventListener('keydown', (event) => {
        const dateRlv = document.getElementById('dateRlv');
        const createDate = document.getElementById('createDate');

        if (!dateRlv || !createDate) return;

        if (event.key === '+') {
            handleDateAddition(dateRlv, createDate);
        } else if (event.key === '-') {
            handleDateDeletion(dateRlv);
        }
    });
}

function handleDateAddition(dateRlv, createDate) {
    const optionExists = Array.from(dateRlv.options).some(option => option.value === createDate.value);
    if (optionExists) return;

    // Désélectionner les options existantes
    Array.from(dateRlv.options).forEach(option => option.removeAttribute('selected'));

    // Créer et ajouter la nouvelle option
    const option = document.createElement('option');
    option.value = createDate.value;
    option.text = new Date(createDate.value).toLocaleDateString('fr-FR');
    option.setAttribute('selected', 'selected');
    dateRlv.appendChild(option);

    // Gérer le stockage si nécessaire
    const checkbox = document.getElementById('checkboxDateImmeuble');
    if (checkbox?.checked) {
        const storedDatas = JSON.parse(sessionStorage.getItem('datas')) || [];
        if (!storedDatas.includes(createDate.value)) {
            storedDatas.push(createDate.value);
            sessionStorage.setItem('datas', JSON.stringify(storedDatas));
        }
        checkbox.checked = false;
    }
}

function handleDateDeletion(dateRlv) {
    Array.from(dateRlv.options).forEach(option => {
        if (option.selected) {
            if (confirm(`Supprimer cette date de relevé ${option.text} ?`)) {
                dateRlv.removeChild(option);
            }
        }
    });
}
