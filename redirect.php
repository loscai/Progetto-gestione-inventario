<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION["autenticato"])){
    header("location: login.php?messaggio=Non hai i permessi per accedere a questa pagina");
    exit;
}

//faccio i controlli sui dati inseriti

//prendo il file con tutte le credenziali
$contenutoFileCredenziali = file_get_contents("./files/credenziali.csv");

//lo divido in righe
$righeFileCredenziali = explode("\r\n",$contenutoFileCredenziali);

foreach ($righeFileCredenziali as $riga) {
    //suddivido la riga nei campi che la compongono
    $campi = explode(";",$riga);
    //mi serve solo il secondo campo (ruolo)
    //controllo le corrispondenze
    if($_SESSION["autenticato"] == $campi[2] ){
        //i ruoli corrispondono, quindi mi muovo nella pagina dedicata
        if($campi[2] == "A"){
            header("location: paginaAdmin.php");
            exit;
        }
        else if($campi[2] == "U"){
            $path = "./pagineUtenti/".$campi[0].".php";
            if(!file_exists($path)){
                fopen($path,"w");
                file_put_contents($path,"require_once('./utilities/basePaginaUtente.php');");
                header("location: ".$path);
            }
        }
    }
}

//se non entro mai nel controllo finisco qui, e no, non è un bene
header("location: login.php?messaggio=Credenziali errate");
exit;


?>