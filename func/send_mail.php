<?php
include_once('../func/config.php');

if(!isset($_GET['func']) || !isset($_SESSION['mail_adres']))
{
    echo '<script>window.location.href = "/";</script>';
    return;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = 'mail.xpdevil.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'base@xpdevil.com';                     // SMTP username
        $mail->Password = 'i.kaya1907';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('base@xpdevil.com', 'base.com');
        $mail->addAddress($_SESSION['mail_adres']);               // Name is optional

        if ($_GET['func'] == 0) {
            // Content
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Hoşgeldin, şeref verdin!';
            ob_start();
            include('../templates/hosgeldin_mail.php');
            $mail->Body = ob_get_contents();
            ob_end_clean();
        }
        else if ($_GET['func'] == 1) {
            // Content
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'base\'e Davetlisiniz!';
            ob_start();
            include('../templates/davetiye_mail.php');
            $mail->Body = ob_get_contents();
            ob_end_clean();
        }
        $mail->send();

        unset($_SESSION['mail_adres']);
        unset($_SESSION['mail_isim']);
        //echo 'Mail gönderildi!';
    } catch (Exception $e) {
        unset($_SESSION['mail_adres']);
        unset($_SESSION['mail_isim']);
        //echo "Mail gönderilemedi. Mailer Error: {$mail->ErrorInfo}";
    }


echo '<script>window.location.href = "/";</script>';