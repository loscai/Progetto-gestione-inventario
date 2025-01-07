<?php

if (!isset($_SESSION))
    session_start();

if (isset($_POST["password"]) && isset($_POST["conferma"])) {

    if (hash_equals($_POST["password"], $_POST["conferma"])) {
        //effettuo la modifica della password
        $credenzialiDiTutti = file_get_contents("./files/credenziali.csv");

        $righe = explode("\r\n", $credenzialiDiTutti);

        foreach ($righe as $riga) {
            $campi = explode(";", $riga);

            if (hash_equals($_SESSION["mail"], $campi[5])) {
                $campi[1] = $_POST["password"];
                $nuovaRiga = $campi[0] . ";" . $campi[1] . ";" . $campi[2] . ";" . $campi[3] . ";" . $campi[4] . ";" . $campi[5] . ";" . $campi[6] . ";" . $campi[7];
                $credenzialiAggiornate[] = $nuovaRiga;
            } else {
                $credenzialiAggiornate[] = $riga;
            }

        }

        // Elimina il vecchio file
        $filePath = "./files/credenziali.csv";
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Crea un nuovo file e scrive le credenziali aggiornate
        $nuovoContenuto = implode("\r\n", $credenzialiAggiornate);
        file_put_contents($filePath, $nuovoContenuto);
        
        header("location: login.php?messaggio=Password aggiornata con successo! ");
    }else{
        echo "Le password non corrispondono!";
        unset($_POST["password"]);
        unset($_POST["conferma"]);
    }
}

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        Inserisci la password <input type="password" name="password" required><br><br>
        Conferma la password <input type="password" name="conferma" required><br><br>
        <button>INVIA</button>
    </form>
</body>

</html>