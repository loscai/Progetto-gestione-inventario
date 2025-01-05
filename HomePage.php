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
    $prodotti = Prodotto::caricaProdotti("../prodotti/datas/prodotti.csv");

    // Gestione della ricerca
    $searchTerm = '';
    if (isset($_POST['search'])) {
        $searchTerm = $_POST['search'];
        $prodotti = Prodotto::cercaProdotti($prodotti, $searchTerm);
    }

    // Gestione del filtro per tipo di prodotto
    $tipoSelezionato = '';
    if (isset($_POST['filtra'])) {
        $tipoSelezionato = $_POST['tipo'];
        $prodottiFiltrati = [];  // Array per i prodotti filtrati

        foreach ($prodotti as $prodotto) {
            // Verifica se il tipo del prodotto corrisponde al tipo selezionato
            if ($prodotto->getTipo() === $tipoSelezionato) {
                $prodottiFiltrati[] = $prodotto;  // Aggiungi il prodotto filtrato all'array
            }
        }

        $prodotti = $prodottiFiltrati;  // Aggiorna l'array di prodotti con quelli filtrati
    }

    // Ordinamento
    if (isset($_POST['sort'])) {
        $prodotti = Prodotto::ordinaProdotti($prodotti);
    }

    // Recupera i tipi unici di prodotto
    $tipiProdotto = Prodotto::ottieniTipiUnici($prodotti);
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

    <!-- Form per ricerca -->
    <form method="POST">
        <input type="text" name="search" placeholder="Cerca un prodotto" value="<?php echo $searchTerm; ?>">
        <button type="submit">Cerca</button>
        <button type="submit" name="sort">Ordina per nome</button>
    </form>

    <!-- Form per filtro per tipo di prodotto -->
    <form method="POST">
        <select name="tipo">
            <option value="">Seleziona tipo</option>
            <?php
            foreach ($tipiProdotto as $tipo) {
                if ($tipo == $tipoSelezionato) {
                    echo "<option value='$tipo' selected>$tipo</option>";
                } else {
                    echo "<option value='$tipo'>$tipo</option>";
                }
            }
            ?>
        </select>
        <button type="submit" name="filtra">Filtra</button>
    </form>

    <!-- Form per andare al carrello -->
    <form action="carrello.php" method="GET">
        <button type="submit">Vai al Carrello</button>
    </form>

    <div>
        <?php
        if (!empty($prodotti)) {
            foreach ($prodotti as $prodotto) {
                if ($prodotto->getIDProdotto() != 0) {
                    ?>
                    <div style="max-width: 20%;">
                        <img src="<?php echo $prodotto->getPathImmagine(); ?>" alt="<?php echo $prodotto->getNome(); ?>"
                            style="max-width: 50%; max-height: 50%;">
                        <h3><?php echo $prodotto->getNome(); ?></h3>
                        <p><?php echo $prodotto->getDescrizione(); ?></p>
                        <p>Prezzo: <?php echo $prodotto->getPrezzo(); ?></p>
                        <p>Quantità: <?php echo $prodotto->getQuantita(); ?></p>
                        <form action="../DettagliProdotto.php" method="GET">
                            <input type="hidden" name="IDprodotto" value="<?php echo $prodotto->getIDProdotto(); ?>">
                            <button type="submit">Dettagli</button>
                        </form>
                    </div>
                    <?php
                }
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