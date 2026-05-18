<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/../vendor/autoload.php";

function sendMail($to, $subject, $htmlBody)
{
    $mail = new PHPMailer(true);

    try {

        // SMTP CONFIG
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // ⚠️ A REMPLACER
        $mail->Username = 'your_email@gmail.com';
        $mail->Password = 'your_app_password';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // FROM
        $mail->setFrom('your_email@gmail.com', 'FreshMilk');

        // TO
        $mail->addAddress($to);

        // CONTENT
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;

        $mail->send();

        return true;

    } catch (Exception $e) {

        error_log("Mail error: " . $mail->ErrorInfo);

        return false;
    }
}