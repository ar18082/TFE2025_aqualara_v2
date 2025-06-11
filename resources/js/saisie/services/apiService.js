export const apiService = {
    async getClientData(codeCli) {
        try {
            const response = await axios.get('/ajax/saisieClientAjax', { params: { codeCli } });
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la récupération des données client:', error);
            throw error;
        }
    },

    async getParameters(codeCli, refAppTR, type) {
        try {
            const response = await axios.get('/ajax/saisieParamAjax', {
                params: { codeCli, refAppTR, type }
            });
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la récupération des paramètres:', error);
            throw error;
        }
    },

    async saveData(data) {
        try {
            const response = await axios.post('/ajax/storeSaisie', data);
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la sauvegarde:', error);
            throw error;
        }
    },

    async getNextRefAppTR(codeCli, currentRefAppTR) {
        try {
            const response = await axios.get('/ajax/getNextRefAppTR', {
                params: { codeCli, currentRefAppTR }
            });
            return response.data;
        } catch (error) {
            console.error('Erreur lors de la récupération du prochain RefAppTR:', error);
            throw error;
        }
    }
}; 