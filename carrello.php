<?php
if (!isset($_SESSION))
    session_start();

<<<<<<< HEAD
if (!isset($_SESSION['carrello']) || empty($_SESSION['carrello'])) {
    echo "Il carrello è vuoto.";
    exit();
}
=======
    if (!isset($_SESSION['homePageLink'])) {
        $_SESSION['homePageLink'] = "HomePage.php";
    }

    // Gestione del pulsante "Pulisci Carrello"
    if (isset($_POST['pulisci'])) {
        unset($_SESSION['carrello']); // Svuota solo il carrello
        header("Location: carrello.php"); // Ricarica la pagina
        exit();
    }

    // Gestione della cancellazione della quantità di un singolo prodotto
    if (isset($_POST['elimina'])) {
        $indexToDelete = $_POST['index'];
        $quantitaToDelete = $_POST['quantita']; // Quantità da eliminare

        // Verifica che la quantità da eliminare non sia maggiore di quella presente
        if ($quantitaToDelete > $_SESSION['carrello'][$indexToDelete]['quantita']) {
            echo "La quantità da eliminare non può essere maggiore di quella presente nel carrello.";
            exit();
        }

        // Sottrarre la quantità dal carrello
        $_SESSION['carrello'][$indexToDelete]['quantita'] -= $quantitaToDelete;

        // Se la quantità diventa 0, rimuovi completamente l'elemento dal carrello
        if ($_SESSION['carrello'][$indexToDelete]['quantita'] == 0) {
            unset($_SESSION['carrello'][$indexToDelete]);
        }

        // Riorganizza gli indici dell'array
        $_SESSION['carrello'] = array_values($_SESSION['carrello']);
        
        header("Location: carrello.php"); // Ricarica la pagina
        exit();
    }

    // Debug: Controllo del contenuto del carrello
    echo "<pre>";
    print_r($_SESSION['carrello']);
    echo "</pre>";

    if (!isset($_SESSION['carrello']) || count($_SESSION['carrello']) === 0) {
        echo "Il carrello è vuoto.";
        echo "<br><a href='" . $_SESSION['homePageLink'] . "'>Torna alla Home Page</a>";
        exit();
    }
>>>>>>> 9d20830df3c63a360e3cec3404437498efe79a34
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
</head>

<body>
    <h1>Carrello</h1>

    <table>
        <tr>
            <th>Prodotto</th>
            <th>Quantità</th>
            <th>Prezzo</th>
            <th>Totale</th>
            <th>Azioni</th>
        </tr>

        <?php
        $totaleCarrello = 0;
<<<<<<< HEAD
        foreach ($_SESSION['carrello'] as $item) {
            $totaleProdotto = $item['prezzo'] * $item['quantita'];
            $totaleCarrello += $totaleProdotto;
            echo "<tr>
                        <td>" . $item['nome'] . "</td>
                        <td>" . $item['quantita'] . "</td>
                        <td>" . $item['prezzo'] . "</td>
                        <td>" . $totaleProdotto . "</td>
                    </tr>";
=======
        foreach ($_SESSION['carrello'] as $index => $item) {
            $totaleProdotto = $item['prezzo'] * $item['quantita'];
            $totaleCarrello += $totaleProdotto;
            echo "<tr>
                    <td>" . $item['nome'] . "</td>
                    <td>" . intval($item['quantita']) . "</td>
                    <td>" . $item['prezzo'] . " €</td>
                    <td>" . $totaleProdotto . " €</td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='index' value='$index'>
                            <select name='quantita'>"; // Menu a tendina per la quantità
                            
            // Popola il menu a tendina con le quantità disponibili
            for ($i = 1; $i <= $item['quantita']; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            
            echo "</select>
                            <button type='submit' name='elimina'>Cancella</button>
                        </form>
                    </td>
                </tr>";
>>>>>>> 9d20830df3c63a360e3cec3404437498efe79a34
        }
        ?>

        <tr>
            <td colspan="3"><strong>Totale Carrello:</strong></td>
            <td><strong><?php echo $totaleCarrello; ?> €</strong></td>
        </tr>
    </table>

    <form method="post" action="">
        <button type="submit" name="pulisci">Pulisci Carrello</button>
    </form>
    
    <a href="<?php echo $_SESSION['homePageLink']; ?>">Torna alla Home Page</a>
</body>
<<<<<<< HEAD

</html>
=======
</html>
>>>>>>> 9d20830df3c63a360e3cec3404437498efe79a34
