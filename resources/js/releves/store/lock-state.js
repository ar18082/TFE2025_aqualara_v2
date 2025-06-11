export const LockState = {
    LOCKED: 'locked',
    UNLOCKED: 'unlocked',
    PARTIALLY_LOCKED: 'partially_locked'
};

class LockManager {
    constructor() {
        this.state = new Map();
        this.listeners = new Set();
    }

    setLockState(appRef, type, state) {
        const key = `${appRef}-${type}`;
        this.state.set(key, state);
        this.notifyListeners();
    }

    isLocked(appRef, type) {
        const key = `${appRef}-${type}`;
        return this.state.get(key) === LockState.LOCKED;
    }

    addListener(callback) {
        this.listeners.add(callback);
    }

    removeListener(callback) {
        this.listeners.delete(callback);
    }

    notifyListeners() {
        this.listeners.forEach(callback => callback(this.state));
    }

    async toggleLock(appRef, type) {
        const key = `${appRef}-${type}`;
        const currentState = this.state.get(key);
        const newState = currentState === LockState.LOCKED ? LockState.UNLOCKED : LockState.LOCKED;

        try {
            const response = await fetch('/api/releves/lock-state', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    appRef,
                    type,
                    state: newState
                })
            });

            if (!response.ok) {
                throw new Error('Erreur lors de la mise à jour du verrouillage');
            }

            this.setLockState(appRef, type, newState);
            return true;
        } catch (error) {
            console.error('Erreur de verrouillage:', error);
            return false;
        }
    }
}

export const lockManager = new LockManager(); 