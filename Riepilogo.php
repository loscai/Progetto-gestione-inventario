<?php
    require_once("classes/Prodotto.php");
    require_once("classes/Utente.php");

    session_start();

    // Carica utenti dal CSV
    $utenti = Utente::caricaUtenti("files/credenziali.csv");

    // Dati inviati tramite POST
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    // Trova l'utente corrispondente nel CSV
    $utenteTrovato = null;
    foreach ($utenti as $utente) {
        if ($utente->getUsername() === $username && $utente->getPassword() === $password) {
            $utenteTrovato = $utente;
            break;
        }
    }

    // Se l'utente non esiste, mostra un errore
    if (!$utenteTrovato) {
        echo "Errore: Utente non trovato o credenziali errate.";
        exit();
    }

    // Verifica se il carrello esiste
    if (isset($_SESSION['carrello'])) {
        $carrello = $_SESSION['carrello'];
    } else {
        $carrello = [];
    }

    // Calcola il totale e applica lo sconto PRO se necessario
    $totale = 0;
    $isPro = false;
    if ($utenteTrovato->getRole() === 'P') {
        $isPro = true; // Utente PRO
    }

    foreach ($carrello as $prodotto) {
        $prezzo = $prodotto['prezzo'] * $prodotto['quantita'];
        $totale += $prezzo;
    }

    if ($isPro) {
        $totale *= 0.5; // Sconto 50% per PRO
    }

    // Aggiorna il CSV dei prodotti e svuota il carrello
    if (!empty($carrello)) {
        $prodotti = Prodotto::caricaProdotti('prodotti/datas/prodotti.csv');
        foreach ($carrello as $prodottoCarrello) {
            foreach ($prodotti as $prodottoMagazzino) {
                if ($prodottoCarrello['IDprodotto'] === $prodottoMagazzino->getIDprodotto()) {
                    // Uso il getter per ottenere la quantità
                    $nuovaQuantita = $prodottoMagazzino->getQuantita() - $prodottoCarrello['quantita'];
                    
                    // Uso un setter per aggiornare la quantità (se disponibile)
                    $prodottoMagazzino->setQuantita(max(0, $nuovaQuantita));
                }
            }
        }

        // Riscrive il CSV aggiornato
        $csvContent = "";

        foreach ($prodotti as $prodotto) {
             $csvContent .= $prodotto->getIDprodotto() . ";";
             $csvContent .= $prodotto->getNome() . ";";
             $csvContent .= $prodotto->getDescrizione() . ";";
             $csvContent .= $prodotto->getFornitore() . ";";
             $csvContent .= $prodotto->getPrezzo() . ";";
             $csvContent .= $prodotto->getPathImmagine() . ";";
             $csvContent .= $prodotto->getTipo() . ";";
             $csvContent .= $prodotto->getQuantita() . "\r\n";
         }
 
        // Scrivi tutto il contenuto aggiornato nel file
        file_put_contents('prodotti/datas/prodotti.csv', $csvContent);

        // Svuota il carrello
        $_SESSION['carrello'] = [];
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riepilogo Ordine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }
        .riepilogo {
            border: 1px solid black;
            padding: 20px;
            margin-bottom: 20px;
        }
        .totale {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Riepilogo Ordine</h1>

    <div class="riepilogo">
        <h2>Dati Utente</h2>
        <p><strong>Username:</strong> <?php echo $utenteTrovato->getUsername(); ?></p>
        <p><strong>Ruolo:</strong> <?php echo $utenteTrovato->getRole(); ?></p>

    </div>

    <div class="riepilogo">
        <h2>Prodotti Ordinati</h2>
        <ul>
            <?php
            foreach ($carrello as $prodotto) {
                echo '<li>';
                echo '<strong>' . $prodotto['nome'] . '</strong> - ';
                echo $prodotto['Descrizione'] . '<br>';
                echo 'Quantità: ' . $prodotto['quantita'] . '<br>';
                echo 'Prezzo: €' . number_format($prodotto['prezzo'], 2);
                echo '</li>';
            }
            ?>
        </ul>
        <p class="totale">
            <?php 
            if ($isPro) {
                echo 'Totale (sconto PRO 50% applicato): €' . number_format($totale, 2);
            } else {
                echo 'Totale: €' . number_format($totale, 2);
            }
            ?>
        </p>
    </div>
    <a href="carrello.php">Torna al Carrello</a>
    <a href="HomePage.php">Torna alla Home</a>
</body>
</html>
