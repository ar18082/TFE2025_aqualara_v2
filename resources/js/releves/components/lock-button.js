import { lockManager, LockState } from '../store/lock-state';

export function lockButton(appRef, type) {
    return {
        isLocked: false,
        isLoading: false,
        statusText: 'Déverrouillé',
        
        get lockIcon() {
            return this.isLocked ? 'fa-lock' : 'fa-lock-open';
        },

        init() {
            this.isLocked = lockManager.isLocked(appRef, type);
            this.updateStatusText();
            
            lockManager.addListener(() => {
                this.isLocked = lockManager.isLocked(appRef, type);
                this.updateStatusText();
            });
        },

        async toggleLock() {
            this.isLoading = true;
            
            try {
                const success = await lockManager.toggleLock(appRef, type);
                if (!success) {
                    throw new Error('Échec du changement de verrouillage');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors du verrouillage/déverrouillage');
            } finally {
                this.isLoading = false;
            }
        },

        updateStatusText() {
            this.statusText = this.isLocked ? 'Verrouillé' : 'Déverrouillé';
        }
    };
} 