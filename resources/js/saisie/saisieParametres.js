import { typeConfig } from './config/types.js';
import { apiService } from './services/apiService.js';

export async function infoParam(codeCli, refAppTR, type) {
    const config = typeConfig[type];
    if (!config) return;

    try {
        const data = await apiService.getParameters(codeCli, refAppTR, type);
        updateUI(config, data);
        return data;
    } catch (error) {
        console.error('Erreur lors de la mise à jour des paramètres:', error);
    }
}

function updateUI(config, data) {
    updateVisibility(config);
    updateFields(data, config);
}

function updateVisibility(config) {
    // Cacher tous les éléments
    if (config.hideElements) {
        config.hideElements.forEach(selector => {
            document.querySelectorAll(selector).forEach(el => {
                el.style.display = 'none';
            });
        });
    }

    // Afficher les éléments nécessaires
    if (config.displayElements) {
        config.displayElements.forEach(selector => {
            document.querySelectorAll(selector).forEach(el => {
                el.style.display = 'block';
            });
        });
    }
}

function updateFields(data, config) {
    const dataSource = getDataSource(data, config.dataSource);
    if (!dataSource || dataSource.length === 0) return;

    config.fields.forEach(field => {
        const element = document.getElementById(field);
        if (element) {
            element.value = dataSource[0][field] || '';
        }
    });
}

function getDataSource(data, dataSource) {
    return data[dataSource];
}
