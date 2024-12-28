<?php
    require_once("classes/Prodotto.php");
    session_start();

    // Verifica se l'utente ha selezionato una quantità e l'ID del prodotto
    if (isset($_POST['IDprodotto']) && isset($_POST['quantita'])) {
        $IDprodotto = $_POST['IDprodotto'];
        $quantita = $_POST['quantita'];

        // Carica i prodotti dal file CSV
        $prodotti = Prodotto::caricaProdotti("prodotti/datas/prodotti.csv");

        // Cerca il prodotto selezionato
        $prodottoSelezionato = null;
        foreach ($prodotti as $prodotto) {
            if ($prodotto->getIDprodotto() == $IDprodotto) {
                $prodottoSelezionato = $prodotto;
                break;
            }
        }

        if ($prodottoSelezionato !== null) {
            // Aggiunge il prodotto al carrello
            if (!isset($_SESSION['carrello'])) {
                $_SESSION['carrello'] = [];
            }

            // Verifica se il prodotto è già presente nel carrello
            $prodottoTrovato = false;
            foreach ($_SESSION['carrello'] as $index => $item) {
                if ($item['IDprodotto'] == $IDprodotto) {
                    $_SESSION['carrello'][$index]['quantita'] += $quantita; // Aggiunge quantità se già presente
                    $prodottoTrovato = true;
                    break;
                }
            }

            if (!$prodottoTrovato) {
                $_SESSION['carrello'][] = [
                    'IDprodotto' => $IDprodotto,
                    'quantita' => $quantita,
                    'nome' => $prodottoSelezionato->getNome(),
                    'prezzo' => $prodottoSelezionato->getPrezzo(),
                ];
            }

            // Redirige alla pagina del carrello
            header("Location: carrello.php");
            exit();
        } else {
            echo "Prodotto non trovato.";
        }
    } else {
        echo "Dati mancanti.";
    }
?>