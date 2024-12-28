<?php
require_once("classes/Prodotto.php");

if (!isset($_SESSION))
    session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['autenticato'])) {
    header('Location: login.php');
    exit();
}

// Recupero dell'ID prodotto passato tramite GET
if (!isset($_GET['IDprodotto'])) {
    echo "ID prodotto non fornito.";
    exit();
}

$IDprodotto = $_GET['IDprodotto'];

// Carica tutti i prodotti dal file CSV
$prodotti = Prodotto::caricaProdotti("prodotti/datas/prodotti.csv");

// Cerca il prodotto corrispondente all'ID fornito
$prodottoSelezionato = null;
foreach ($prodotti as $prodotto) {
    if ($prodotto->getIDprodotto() == $IDprodotto) {
        $prodottoSelezionato = $prodotto;
        break;
    }
}

if ($prodottoSelezionato === null) {
    echo "Prodotto non trovato.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettagli Prodotto</title>
</head>
<body>
    <h1>Dettagli Prodotto</h1>

    <div style="max-width: 50%;">
        <img src="<?php echo $prodottoSelezionato->getPathImmagine(); ?>" alt="<?php echo $prodottoSelezionato->getNome(); ?>" 
        style="max-width: 100%; max-height: 100%;">
        <h2><?php echo $prodottoSelezionato->getNome(); ?></h2>
        <p><strong>Descrizione:</strong> <?php echo $prodottoSelezionato->getDescrizione(); ?></p>
        <p><strong>Quantità disponibile:</strong> <?php echo $prodottoSelezionato->getQuantita(); ?></p>
        <p><strong>Fornitore:</strong> <?php echo $prodottoSelezionato->getFornitore(); ?></p>
        <p><strong>Tipologia:</strong> <?php echo $prodottoSelezionato->getTipo(); ?></p>

        <form action="aggiungiCarrello.php" method="POST">
            <label for="quantita">Quantità:</label>
            <select name="quantita" id="quantita">
                <?php
                // Genera opzioni del menu a tendina in base alla quantità disponibile
                for ($i = 1; $i <= $prodottoSelezionato->getQuantita(); $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <input type="hidden" name="IDprodotto" value="<?php echo $prodottoSelezionato->getIDprodotto(); ?>">
            <button type="submit">Aggiungi al Carrello</button>
        </form>
    </div>

    <a href="HomePage.php">Torna alla Home Page</a>
</body>
</html>