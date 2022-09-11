<!DOCTYPE html>
<html lang="tr">

<?php
include_once('../func/config.php');

if(isset($_SESSION['uname'])) { $user = $_SESSION['uname'];}
if(!isset($_SESSION['profilePic'])) {$_SESSION['profilePic'] = '';}
?>
<head>
    <?php
    if(!isset($_SERVER['REDIRECT_STATUS'])) header('location: /');
    $code = $_SERVER['REDIRECT_STATUS'];

    $baslik = array(
        403 => 'Yasak Bölge!',
        404 => 'Bulunamayan Sayfa!',
        500 => 'Bi\' Şeyler Oldu!'
    );

    if (array_key_exists($code, $baslik) && is_numeric($code)) {
        ?> <title>Base ~ <?php echo("{$baslik[$code]}"); ?></title> <?php
    } else {
        ?> <title>Base ~ Bi' Şeyler Oldu!</title> <?php
    }?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />

    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>


    <link href='https://fonts.googleapis.com/css?family=Bellota+Text' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Duru+Sans' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Kalam' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Cagliostro' rel='stylesheet'>

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/stil.css"/>
    <link rel="stylesheet" type="text/css" href="../css/login.css"/>

    <link rel="apple-touch-icon" sizes="120x120" href="/images/apple-touch-icon-120x120-precomposed.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/images/apple-touch-icon-152x152-precomposed.png" />

    <script>
        function openSlideMenu(){
            document.getElementById('menu').style.width = '250px';
            document.getElementById('av').style.opacity = "0";
        }
        function closeSlideMenu(){
            document.getElementById('menu').style.width = '0px';
            document.getElementById('av').style.opacity = "1";
        }
    </script>
</head>

<body>

<div id="myModal" class="modal">
    <!-- Modal content -->
    <div id="modalid" class="modal-content">
        <div id="m_kapat" class="modal_kapat"></div>
        <div id="c_area" class="index_area"></div>
    </div>

</div>

<div id="head-bar" class="headbar">
    <?php  include('../func/headbar.php');	?>

    <div id="content-wrap">
        <?php
        include('../func/sidebar.php');
        ?>


        <div id="headerbar" class="header"></div>


        <?php
        $codes = array(
            403 => "<h1>Yassah hemşerim buraya giremen!</h1>Seni şöyle anasayfaya alalım biz.",
            404 => "<h1>Böyle bi' sayfa yok!</h1>Seni şöyle anasayfaya alalım biz.",
            500 => "<h1>Bazı şeyler ters gitti!</h1>Ama sorun sende değil bende. Seni şöyle anasayfaya alalım biz."
        );

        $resimler = array(
            403 => '<img src="/images/403.png" width="320" height="192">',
            404 => '<img src="/images/404.png" width="192" height="192">',
            500 => '<img src="/images/404.png" width="192" height="192">'
        );

        $baslik = array(
            403 => 'Yasak Bölge!',
            404 => 'Bulunamayan Sayfa!',
            500 => 'Bi\' Şeyler Oldu!'
        );
        ?>

        <div style="text-align: center;">
            <div class="err-div">
                <div style="padding-top: 50px;">
                    <?php
                    if (array_key_exists($code, $codes) && is_numeric($code)) {
                        echo("{$resimler[$code]}");
                        echo("{$codes[$code]}");
                    } else {
                        echo('<img src="/images/404.png" width="192" height="192">');
                        echo('<h1>Bazı şeyler ters gitti!</h1>Hiçbir şey olmasa bile kesinlikle bir şeyler oldu. Seni şöyle anasayfaya alalım biz.');
                    }?>
                </div>
                <a href="/"><div style="padding-top: 25px;"><button class="err-home-button"><i class="fa fa-home" aria-hidden="true"></i> Beni Eve Götür</button></div></a>
            </div>
        </div>

        <div class="push"></div>
    </div>
    <?php include('../func/footer.php'); ?>
</body>

</html>