<?php
if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION['carrello']) || empty($_SESSION['carrello'])) {
    echo "Il carrello è vuoto.";
    exit();
}
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
        </tr>

        <?php
        $totaleCarrello = 0;
        foreach ($_SESSION['carrello'] as $item) {
            $totaleProdotto = $item['prezzo'] * $item['quantita'];
            $totaleCarrello += $totaleProdotto;
            echo "<tr>
                        <td>" . $item['nome'] . "</td>
                        <td>" . $item['quantita'] . "</td>
                        <td>" . $item['prezzo'] . "</td>
                        <td>" . $totaleProdotto . "</td>
                    </tr>";
        }
        ?>

        <tr>
            <td colspan="3"><strong>Totale Carrello:</strong></td>
            <td><strong><?php echo $totaleCarrello; ?> €</strong></td>
        </tr>
    </table>

    <a href="HomePage.php">Torna alla Home Page</a>
</body>

</html>