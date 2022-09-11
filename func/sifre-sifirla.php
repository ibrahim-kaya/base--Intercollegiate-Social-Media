<?php include_once('../func/includes.php');

if(!isset($_POST["sifre-sifirla-btn"]))
{
    array_push($_SESSION['errors'], "Geçersiz istek! Tekrar dene istersen.");
    header("location: /sifremi-unuttum");
    return;
}

$selector = htmlspecialchars($_POST["selector"]);
$validator = htmlspecialchars($_POST["validator"]);
$sifre1 = htmlspecialchars($_POST["sifre_1"]);
$sifre2 = htmlspecialchars($_POST["sifre_2"]);

$url = "sifre-sifirla?selector=".$selector."&validator=".$validator;

if(empty($sifre1) || empty($sifre2))
{
    array_push($_SESSION['errors'], "Bir şifre girmelisin!");
    header("location: /".$url);
    return;
}
else if($sifre1 != $sifre2)
{
    array_push($_SESSION['errors'], "Şifreler uyuşmuyor! Tekrar dene.");
    header("location: /".$url);
    return;
}
else if(strlen($sifre1) < 4)
{
    array_push($_SESSION['errors'], "Şifre 4 karakterden kısa olamaz!");
    header("location: /".$url);
    return;
}

$currentDate = date("U");

$stmt = mysqli_prepare($db, "SELECT * FROM sifre_sifirlama WHERE sfrSifirlaSelector=? AND sfrSifirlaSure >= ?;");
mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

if(!$row = mysqli_fetch_assoc($result))
{
    array_push($_SESSION['errors'], "Link geçersiz veya süresi dolmuş! Tekrar deneyebilirsin.");
    header("location: /sifremi-unuttum");
    return;
}
else
{
    $tokenBin = hex2bin($validator);
    $tokenCheck = password_verify($tokenBin, $row["sfrSifirlaToken"]);

    if ($tokenCheck === true)
    {

        $tokenEmail = $row['sfrSifirlaEmail'];

        $stmt = mysqli_prepare($db, "SELECT * FROM users WHERE EMail=?;");
        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if(!$row = mysqli_fetch_assoc($result))
        {
            array_push($_SESSION['errors'], "Bir hata oluştu. Tekrar deneyebilirsin.");
            header("location: /sifremi-unuttum");
            return;
        }
        else
        {
            $yeniSifre = md5($sifre1);

            $stmt = mysqli_prepare($db, "UPDATE users SET Password=? WHERE EMail=?;");
            mysqli_stmt_bind_param($stmt, "ss", $yeniSifre, $tokenEmail);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $stmt = mysqli_prepare($db, "DELETE FROM sifre_sifirlama WHERE sfrSifirlaEmail=?;");
            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            array_push($_SESSION['msgs'], "Şifreni başarıyla sıfırladın! Şimdi giriş yapabilirsin.");
            header("location: /turnike");
        }
    }
    else
    {
        array_push($_SESSION['errors'], "Link geçersiz veya süresi dolmuş! Tekrar deneyebilirsin.");
        header("location: /sifremi-unuttum");
        return;
    }
}