<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION["autenticato"])){
    header("location: login.php?messaggio=Non hai i permessi per accedere a questa pagina");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>