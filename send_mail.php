<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include fișierele necesare pentru PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Verifică dacă formularul a fost trimis prin POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Preia datele din formular
    $nume = $_POST['nume'];
    $email = $_POST['email'];
    $subiect = $_POST['subiect'];
    $mesaj = $_POST['mesaj'];

    // Verifică dacă toate câmpurile sunt completate
    if (!empty($nume) && !empty($email) && !empty($subiect) && !empty($mesaj)) {
        $mail = new PHPMailer(true);

        try {

            // Configurare server SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '98734f8d467e6d';
            $mail->Password = '196c1042864b0f';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Setări email
            $mail->setFrom($email, $nume);
            $mail->addAddress('admin@mail.com');
            $mail->Subject = $subiect;
            $mail->Body = "Pe platforma de rezervari bilete online in transportul rutier ati primit un mesaj de la clientul:\nNume: $nume\nEmail: <$email>:\nMesaj:\n$mesaj";

            // Trimite emailul
            $mail->send();

            echo json_encode([
                "status" => "success",
                "message" => "Mesaj trimis cu succes!"
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => "Mesajul nu a putut fi trimis. Eroare: {$mail->ErrorInfo}"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Toate câmpurile sunt obligatorii."
        ]);
    }
}
?>