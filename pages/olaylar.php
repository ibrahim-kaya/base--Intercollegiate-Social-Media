<!DOCTYPE html>
<html>

<?php
include_once('../func/config.php');
include_once('../func/includes.php');
require_once "../func/Mobile_Detect.php";

$detect = new Mobile_Detect;

if(!isset($_GET['universite'])){
    header('location: /index.php');
}

if(!is_numeric($_GET['universite']))  {
    header('location: /index.php');
}

$uni_id = $_GET['universite'];

$stmt = mysqli_prepare($db, "SELECT * FROM categories WHERE ID=?;");
mysqli_stmt_bind_param($stmt, "i", $uni_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$c_row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($db, "SELECT * FROM abonelikler WHERE uniID=?;");
mysqli_stmt_bind_param($stmt, "i", $uni_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$abone_sayi = mysqli_num_rows($result);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($db, "SELECT * FROM posts WHERE postCategory=?;");
mysqli_stmt_bind_param($stmt, "i", $uni_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$gonderi_sayi = mysqli_num_rows($result);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($db, "SELECT * FROM users WHERE Uni=?;");
mysqli_stmt_bind_param($stmt, "i", $uni_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$kisi_sayi = mysqli_num_rows($result);
mysqli_stmt_close($stmt);

$issub = 0;

if(isset($_SESSION['uname']))
{
    $user = $_SESSION['uname'];

    $stmt = mysqli_prepare($db, "SELECT * FROM abonelikler WHERE uniID=? and userID=?;");
    mysqli_stmt_bind_param($stmt, "ii", $uni_id, $_SESSION["ID"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $issub = mysqli_num_rows($result);
    mysqli_stmt_close($stmt);
}
if(!isset($_SESSION['profilePic'])) {$_SESSION['profilePic'] = '';}
?>

<style>

    .abone {
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#b4e391+0,61c419+50,b4e391+100;Green+3D */
        background: rgb(180,227,145); /* Old browsers */
        background: -moz-linear-gradient(-45deg,  rgba(180,227,145,1) 0%, rgba(97,196,25,1) 50%, rgba(180,227,145,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(-45deg,  rgba(180,227,145,1) 0%,rgba(97,196,25,1) 50%,rgba(180,227,145,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(135deg,  rgba(180,227,145,1) 0%,rgba(97,196,25,1) 50%,rgba(180,227,145,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4e391', endColorstr='#b4e391',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
        color: #fff;
        text-shadow: 1px 1px 4px rgba(75, 75, 75, 1);
    }

    #abone-ol:hover {
        opacity: 0.6;
    }

</style>


<head>
    <title>Base ~ <?php echo $c_row['name']; ?></title>

    <script type="text/javascript" src="../auslaender/smooth-scrollbar.js"></script>
    <script type="text/javascript" src="../js/post-func.js"></script>
    <script type="text/javascript">
        var uni = '<?php echo $c_row['name']; ?>';
        var uni_ico = '<?php echo $c_row['pic']; ?>';
    </script>
    <script type="text/javascript" src="../js/olaylar/olaylar-top.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/profil.css"/>

</head>

<body>

<div id="myModal" class="modal">
    <!-- Modal content -->
    <div id="modalid" class="modal-content">
        <div id="m_kapat" class="modal_kapat"></div>
        <div id="c_area" class="index_area"></div>
    </div>

</div>

<?php  include('../func/headbar.php');	?>

<div id="content-wrap">

    <?php include('../func/sidebar.php'); ?>


    <div id="headerbar" class="header"></div>

    <div class="bigdick">

        <div id="left-cont" class="lcont">
            <?php include('../pages/sol_panel.php'); ?>
        </div>

        <div id="body-cont" class="bcont">
            <div class="cover_container">
                <img class="aspect-ratio" src="" onerror="this.src='/images/cover.png'" width="600px" height="210px" style="background-image: linear-gradient(to top, #B5E0E2 1%, transparent 80%),url('<?php echo $c_row['kapak']; ?>');  background-repeat: no-repeat; background-size: auto;"/>
            </div>

            <div class="info_container">
                <div class="profileInfo" style="width: 100%; height: 150px; margin: auto; display: flex; ">
                    <div class="profileInfo" style= "display: flex; width: 25%; align-items: center; justify-content: center;">
                        <div class="profileInfo" style="text-align: center;"><img src="<?php echo $c_row['pic']; ?>" style="margin-left: 5px; border-radius: 50%; width: 100%; height: 100%; object-fit: contain; position: relative; box-shadow: 1px 0px 10px 0px rgba(0,0,0,0.3); background-color: #C5E7E8;" onerror="this.src='/images/avatar.png';"></div>
                    </div>
                    <div class="profileInfo" style="display: flex; flex-direction: column; flex-grow: 1;">
                        <div>
                            <div class="profileInfo username"><h2><?php echo $c_row['name']; ?></h2></div>
                        </div>
                        <div class="profileInfo" style="display: flex; flex-direction: row; flex-grow: 1;">

                            <div class="profileInfo" style= "display: flex; flex-grow: 1; align-items: center; justify-content: center;">
                                <div class="profileInfo upper" style="display: block; text-align: center;">
                                    <p style="margin: 0;">Gönderiler</p>
                                    <p id="takipci_sayi" class="var" style="font-size: 25pt; margin: 0;"><?php echo $gonderi_sayi; ?></p>
                                </div>
                            </div>
                            <div class="profileInfo" style= "display: flex; flex-grow: 1; align-items: center; justify-content: center;">
                                <div class="profileInfo upper" style="display: block; text-align: center;">
                                    <p style="margin: 0;">Takipçiler</p>
                                    <p class="var" style="font-size: 25pt; margin: 0;"><?php echo $abone_sayi; ?></p>
                                </div>
                            </div>
                            <div class="profileInfo" style= "display: flex; flex-grow: 1; align-items: center; justify-content: center;">
                                <div class="profileInfo upper" style="display: block; text-align: center;">
                                    <p style="margin: 0;" title="Bu üniversiteden olduğunu belirten kişi sayısı">Mensup</p>
                                    <p class="var" style="font-size: 25pt; margin: 0;" title="Bu üniversitede olduğunu belirten kişi sayısı"><?php echo $kisi_sayi; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profileInfo otherinfo" style="display: flex; text-align: center;">
                    <div style="display: flex; flex-grow: 1; padding-left: 10px;"><span"><i class="far fa-calendar-alt"></i> Kuruluş tarihi: <strong class="var" ><?php echo $c_row['kurulus']; ?></strong></span></div>
                    <div class="profileInfo" style="display: flex; flex-grow: 1; justify-content: flex-end; padding-right: 10px;"><span><i class="fas fa-map-marker-alt"></i> Şehir: <strong class="var" ><?php echo $c_row['sehir']; ?></strong></span></div>
                </div>
                <div style="display: flex; flex-grow: 1; margin-top: 15px; align-items: center; ">
                    <div class="profileInfo" style="padding-left: 10px;">
                        <span><i class="far fa-calendar-alt"></i> Boş: <strong class="var" >Boş</strong></span>
                    </div>
                    <div style="display: flex; flex-grow: 1; justify-content: flex-end;">
                        <div class="gonder-spin sk-chase">
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                        </div>
                        <div id="profil_btn" class="profileInfo takip_et;" style="transition: all .4s;" onclick="abone_ol(<?php echo $uni_id; ?>);">
                            Takip Et
                        </div>
                    </div>
                </div>
            </div>






            <?php
                if($issub)
                {
                    ?><script>
                    const btn = document.getElementById("profil_btn");
                    btn.classList.remove('takip_et');
                    btn.classList.add('takibi_birak');
                    btn.innerHTML = "Takibi Bırak";
                </script><?php
                }
                else
                {
                ?>
                    <script>
                        const btn = document.getElementById("profil_btn");
                        btn.classList.remove('takibi_birak');
                        btn.classList.add('takip_et');
                        btn.innerHTML = "Takip Et";
                    </script>
                <?php }
            ?>



            <?php
            if(isset($_SESSION['uname'])){
                ?><div id="err_div"></div>
                <div class="textarea-bg">
                    <form method='post' action="" onsubmit="return chk('uni', '<?php echo $uni_id; ?>');">
                        <textarea class="post_textarea" id="entry_area" name="entry" placeholder="Kibarca yaz bakalım." maxlength="250"></textarea>
                        <div class="pb_out"><div id="text_progress" class="pb_in"></div></div>
                        <div class="ta-2" style="text-align: right;">
                            <div id="textarea_feedback"></div>
                            <div class="gonder-spin sk-chase">
                                <div class="sk-chase-dot"></div>
                                <div class="sk-chase-dot"></div>
                                <div class="sk-chase-dot"></div>
                                <div class="sk-chase-dot"></div>
                                <div class="sk-chase-dot"></div>
                                <div class="sk-chase-dot"></div>
                            </div>
                            <button type="submit" id="home_sbtn" class="gonderButonu" name="send-btn" disabled>Gönder Gitsin!</button>
                        </div>
                    </form>
                </div>
            <?php } else { ?>
                Üye değilsin!
            <?php }	?>



            <p class="flow_header" style="margin: 30px 0 0 10px; font-family: 'Kalam'; font-size: 25px;"><?php echo $c_row['kisaltma']; ?> Olaylar</p>

            <div class="post_area">

                <div id="load_data"></div>
                <div id="load_data_message"></div>
            </div>
        </div>

        <div id="right-cont" class="rcont">

        </div>
    </div>

    <script src="../js/post-js.js" type="text/javascript"></script>
    <script src="../js/post-func.js" type="text/javascript"></script>

    <script>

        $(document).ready(function(){
            post_load("<?php echo EncryptThis('SELECT * FROM posts WHERE postCategory = '.$_GET['universite'].' and silindi = 0'); ?>");
        });

    </script>

    <div class="push"></div>
</div>
<?php include('../func/footer.php'); ?>
</body>

</html>