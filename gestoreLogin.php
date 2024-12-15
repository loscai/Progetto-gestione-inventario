<?php

if (!isset($_SESSION))
    session_start();


if (!isset($_GET["username"]) || !isset($_GET["password"])) {
    header("location: login.php?messaggio=Username o Password non inseriti");
    exit;
}

//se passa li salvo
$username = $_GET["username"];
$password = $_GET["password"];

//faccio i controlli sui dati inseriti

//prendo il file con tutte le credenziali
$contenutoFileCredenziali = file_get_contents("./files/credenziali.csv");


//lo divido in righe
$righeFileCredenziali = explode("\r\n", $contenutoFileCredenziali);

print_r($righeFileCredenziali);

foreach ($righeFileCredenziali as $riga) {
    //suddivido la riga nei campi che la compongono
    $campi = explode(";", $riga);
    //mi servono solo i primi due campi (username e password)
    //controllo le corrispondenze
    if ($username == $campi[0] && $password == $campi[1]) {
        echo $username . " - " .$password;
        //se le credenziali corrispondono
        $_SESSION["ruolo"] = $campi[2];
        header("location: redirect.php?username=" . $campi[0]);
        exit;
    }
}

//se non entro mai nel controllo finisco qui, e no, non è un bene
//header("location: login.php?messaggio=Credenziali errate");
//exit;

?>