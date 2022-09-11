<!DOCTYPE html>
<html lang="tr">

<?php
include_once('../func/config.php');
include_once('../func/includes.php');
require_once "../func/Mobile_Detect.php";

$detect = new Mobile_Detect;

if(isset($_SESSION['uname'])) { $user = $_SESSION['uname']; $userid = $_SESSION['ID'];}
if(!isset($_GET['user'])){ header('location: /'); }

$usern = $_GET['user'];

$stmt = mysqli_prepare($db, "SELECT * FROM users WHERE Username=?;");
mysqli_stmt_bind_param($stmt, "s", $usern);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

$userinf = mysqli_fetch_assoc($result);
if(!$userinf['ID']) return header('location: /');

$uuni = $userinf['Uni'];
if($uuni) {
    $stmt = mysqli_prepare($db, "SELECT * FROM categories WHERE ID = ?;");
    mysqli_stmt_bind_param($stmt, "i", $uuni);
    mysqli_stmt_execute($stmt);
    $result_uni = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    $uniinf = mysqli_fetch_assoc($result_uni);
}
$uid = $userinf['ID'];

$stmt = mysqli_prepare($db, "SELECT * FROM posts WHERE userID = ? and silindi = 0;");
mysqli_stmt_bind_param($stmt, "i", $uid);
mysqli_stmt_execute($stmt);
$result_post = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$post_cnt = mysqli_num_rows($result_post);

$stmt = mysqli_prepare($db, "SELECT * FROM comments WHERE userID = ? and silindi = 0;");
mysqli_stmt_bind_param($stmt, "i", $uid);
mysqli_stmt_execute($stmt);
$result_cmt = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$cmt_cnt = mysqli_num_rows($result_cmt);

$stmt = mysqli_prepare($db, "SELECT * FROM user_follows WHERE FollowingID=?;");
mysqli_stmt_bind_param($stmt, "i", $userinf['ID']);
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$follower_cnt = mysqli_num_rows($query);

$stmt = mysqli_prepare($db, "SELECT * FROM user_follows WHERE FollowerID=?;");
mysqli_stmt_bind_param($stmt, "i", $userinf['ID']);
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$following_cnt = mysqli_num_rows($query);

$stmt = mysqli_prepare($db, "SELECT * FROM abonelikler WHERE userID=?;");
mysqli_stmt_bind_param($stmt, "i", $userinf['ID']);
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$subscribed_cnt = mysqli_num_rows($query);

$follows = 0;

if(isset($_SESSION['uname']))
{
    $user = $_SESSION['uname'];
    $stmt = mysqli_prepare($db, "SELECT * FROM user_follows WHERE FollowingID=? and FollowerID=?;");
    mysqli_stmt_bind_param($stmt, "ii", $userinf['ID'], $_SESSION["ID"]);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $follows = mysqli_num_rows($query);
}

function converttime($datetime, $full = false): string
{
    $aylar = array(
        'Oca',
        'Şub',
        'Mar',
        'Nis',
        'May',
        'Haz',
        'Tem',
        'Ağu',
        'Eyl',
        'Eki',
        'Kas',
        'Ara'
    );

    $ay = $aylar[date('m', $datetime) - 1];
    return date("d ", $datetime). $ay . date(" Y", $datetime);
}
?>

<head>
    <title>Base ~ <?php echo $usern; ?> Profili</title>

    <link rel="stylesheet" type="text/css" href="/css/profil.css"/>

    <script>
        let ppic = "<?php echo $userinf['profilePic']; ?>";
        let cpic = "<?php echo $userinf['coverPic']; ?>";
    </script>

</head>

<body id="profil<?php if(isset($_SESSION['ID']) && $_SESSION['ID'] == $uid) { echo '_main'; } ?>">
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div id="modalid" class="modal-content">
        <div id="m_kapat" class="modal_kapat"></div>
        <div id="c_area"></div>
    </div>

</div>

<?php  include('../func/headbar.php');	?>

