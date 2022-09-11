<!DOCTYPE html>
<html lang="en">

<?php include_once('../func/includes.php'); ?>

<head>
    <meta charset="UTF-8">
    <title>base ~ Şifre Sıfırla</title>

    <link rel="stylesheet" type="text/css" href="/css/login.css"/>
</head>
<body>

<?php  include('../func/headbar.php');	?>

<div id="content-wrap">

    <?php include('../func/sidebar.php'); ?>


    <div class="bigdick" style="height: 80vh;">
        <div id="left-cont" class="lcont">

        </div>

        <div id="body-cont" class="bcont">
            <div id="form-field">
                <div style="display: flex; height: 50px; border-bottom: 1px solid #99D4D6;">
                    <div class="geri-tusu" style="width: 50px; text-align: center; line-height: 50px; font-size: 20pt; color: #FF707C; cursor: pointer; transition: all .4s;" onclick="window.location.href = '/turnike';"><i class="fas fa-arrow-left"></i></div>
                    <div style="line-height: 50px; font-family: 'Kalam'; font-size: 25px;"><span style="padding-left: 10px;">Şifre Sıfırla</span></div>
                </div>

                <form class="log-form" action="../func/sifre-sifirla-mail.php" method="post">
                    <div style="margin: 30px; display: flex; flex-direction: column; align-items: center;">
                        <?php include('../func/errors.php'); ?>
                        <p style="color: #333;">Bir şifre sıfırlama isteği göndermek için mail adresini gir:</p>
                    <div class="item-cont">
                        <div class="input-icon"><i style="height: 100%;" class="fas fa-envelope"></i></div>
                        <input class="log-form input" type="text" name="email" placeholder="E-Mail adresini gir...">
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