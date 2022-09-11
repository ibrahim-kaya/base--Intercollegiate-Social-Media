<!DOCTYPE html>
<html lang="tr">

<?php include_once('../func/includes.php');

/*if(!isset($_POST["sifre-sifirla-btn"]))
{
    array_push($_SESSION['errors'], "Geçersiz istek! Tekrar dene istersen.");
    header("location: /sifremi-unuttum");
    return;
}*/
?>

<head>
    <meta charset="UTF-8">
    <title>base ~ Şifre Sıfırla</title>

    <link rel="stylesheet" type="text/css" href="/css/login.css"/>
</head>
<body>

<?php  include('../func/headbar.php');	?>

<div id="content-wrap">

    <?php include('../func/sidebar.php'); ?>

    <?php
    $selector = htmlspecialchars($_GET["selector"]);
    $validator = htmlspecialchars($_GET["validator"]);

    if(empty($selector) || empty($validator))
    {
        array_push($_SESSION['errors'], "Bu link geçersiz! Tekrar denemeyi dene.");
        header("location: /sifremi-unuttum");
        return;
    }
    else
    {
        if(ctype_xdigit($selector) == false && ctype_xdigit($validator) == false)
        {
            array_push($_SESSION['errors'], "Bu link geçersiz! Tekrar denemeyi dene.");
            header("location: /sifremi-unuttum");
            return;
        }
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
    ?>


    <div class="bigdick" style="height: 80vh;">
        <div id="left-cont" class="lcont">

        </div>

        <div id="body-cont" class="bcont">
            <div id="form-field">
                <div style="display: flex; height: 50px; border-bottom: 1px solid #99D4D6;">
                    <div class="geri-tusu" style="width: 50px; text-align: center; line-height: 50px; font-size: 20pt; color: #FF707C; cursor: pointer; transition: all .4s;" onclick="window.location.href = '/sifremi-unuttum';"><i class="fas fa-arrow-left"></i></div>
                    <div style="line-height: 50px; font-family: 'Kalam'; font-size: 25px;"><span style="padding-left: 10px;">Şifre Sıfırla</span></div>
                </div>

                <form class="log-form" action="../func/sifre-sifirla.php" method="post">
                    <div style="margin: 30px; display: flex; flex-direction: column; align-items: center;">
                        <?php include('../func/errors.php'); ?>
                        <p style="color: #333;">Yeni şifreni aşağıdan belirleyebilirsin:</p>
                        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                        <div class="item-cont">
                            <div class="input-icon"><i style="height: 100%;" class="fas fa-lock"></i></div>
                            <input class="log-form input" type="password" name="sifre_1" placeholder="Yeni bir şifre gir...">
                        </div>

                        <div class="item-cont">
                            <div class="input-icon"><i style="height: 100%;" class="fas fa-lock"></i></div>
                            <input class="log-form input" type="password" name="sifre_2" placeholder="Aynı şifreyi tekrar gir...">
                        </div>

                        <button class="log-form submit-btn" type="submit" name="sifre-sifirla-btn">Şifreyi Sıfırla</button>
                    </div>
                </form>

            </div>
        </div>

        <div id="right-cont" class="rcont">

        </div>
    </div>
    <?php include('../func/footer.php'); ?>
</body>
</html>