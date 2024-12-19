<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>

<body>

    <?php
    if (isset($_SESSION))
        session_destroy();

    if (isset($_GET["messaggio"]))
        echo $_GET["messaggio"];
    ?>

    <form action="gestoreLogin.php" method="POST">

        <h4>Username: </h4> <input type="text" name="username" value="utente" required>
        <br>
        <h4>Password: </h4> <input type="password" name="password" value="password" required>
        <br>

        <input type="submit" value="INVIA">
        <button onclick="window.location.href='recuperaPassword.php';">RECUPERA PASSWORD</button>

    </form>
</body>

</html>