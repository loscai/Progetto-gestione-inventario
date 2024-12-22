<?php
    require_once("classes/Prodotto.php"); 
    session_start();

    // Verifica se l'utente è autenticato
    if (!isset($_SESSION['utente'])) {
        header('Location: login.php');
        exit();
    }

    // Funzione per caricare i prodotti dal file CSV
    $prodotti = Prodotto::caricaProdotti("prodotti/datas/prodottiNelMagazzino.csv");

    // Gestione della ricerca
    $searchTerm = '';
    if (isset($_POST['search'])) {
        $searchTerm = $_POST['search'];
        $prodotti = $prodottoIstanza->cercaProdotti($prodotti, $searchTerm);
    }

    // Ordinamento
    if (isset($_POST['sort'])) {
        $prodotti = $prodottoIstanza->ordinaProdotti($prodotti);
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
    <body>
        <h1>Prodotti disponibili</h1>

        <form method="post">
            <input type="text" name="search" placeholder="Cerca un prodotto" value="<?php echo $searchTerm; ?>">
            <button type="submit">Cerca</button>
            <button type="submit" name="sort">Ordina per nome</button>
        </form>

        <div>
            <?php 
            if (!empty($prodotti)) { 
                foreach ($prodotti as $prodotto) { 
            ?>
                    <div class="prodotto">
                        <img src="<?php echo $prodotto->getPathImmagine(); ?>" alt="<?php echo $prodotto->getNome(); ?>">
                        <h3><?php echo $prodotto->getNome(); ?></h3>
                        <p><?php echo $prodotto->getDescrizione(); ?></p>
                        <p>Quantità: <?php echo $prodotto->getPrezzo(); ?></p>
                        <form action="DettagliProdotto.php" method="get">
                            <input type="hidden" name="IDprodotto" value="<?php echo $prodotto->getIDProdotto(); ?>">
                            <button type="submit">Dettagli</button>
                        </form>
                    </div>
            <?php 
                } 
            } else { 
            ?>
                <p>Nessun prodotto trovato.</p>
            <?php 
            } 
            ?>
        </div>
    </body>
</html>
