<?php
    require_once("classes/Utente.php"); 
    session_start();

    $filePath = "files/credenziali.csv";
    $error = '';
    $success = '';

    // Funzione per validare l'email
    function validaEmail($email) {
        $regexEmail = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/'; // Regex per validare il formato email
        return preg_match($regexEmail, $email); // Restituisce true se l'email è valida
    }

    // Funzione per validare il CAP (5 numeri)
    function validaCAP($CAP) {
        $regexCAP = '/^\d{5}$/'; // Regex per assicurarsi che il CAP sia composto da 5 cifre
        return preg_match($regexCAP, $CAP); // Restituisce true se il CAP è valido
    }

    // Funzione per validare nome e cognome (solo lettere e spazi)
    function validaNomeCognome($nomeCognome) {
        $regexLettere = '/^[a-zA-ZàèéìòùÀÈÉÌÒÙ\s]+$/'; // Regex per consentire solo lettere e spazi
        return preg_match($regexLettere, $nomeCognome); // Restituisce true se il nome o cognome è valido
    }

    // Funzione per validare la password (minimo 8 caratteri)
    function validaPassword($password) {
        return strlen($password) >= 8; // Verifica che la password abbia almeno 8 caratteri
    }

    // Funzione per validare tutti i campi
    function validaCampi($data) {
        $errors = []; // Array per raccogliere tutti i messaggi di errore

        // Controllo username
        if (empty($data['username'])) {
            $errors[] = "L'username è obbligatorio.";
        }

        // Controllo email
        if (!validaEmail($data['mail'])) {
            $errors[] = "L'indirizzo email non è valido.";
        }

        // Controllo CAP
        if (!validaCAP($data['CAP'])) {
            $errors[] = "Il CAP deve contenere 5 numeri.";
        }

        // Controllo password
        if (!validaPassword($data['password'])) {
            $errors[] = "La password deve essere lunga almeno 8 caratteri.";
        }

        // Controllo conferma password
        if ($data['password'] !== $data['confermaPassword']) {
            $errors[] = "Le password non coincidono.";
        }

        // Controllo nome
        if (!validaNomeCognome($data['nome'])) {
            $errors[] = "Il nome deve contenere solo lettere.";
        }

        // Controllo cognome
        if (!validaNomeCognome($data['cognome'])) {
            $errors[] = "Il cognome deve contenere solo lettere.";
        }

        // Controllo indirizzo
        if (empty($data['indirizzo'])) {
            $errors[] = "L'indirizzo è obbligatorio.";
        }

        // Controllo ruolo
        if (empty($data['role'])) {
            $errors[] = "Il ruolo è obbligatorio.";
        }

        return $errors; // Restituisce tutti gli errori raccolti
    }

    // Gestione della registrazione
    if (isset($_POST['username'], $_POST['password'], $_POST['confermaPassword'], $_POST['role'], $_POST['nome'], $_POST['cognome'], $_POST['mail'], $_POST['CAP'], $_POST['indirizzo'])) {
        // Inizializza tutte le variabili con i dati ricevuti dal form
        // Recupero dei dati dal form con verifica di isset
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confermaPassword = $_POST['confermaPassword'];
        $role = $_POST['role'];
        $nome =  $_POST['nome'];
        $cognome = $_POST['cognome'];
        $mail = $_POST['mail'];
        $CAP =  $_POST['CAP'];
        $indirizzo = $_POST['indirizzo'];

        // Preparazione dati per la validazione
        $data = [
            'username' => $username,
            'password' => $password,
            'confermaPassword' => $confermaPassword,
            'role' => $role,
            'nome' => $nome,
            'cognome' => $cognome,
            'mail' => $mail,
            'CAP' => $CAP,
            'indirizzo' => $indirizzo
        ];

        // Validazione dei campi
        $errors = validaCampi($data);

        if (!empty($errors)) { // Se ci sono errori, li mostra all'utente
            $error = implode('<br>', $errors);
        } else {
            // Carica gli utenti esistenti dal file
            $utenti = Utente::caricaUtenti($filePath);

            // Controlla se l'username esiste già
            $usernameEsistente = false;
            foreach ($utenti as $utente) {
                if ($utente->getUsername() === $username) {
                    $usernameEsistente = true;
                    break;
                }
            }

            if ($usernameEsistente) { // Se l'username esiste, mostra un errore
                $error = "Questo nome utente è già registrato.";
            } else {
                // Crea un nuovo utente e lo salva nel file
                $nuovoUtente = new Utente($username, $password, $role, $nome, $cognome, $mail, $CAP, $indirizzo);
                $nuovoUtente->salvaSuFile($filePath);
                $success = "Registrazione completata con successo! Ora puoi effettuare il login.";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione</title>
    <script src="JS/script.js"></script>
</head>
<body>
    <h2>Registrazione</h2>
    <?php 
        if ($error){
            echo "<p style='color: red;'>$error</p>";
        }

        if ($success){
            echo "<p style='color: green;'>$success</p>";
        }
    ?>
   <form method="POST" action="" onsubmit="return validaForm(event)">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Inserisci il tuo username" required>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Minimo 8 caratteri" required>
        <br>

        <label for="confermaPassword">Conferma Password:</label>
        <input type="password" id="confermaPassword" name="confermaPassword" placeholder="Conferma la password" required>
        <br>

        <label for="role">Ruolo:</label>
        <select id="role" name="role" required>
            <option value="">--Seleziona--</option>
            <option value="U">Utente</option>
            <option value="P">Pro</option>
        </select>
        <br>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" placeholder="Inserisci il tuo nome" required>
        <br>

        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" placeholder="Inserisci il tuo cognome" required>
        <br>

        <label for="mail">Email:</label>
        <input type="email" id="mail" name="mail" placeholder="Inserisci la tua email" required>
        <br>

        <label for="CAP">CAP:</label>
        <input type="text" id="CAP" name="CAP" placeholder="Il CAP deve contenere 5 numeri" maxlength="5" required>
        <br>

        <label for="indirizzo">Indirizzo:</label>
        <input type="text" id="indirizzo" name="indirizzo" placeholder="Inserisci il tuo indirizzo" required>
        <br>

        <button type="submit">Registrati</button>
    </form>
    <p>Hai già un account? <a href="login.php">Accedi qui</a></p>
</body>
</html>
