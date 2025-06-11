export const typeConfig = {
    chauffage: {
        text: 'Chauffage',
        displayElements: ['.paramChauff'],
        hideElements: ['#paramEau'],
        fields: ['fraisDiv', 'nbFraisTR', 'pctFraisAnn', 'appQuot', 'nbRad'],
        columns: [
            { title: 'Num. Radiateur', field: 'NumRad', readonly: true },
            { title: 'Num. Calorimètre', field: 'NumCal', readonly: true },
            { title: 'Type Calo.', field: 'TypCal', readonly: true },
            { title: 'Statut', field: 'Statut', type: 'select', options: ['OK', 'A remplacer', 'A enlever'] },
            { title: 'Situation', field: 'Sit', readonly: true },
            { title: 'Coefficient', field: 'Coef', readonly: true },
            { title: 'Ancien Index', field: 'AncIdx', type: 'number', class: 'inputSaisieAncIdx', readonly: true },
            { title: 'Nouvel Index', field: 'NvIdx', type: 'number', class: 'inputSaisieNvIdx' },
            { title: 'Différence', field: 'diff', type: 'number', readonly: true }
        ],
        dataSource: 'rel_chauf_apps',
        typeRel: data => data.clichaufs?.[0]?.TypRlv
    },
    eau: {
        text: 'Eau',
        displayElements: ['#paramEau', '.paramEau'],
        hideElements: ['.paramChauff'],
        fields: ['fraisDiv', 'nbFraisTR', 'pctFraisAnn', 'nbCptEauFroid', 'nbCptEauChaud'],
        columns: [
            { title: 'No', field: 'NoCpt', readonly: true },
            { title: 'Num. Compteur', field: 'NumCpt', readonly: true },
            { title: 'Statut', field: 'Statut', type: 'select', options: ['OK', 'A remplacer', 'A enlever'] },
            { title: 'Situation', field: 'Sit', readonly: true },
            { title: 'Eau Froide Anc. Idx.', field: 'AncIdxF', type: 'number', readonly: true },
            { title: 'Eau Froide Nv. Idx.', field: 'NvIdxF', type: 'number', class: 'inputSaisieNvIdx' },
            { title: 'Eau Chaude Anc. Idx.', field: 'AncIdxC', type: 'number', readonly: true },
            { title: 'Eau Chaude Nv. Idx.', field: 'NvIdxC', type: 'number', class: 'inputSaisieNvIdx' }
        ],
        dataSource: 'rel_eau_apps',
        typeRel: data => data.cli_eaus?.[0]?.TypRlv
    },
    gaz: {
        text: 'Gaz',
        displayElements: ['#paramEau'],
        hideElements: ['.paramChauff'],
        fields: ['fraisDiv', 'nbFraisTR', 'pctFraisAnn', 'nbCptGaz'],
        columns: [
            { title: 'Num. Compteur', field: 'NumCpt', readonly: true },
            { title: 'Type relevé', field: 'TypRlv', readonly: true },
            { title: 'Statut', field: 'Statut', type: 'select', options: ['OK', 'A remplacer', 'A enlever'] },
            { title: 'Situation', field: 'Sit', readonly: true },
            { title: 'Numéro de série', field: 'NoCpt', readonly: true },
            { title: 'Ancien Index', field: 'NvIdx', type: 'number', class: 'inputSaisieAncIdx', readonly: true },
            { title: 'Nouvel Index', field: 'NvIdx', type: 'number', class: 'inputSaisieNvIdx' },
            { title: 'Différence', field: 'diff', type: 'number', readonly: true }
        ],
        dataSource: 'rel_gaz_apps',
        typeRel: data => data.cli_gazs?.[0]?.TypRlv
    },
    elec: {
        text: 'Electricité',
        displayElements: ['#paramEau'],
        hideElements: ['.paramChauff'],
        fields: ['fraisDiv', 'nbFraisTR', 'pctFraisAnn', 'nbCptElec'],
        columns: [
            { title: 'Num. Compteur', field: 'NumCpt', readonly: true },
            { title: 'Type relevé', field: 'TypRlv', readonly: true },
            { title: 'Statut', field: 'Statut', type: 'select', options: ['OK', 'A remplacer', 'A enlever'] },
            { title: 'Situation', field: 'Sit', readonly: true },
            { title: 'Numéro de série', field: 'NoCpt', readonly: true },
            { title: 'Ancien Index', field: 'NvIdx', type: 'number', class: 'inputSaisieAncIdx', readonly: true },
            { title: 'Nouvel Index', field: 'NvIdx', type: 'number', class: 'inputSaisieNvIdx' },
            { title: 'Différence', field: 'diff', type: 'number', readonly: true }
        ],
        dataSource: 'rel_elec_apps',
        typeRel: data => data.cli_elecs?.[0]?.TypRlv
    }
}; 