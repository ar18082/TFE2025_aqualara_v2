import { lockManager } from '../store/lock-state';

export function chauffageReleve(codeCli, refAppTR) {
    return {
        parameters: null,
        radiateurs: [],
        isValid: true,
        
        get isLocked() {
            return lockManager.isLocked(refAppTR, 'chauffage');
        },

        async init() {
            await this.loadParameters();
            await this.loadRadiateurs();
            
            // Écouter les changements d'état de verrouillage
            lockManager.addListener(() => {
                this.updateFormState();
            });
        },

        async loadParameters() {
            try {
                const response = await fetch(`/api/releves/parameters?codeCli=${codeCli}&refAppTR=${refAppTR}&type=chauffage`);
                if (!response.ok) throw new Error('Erreur lors du chargement des paramètres');
                
                this.parameters = await response.json();
            } catch (error) {
                console.error('Erreur:', error);
                alert('Impossible de charger les paramètres');
            }
        },

        async loadRadiateurs() {
            try {
                const response = await fetch(`/api/releves/data?codeCli=${codeCli}&refAppTR=${refAppTR}&type=chauffage`);
                if (!response.ok) throw new Error('Erreur lors du chargement des radiateurs');
                
                this.radiateurs = await response.json();
                this.validateAllIndexes();
            } catch (error) {
                console.error('Erreur:', error);
                alert('Impossible de charger les données des radiateurs');
            }
        },

        validateIndex(event, index) {
            const rad = this.radiateurs[index];
            const newValue = parseFloat(event.target.value);
            const oldValue = parseFloat(rad.AncIdx);

            if (isNaN(newValue) || isNaN(oldValue)) {
                this.isValid = false;
                return;
            }

            // Validation de base : le nouvel index doit être supérieur à l'ancien
            if (newValue < oldValue) {
                event.target.classList.add('is-invalid');
                this.isValid = false;
            } else {
                event.target.classList.remove('is-invalid');
                this.validateAllIndexes();
            }
        },

        validateAllIndexes() {
            this.isValid = this.radiateurs.every(rad => {
                const newValue = parseFloat(rad.NvIdx);
                const oldValue = parseFloat(rad.AncIdx);
                return !isNaN(newValue) && !isNaN(oldValue) && newValue >= oldValue;
            });
        },

        updateFormState() {
            if (this.isLocked) {
                // Désactiver tous les champs si verrouillé
                document.querySelectorAll('.releve-chauffage input, .releve-chauffage select')
                    .forEach(el => el.setAttribute('disabled', 'disabled'));
            } else {
                // Réactiver les champs si déverrouillé
                document.querySelectorAll('.releve-chauffage input, .releve-chauffage select')
                    .forEach(el => el.removeAttribute('disabled'));
            }
        },

        async saveReleve() {
            if (!this.isValid || this.isLocked) return;

            try {
                const response = await fetch('/api/releves/chauffage', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        codeCli,
                        refAppTR,
                        parameters: this.parameters,
                        radiateurs: this.radiateurs
                    })
                });

                if (!response.ok) throw new Error('Erreur lors de l\'enregistrement');

                alert('Relevé enregistré avec succès');
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'enregistrement du relevé');
            }
        },

        resetForm() {
            if (this.isLocked) return;
            this.loadParameters();
            this.loadRadiateurs();
        }
    };
} 