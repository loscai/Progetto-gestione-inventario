<?php
if(!isset($_SESSION))
    session_start();

if (count($_POST) != 0) {
    if ($_POST["conferma"] == "si") {
        header("location:gestoreLogout.php");
        exit;
    } else if ($_POST["conferma"] == "no") {
        header("Location: ./pagineUtenti/" . $_SESSION["username"] .".php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGOUT</title>
</head>

<body>
    <form action="" method="post">
        <h3>Confermi di voler uscire dall'account?</h3>
        <input type="radio" name="conferma" value="si"> SI <br>
        <input type="radio" name="conferma" value="no"> NO <br>
        <button>CONFERMA</button>
    </form>
</body>

</html>