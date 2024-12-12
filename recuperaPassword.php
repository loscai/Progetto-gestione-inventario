<?php

$mail = "";
if (isset($_POST["mail"])) {
    $mail = $_POST["mail"];
}
echo $mail . "<br>";
$codice = "";
for ($i = 0; $i < 6; $i++) {
    $numeretto = random_int(0, 9);
    $codice = $codice . $numeretto;
}

echo $codice;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recuperaPassword</title>
</head>

<body>
    <form action="" method="POST">
        e-mail per effettuare il recupero della password: <input type="email" name="mail" required><br>
        <button>INVIA</button>

    </form>
</body>

</html>