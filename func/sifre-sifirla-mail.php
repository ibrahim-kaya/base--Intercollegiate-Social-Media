<?php include_once('../func/includes.php');

if (!isset($_POST["sifre-sifirla-btn"])) {
    array_push($_SESSION['errors'], "Geçersiz istek! Tekrar dene istersen.");
    header("location: /sifremi-unuttum");
    return;
}

$stmt = mysqli_prepare($db, "SELECT * FROM users WHERE EMail=?;");
mysqli_stmt_bind_param($stmt, "s", $_POST["email"]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

if(!$row = mysqli_fetch_assoc($result))
{
    array_push($_SESSION['errors'], "Bu mail adresi sistemde kayıtlı değil!");
    header("location: /sifremi-unuttum");
    return;
}

$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);

$url = $_SERVER['HTTP_HOST']."/sifre-sifirla?selector=".$selector."&validator=".bin2hex($token);

$expires = date("U") + 1800;

$userEmail = htmlspecialchars($_POST["email"]);

$stmt = mysqli_prepare($db, "DELETE FROM sifre_sifirlama WHERE sfrSifirlaEmail=?;");
mysqli_stmt_bind_param($stmt, "s", $userEmail);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$hashedToken = password_hash($token, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($db, "INSERT INTO sifre_sifirlama (sfrSifirlaEmail, sfrSifirlaSelector, sfrSifirlaToken, sfrSifirlaSure) VALUES (?, ?, ?, ?);");
mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$postdata = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

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
    $mail->addAddress($userEmail);

    if ($_GET['func'] == 0) {

        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Şifre Sıfırla';
        $mail->Body = "<p>Duyduk ki şifreni unutmuşsun. İnsanlık hali olur öyle şeyler sıkma canını. Aşağıdaki linke tıklayarak şifreni sıfırlayabilirsin.</p> <a href='".$url."'>Haydi tıkla durma</a><p>Bu isteği yapan sen değilsen umursama.</p></p>";
    }
    $mail->send();

    array_push($_SESSION['msgs'], "Şifreni sıfırlaman için talimatları gönderdik! Mail kutuna bak.");
    header("location: /sifremi-unuttum");
} catch (Exception $e) {
    echo "Mail gönderilemedi. Mailer Error: {$mail->ErrorInfo}";

    array_push($_SESSION['errors'], "Hay aksi! Maili gönderemedik. Bazı sorunlar oluştu. İstersen daha sonra tekrar dene.");
    header("location: /sifremi-unuttum");
}