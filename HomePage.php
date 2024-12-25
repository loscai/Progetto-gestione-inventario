<?php
    require_once("classes/Prodotto.php");

    if (!isset($_SESSION))      
        session_start();

    // Verifica se l'utente è autenticato
    if (!isset($_SESSION['autenticato'])) {
        header('Location: login.php');
        exit();
    }

    // Recupero del nome utente dalla sessione
    $username = $_SESSION['username'];


    // Funzione per caricare i prodotti dal file CSV
    $prodotti = Prodotto::caricaProdotti( "../prodotti/datas/prodotti.csv");

    // Gestione della ricerca
    $searchTerm = '';
    if (isset($_POST['search'])) {  
        $searchTerm = $_POST['search'];
        $prodotti = Prodotto::cercaProdotti($prodotti, $searchTerm);
    }

    // Ordinamento
    if (isset($_POST['sort'])) {
        $prodotti = Prodotto::ordinaProdotti($prodotti);
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
    <h1>Benvenuto, <?php echo $username; ?>!</h1>

    <h2>Prodotti disponibili</h2>

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
                <div style="max-width: 20%;">
                    <img src="<?php echo $prodotto->getPathImmagine(); ?>" alt="<?php echo $prodotto->getNome(); ?>" 
                    style="max-width: 50%; max-height: 50%;">
                    <h3><?php echo $prodotto->getNome(); ?></h3>
                    <p><?php echo $prodotto->getDescrizione(); ?></p>
                    <p>Prezzo: <?php echo $prodotto->getPrezzo(); ?></p>
                    <p>Quantità: <?php echo $prodotto->getQuantita(); ?></p>
                    <form action="DettagliProdotto.php" method="GET">
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