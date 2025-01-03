<?php
    require_once("classes/Utente.php"); 

    session_start();

    // Percorso del file credenziali.csv
    $filePath = "files/credenziali.csv";

    // Caricamento degli utenti dal file CSV
    $utenti = Utente::caricaUtenti($filePath);
    
    $utenteCorrente = null;
    foreach ($utenti as $utente) {
        if ($utente->getUsername() === $_SESSION['username'] && $utente->getPassword() === $_SESSION['password']) {
            $utenteCorrente = $utente;
            break;
        }
    }

    if ($utenteCorrente === null) {
        echo "Utente non trovato.";
        exit();
    }

    // Funzione per calcolare la cifra di controllo usando il metodo di Luhn
    function calcolaCifraDiControlloLuhn($stringaNumerica)
    {
        $somma = 0;

        if (strlen($stringaNumerica) % 2 !== 0) {
            $stringaNumerica = '0' . $stringaNumerica;
        }

        for ($i = 1; $i <= strlen($stringaNumerica); $i++) {
            $cifraCorrente = intval(substr($stringaNumerica, $i - 1, 1));
            $daSommare = 0;

            if ($i % 2 === 0) {
                $cifraRaddoppiata = $cifraCorrente * 2;
                if ($cifraRaddoppiata >= 10) {
                    $daSommare = 1 + ($cifraRaddoppiata % 10);
                } else {
                    $daSommare = $cifraRaddoppiata;
                }
            } else {
                $daSommare = $cifraCorrente;
            }

            $somma += $daSommare;
        }

        if ($somma % 10 === 0) {
            return 0;
        } else {
            return 10 - ($somma % 10);
        }
    }

    // Gestione dell'invio del modulo di pagamento
    if (isset($_POST['paga'])) {
        $numeroCarta = $_POST['numero_carta'];
        $cvv = $_POST['cvv'];
        $scadenza = $_POST['scadenza'];

        // Validazione lato server
        $errori = [];

        if (empty($numeroCarta) || !preg_match('/^\d+$/', $numeroCarta) || strlen($numeroCarta) !== 16) {
            $errori[] = "Il numero di carta deve contenere esattamente 16 cifre.";
        } elseif (calcolaCifraDiControlloLuhn($numeroCarta) !== 0) {
            $errori[] = "Il numero di carta non è valido.";
        }

        if (empty($cvv) || !preg_match('/^\d+$/', $cvv) || strlen($cvv) !== 3) {
            $errori[] = "Il CVV deve contenere esattamente 3 cifre.";
        }

        if (empty($scadenza) || !preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $scadenza)) {
            $errori[] = "La data di scadenza deve essere nel formato MM/YY.";
        }

        if (empty($errori)) {
            echo "Pagamento effettuato con successo!";
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <script src="JS/pagamento.js"></script>
</head>
<body>

    <h1>Pagamento</h1>
    <?php
        if (!empty($errori)) {
            echo '<ul style="color: red;">';
            foreach ($errori as $errore) {
                echo "<li>$errore</li>";
            }
            echo '</ul>';
        }
    ?>
    <form method="post" action="" onsubmit="return validaForm()">
        <fieldset>
            <legend>Dati Utente</legend>
            <p><strong>Nome:</strong> <?php echo $utenteCorrente->getNome(); ?></p>
            <p><strong>Cognome:</strong> <?php echo $utenteCorrente->getCognome(); ?></p>
            <p><strong>Indirizzo:</strong> <?php echo $utenteCorrente->getIndirizzo(); ?></p>
            <p><strong>Mail:</strong> <?php echo $utenteCorrente->getMail(); ?></p>
            <p><strong>CAP:</strong> <?php echo $utenteCorrente->getCAP(); ?></p>
        </fieldset>

        <fieldset>
            <legend>Dati Carta</legend>
            <label for="numero_carta">Numero Carta:</label>
            <input type="text" id="numero_carta" name="numero_carta" maxlength="16" required><br>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" required><br>

            <label for="scadenza">Scadenza (MM/YY):</label>
            <input type="text" id="scadenza" name="scadenza" maxlength="5" required><br>
        </fieldset>

        <button type="submit" name="paga">Paga</button>
    </form>
</body>
</html>
