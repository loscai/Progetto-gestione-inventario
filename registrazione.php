<?php
    require_once("classes/Utente.php");
    session_start();

    $filePath = "files/credenziali.csv";
    $error = '';
    $success = '';

    // Gestione della registrazione
    if (isset($_POST['username'], $_POST['password'], $_POST['role'], $_POST['nome'], $_POST['cognome'], $_POST['mail'], $_POST['CAP'], $_POST['indirizzo'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $mail = $_POST['mail'];
        $CAP = $_POST['CAP'];
        $indirizzo = $_POST['indirizzo'];

        
        // Carica gli utenti esistenti
        $utenti = Utente::caricaUtenti($filePath);

        // Controlla se l'username esiste già
        $usernameEsistente = false;
        foreach ($utenti as $utente) {
             if ($utente->getUsername() === $username) {
                $usernameEsistente = true;
                break;
            }
        }

        if ($usernameEsistente) {
                $error = "Questo nome utente è già registrato.";
        } else {
                // Crea un nuovo utente e aggiungilo al file
                $nuovoUtente = new Utente($username, $password, $role, $nome, $cognome, $mail, $CAP, $indirizzo);
                $nuovoUtente->salvaSuFile($filePath);
                $success = "Registrazione completata con successo! Ora puoi effettuare il login.";
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
        <input type="text" id="username" name="username" required>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <label for="role">Ruolo:</label>
        <select id="role" name="role" required>
            <option value="U">Utente</option>
            <option value="P">Pro</option>
        </select>
        <br>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br>

        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" required>
        <br>

        <label for="mail">Email:</label>
        <input type="email" id="mail" name="mail" required>
        <br>

        <label for="CAP">CAP:</label>
        <input type="text" id="CAP" name="CAP" placeholder="Il CAP deve contenere 5 numeri" maxlength="5" required>
        <br>

        <label for="indirizzo">Indirizzo:</label>
        <input type="text" id="indirizzo" name="indirizzo" required>
        <br>

        <button type="submit">Registrati</button>
    </form>
    <p>Hai già un account? <a href="login.php">Accedi qui</a></p>
</body>
</html>