<div id="content-wrap">
    <?php include('../func/sidebar.php'); ?>


    <div id="headerbar" class="header"></div>

    <div class="bigdick">

        <div id="left-cont" class="lcont">

        </div>
        <div id="body-cont" class="bcont">

            <div id="kapak-resmi" class="cover_container" style="cursor:pointer;">
                <img class="aspect-ratio" src="<?php echo $userinf['coverPic'] ?>" onerror="this.src='/images/cover.png'" style="background-color: #C5E7E8;"/>
            </div>
            <div class="info_container">
                <div class="profileInfo" style="width: 100%; height: 150px; margin: auto; display: flex; ">
                    <div id="profil-resmi" class="profileInfo" style= "display: flex; width: 25%; align-items: center; justify-content: center; cursor:pointer;">
                        <div class="profileInfo" style="text-align: center;"><img src="<?php echo $userinf['profilePic']; ?>" style="margin-left: 5px; border-radius: 50%; width: 100%; height: 100%; object-fit: contain; position: relative; box-shadow: 1px 0px 10px 0px rgba(0,0,0,0.3); background-color: #C5E7E8;" onerror="this.src='/images/avatar.png';"></div>
                    </div>
                    <div class="profileInfo" style="display: flex; flex-direction: column; flex-grow: 1;">
                        <div>
                            <div class="profileInfo username"><h2><?php echo $userinf['Username']; echo ($userinf['Onayli'] ? ' <p title="Onaylı Hesap" class="mavi-tik" style="font-size: 17px; margin: 0;"><i class="fas fa-check-circle"></i></p>' : ''); ?></h2></div>
                        </div>
                        <div class="profileInfo" style="display: flex; flex-direction: row; flex-grow: 1;">

                            <div class="profileInfo" style= "display: flex; flex-grow: 1; align-items: center; justify-content: center;">
                                <div class="profileInfo upper" style="display: block; text-align: center;">
                                    <p style="margin: 0;">Takipçi</p>
                                    <p id="takipci_sayi" class="var" style="font-size: 25pt; margin: 0;"><?php echo $follower_cnt; ?></p>
                                    <p style="margin: 0; text-transform: uppercase; font-size: 8pt;">&nbsp;</p>
                                </div>
                            </div>
                            <div class="profileInfo" style= "display: flex; flex-grow: 1; align-items: center; justify-content: center;">
                                <div class="profileInfo upper" style="display: block; text-align: center;">
                                    <p style="margin: 0;">Takip Edilen</p>
                                    <p class="var" style="font-size: 25pt; margin: 0;"><?php echo $following_cnt; ?></p>
                                    <p style="margin: 0; text-transform: uppercase; font-size: 8pt;">Kişi</p>
                                </div>
                            </div>
                            <div class="profileInfo" style= "display: flex; flex-grow: 1; align-items: center; justify-content: center;">
                                <div class="profileInfo upper" style="display: block; text-align: center;">
                                    <p style="margin: 0;">Takip Edilen</p>
                                    <p class="var" style="font-size: 25pt; margin: 0;"><?php echo $subscribed_cnt; ?></p>
                                    <p style="margin: 0; text-transform: uppercase; font-size: 8pt;">Üniversite</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profileInfo otherinfo" style="display: flex; text-align: center;">
                    <div style="display: flex; flex-grow: 1; padding-left: 10px;"><span"><i class="fas fa-graduation-cap"></i> Üniversite: <strong class="var" ><?php echo ($uuni) ? '<a href="/uni/'.$uniinf['ID'].'" title="'.$uniinf['name'].'">'.$uniinf['kisaltma'].'</a>' : 'Yok'; ?></strong></span></div>
                    <div class="profileInfo" style="display: flex; flex-grow: 1; justify-content: flex-end; padding-right: 10px;"><span><i class="fas fa-birthday-cake"></i> Doğum Tarihi: <strong class="var" ><?php echo ($userinf['dogumTarihi']) ? $userinf['dogumTarihi'] : 'Yok'; ?></strong></span></div>
                </div>
                <div style="display: flex; flex-grow: 1; margin-top: 15px; align-items: center; ">
                    <div class="profileInfo" style="padding-left: 10px;">
                        <span><i class="far fa-calendar-alt"></i> Üyelik Tarihi: <strong class="var" ><?php echo converttime($userinf['kayitTarihi']); ?></strong></span>
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
                        <div id="profil_btn" class="profileInfo<?php if(isset($userid) && $userid == $userinf['ID']) { echo ' p_duzenle'; } else { echo ' takip_et'; } ?>" style="transition: all .4s;" onclick="<?php echo (isset($userid) && $userid == $userinf['ID']) ? 'location.href = \'/ayarlar\';' : 'UserTakip('.$userinf['ID'].', \''.$userinf['Username'].'\')'; ?>">
                            <?php if(isset($userid) && $userid == $userinf['ID']) { echo 'Profili Düzenle'; } else { echo 'Takip Et'; } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tabs">
                <div class="tab-baslik">
                    <div class="aktif">
                        <p style="margin: 0;">Gönderiler</p>
                        <?php if($post_cnt) echo '<p style="margin: 0; font-size: 9pt;">'.$post_cnt.'</p>'; ?>
                    </div>
                    <div>
                        <p style="margin: 0;">Yorumlar</p>
                        <?php if($cmt_cnt) echo '<p style="margin: 0; font-size: 9pt;">'.$cmt_cnt.'</p>'; ?>
                    </div>
                </div>
                <div class="tab-indicator"></div>
            </div>

            <div class="post_area">
                <div class="posts">
                    <div id="load_data"></div>
                    <div id="load_data_message"></div>
                </div>
                <div class="posts" style="opacity: 0; height: 0;">
                    <div id="load_c_data"></div>
                    <div id="load_c_data_message"></div>
                </div>
            </div>

        </div>

        <div id="right-cont" class="rcont">

        </div>
    </div>

    <?php
    if(isset($userid) && $userid != $userinf['ID'])
    {
        if($follows)
        {
            ?><script>
            var btn = document.getElementById("profil_btn");
            btn.classList.remove('takip_et');
            btn.classList.add('takibi_birak');
            btn.innerHTML = "Takibi Bırak";
        </script><?php
        }
        else
        {
        ?>
            <script>
                var btn = document.getElementById("profil_btn");
                btn.classList.remove('takibi_birak');
                btn.classList.add('takip_et');
                btn.innerHTML = "Takip Et";
            </script>
        <?php }
    }
    ?>

    <script src="../js/post-func.js" type="text/javascript"></script>
    <script src="../js/post-js.js" type="text/javascript"></script>
    <script src="../js/profil-js.js" type="text/javascript"></script>

    <script>

        $(document).ready(function(){
            post_load("<?php echo EncryptThis('SELECT * FROM posts WHERE userID = '.$userinf['ID'].' and silindi = 0'); ?>");
            comment_load("<?php echo EncryptThis('SELECT * FROM comments WHERE userID = '.$userinf['ID'].' and silindi = 0'); ?>");
        });

    </script>

    <div class="push"></div>
</div>
<?php include('../func/footer.php'); ?>
</body>

</html>