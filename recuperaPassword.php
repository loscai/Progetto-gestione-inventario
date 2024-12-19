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

echo $codice . "<br>";

//mi includo il PHPmailer
//require_once("C:\composer\vendor\autoload.php");


/*Classe per la gestione delle eccezioni e degli errori*/
require './mailer/PHPMailer.php';
/*Classe PHPMailer*/
require './mailer/Exception.php';
/*Classe SMTP, necessaria per stabilire la connessione con un server SMTP*/
require './mailer/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//creo l'oggetto PHPmailer

/*Quando si crea un oggetto PHPMailer, occorre passare il parametro "true" per attivare le eccezioni (messaggi in caso di errore)*/
try {
    // Tentativo di creazione di una nuova istanza della classe PHPMailer, nel caso in cui siano attivate delle eccezioni
    $PHPMailer = new PHPMailer(true);

    //AUTENTICAZIONE CON SMTP

    $PHPMailer->isSMTP();
    $PHPMailer->SMTPAuth = true;
    // Dati personali
    $PHPMailer->Host = "smtp.gmail.com";
    $PHPMailer->Port = 587;
    $PHPMailer->Username = "ecommercesiteforthebest@gmail.com";
    $PHPMailer->Password = "bkuq hsqy vbgg ndvr";
    //password della mail: Password123?
    $PHPMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    //Quarto passaggio: specificare il destinatario dell’e-mail

    // Mittente
    $PHPMailer->setFrom('ecommercesiteforthebest@gmail.com', 'E-Commerce Shop');
    // Destinatario, opzionalmente può essere specificato anche il nome
    $PHPMailer->addAddress($mail);
    // Copia
    $PHPMailer->addCC('ecommercesiteforthebest@gmail.com');
    // Copia nascosta
    $PHPMailer->addBCC('ecommercesiteforthebest@gmail.com', 'nome');

    //Quinto passaggio: aggiungere il contenuto del messaggio di posta

    $PHPMailer->isHTML(true);
    // Oggetto
    $PHPMailer->Subject = 'CODICE RECUPERO PASSWORD ACCOUNT PIXELMARKET';
    // Contenuto HTML
    $PHPMailer->Body = 'Salve, il suo codice da inserire per il recupero password è: [' . $codice . ']';
    //$PHPMailer->AltBody = 'Il testo come semplice elemento testuale';
    // Aggiungere un allegato
    //$PHPMailer->addAttachment("/home/user/Desktop/immagineesempio.png", "immagineesempio.png");


    //Sesto passaggio: utilizzare la corretta codifica dei caratteri
    $PHPMailer->CharSet = 'UTF-8';
    $PHPMailer->Encoding = 'base64';


    //Settimo passaggio: inviare l’e-mail
    $PHPMailer->send();


    //inserisco l'input del codice, per verificare che sia corretto

    echo "<form action='' method='POST'>";
    echo "<input type='number' maxlength='6' minlength='6' required><br>";
    echo "<button>INVIA</button>";
    echo "</form>";


} catch (Exception $e) {
    echo "Mailer Error: " . $e->getMessage();
}


?>