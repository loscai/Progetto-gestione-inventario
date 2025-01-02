<?php
require_once("./classes/Prodotto.php");

if (!isset($_SESSION))
    session_start();

if (!isset($_SESSION["autenticato"]) || $_SESSION["autenticato"] != "A") {
    header("Location: index.php?messaggio=Non hai i permessi per accedere a questa pagina");
    exit;
}

//mi assicuro che ci sia tutto
if (count($_POST) == 5 && count($_FILES) == 1) {
    //aggiungo il prodotto al CSV   
    //prendo il contenuto del file prodotti
    $contenuto = file_get_contents("./prodotti/datas/prodotti.csv");

    //lo splitto in righe
    $righe = explode("\r\n", $contenuto);

    foreach ($righe as $riga) {
        //lavoro sui singoli campi
        $idAttuale = 0;
        $campi = explode(";", $riga);
        $id = (int) $campi[0];
        $idAttuale += $id;
    }

    //devo processare l'immagine e ricavarne il path

    $temp = $_FILES["immagine"]["tmp_name"];
    $nuovoNome = "./prodotti/images/" . $_FILES["immagine"]["name"];

    move_uploaded_file($temp, $nuovoNome);

    $newIDProdotto = $idAttuale + 1;
    $nomeProdotto = $_POST["Nome"];
    $descrizioneProdotto = $_POST["Descrizione"];
    $fornitoreProdotto = $_POST["Fornitore"];
    $prezzoProdotto = $_POST["Prezzo"];
    $tipologiaProdotto = $_POST["Tipologia"];

    $newProdotto = new Prodotto(
        $newIDProdotto,
        $nomeProdotto,
        $descrizioneProdotto,
        $fornitoreProdotto,
        $prezzoProdotto,
        "." . $nuovoNome,
        $tipologiaProdotto
    );

    print_r($_SESSION);

    

    $newProdotto->salvaSuFile("./prodotti/datas/prodotti.csv");

    header("location: ./pagineUtenti/".$_SESSION["username"].".php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi prodotto nuovo</title>
</head>

<body>

    <form method="POST" enctype="multipart/form-data">

        Immagine prodotto: <input type="file" name="immagine" required>
        <br><br>

        Nome prodottto: <input type="text" name="Nome" required>
        <br><br>

        Descrizione prodotto: <br><textarea name="Descrizione"
            style="max-height: 250px; max-width: 400px; min-height: 250px; min-width: 400px;" required></textarea>
        <br><br>

        Fornitore: <input type="text" name="Fornitore" required>
        <br><br>

        Prezzo: <input type="number" step="0.01" name="Prezzo" required>
        <br><br>
        Tipologia prodotto: <input type="text" name="Tipologia" required>
        <br><br>
        <button>CREA</button>

    </form>

</body>

</html>