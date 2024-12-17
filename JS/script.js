// Funzione per validare l'email
function validaEmail(email) {
    const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return regexEmail.test(email);
}

// Funzione per validare il CAP (5 numeri)
function validaCAP(CAP) {
    const regexCAP = /^\d{5}$/;
    return regexCAP.test(CAP);
}

// Funzione per la validazione del form
function validaForm(event) {
    let errorMessage = '';
    
    // Ottieni i valori dai campi del form
    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;
    let role = document.getElementById('role').value;
    let nome = document.getElementById('nome').value;
    let cognome = document.getElementById('cognome').value;
    let mail = document.getElementById('mail').value;
    let CAP = document.getElementById('CAP').value;
    let indirizzo = document.getElementById('indirizzo').value;

    // Controllo validità email
    if (!validaEmail(mail)) {
        errorMessage += "L'indirizzo email non è valido.\n";
    }

    // Controllo validità CAP
    if (!validaCAP(CAP)) {
        errorMessage += "Il CAP deve contenere 5 numeri.\n";
    }

    // Se ci sono errori, impediamo l'invio del form
    if (errorMessage) {
        alert(errorMessage);
        event.preventDefault();  // Impedisce l'invio del form
        return false;
    }
    
    // Se non ci sono errori, il form verrà inviato normalmente
    return true;
}
