if(window.location.pathname.includes("/cartography")){
    // Sélectionner les éléments
    const dateInput = document.getElementById('searchDate');
    const incrementButton = document.getElementById('increment');
    const decrementButton = document.getElementById('decrement');

    // Initialiser la date par défaut à aujourd'hui
    const today = new Date().toISOString().split('T')[0];
    dateInput.value = today;

    // Fonction pour incrémenter la date
    function incrementDate() {
        const currentDate = new Date(dateInput.value);
        currentDate.setDate(currentDate.getDate() + 1);  // Incrémente de 1 jour
        dateInput.value = currentDate.toISOString().split('T')[0];  // Mettre à jour l'input
    }

    // Fonction pour décrémenter la date
    function decrementDate() {
        const currentDate = new Date(dateInput.value);
        currentDate.setDate(currentDate.getDate() - 1);  // Décrémente de 1 jour
        dateInput.value = currentDate.toISOString().split('T')[0];  // Mettre à jour l'input
    }

    // Écouter les clics sur les boutons
    incrementButton.addEventListener('click', incrementDate);
    decrementButton.addEventListener('click', decrementDate);

};



