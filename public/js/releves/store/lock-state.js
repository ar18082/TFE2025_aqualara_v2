// Store pour gérer l'état de verrouillage des relevés
window.lockStateStore = {
    state: new Map(), // Map pour stocker l'état de verrouillage par appartement et type
    subscribers: [], // Liste des abonnés aux changements d'état

    // Initialiser l'état de verrouillage
    init(refAppTR, type) {
        const key = this.getKey(refAppTR, type);
        if (!this.state.has(key)) {
            this.state.set(key, false);
        }
    },

    // Obtenir la clé unique pour un appartement et un type
    getKey(refAppTR, type) {
        return `${refAppTR}-${type}`;
    },

    // Vérifier si un relevé est verrouillé
    isLocked(refAppTR, type) {
        const key = this.getKey(refAppTR, type);
        this.init(refAppTR, type);
        return this.state.get(key);
    },

    // Basculer l'état de verrouillage
    toggle(refAppTR, type) {
        const key = this.getKey(refAppTR, type);
        this.init(refAppTR, type);
        const newState = !this.state.get(key);
        this.state.set(key, newState);
        
        // Notifier les abonnés
        this.notifySubscribers({
            refAppTR,
            type,
            isLocked: newState
        });
    },

    // S'abonner aux changements d'état
    subscribe(callback) {
        this.subscribers.push(callback);
        return () => {
            this.subscribers = this.subscribers.filter(cb => cb !== callback);
        };
    },

    // Notifier tous les abonnés d'un changement
    notifySubscribers(state) {
        this.subscribers.forEach(callback => callback(state));
    }
}; 