<!DOCTYPE html>
<html>

<?php
include_once('../func/config.php');
include_once('../func/includes.php');

if(!isset($_GET['gonderi']) || !is_numeric($_GET['gonderi'])){
    header('location: /index.php');
}

$postid = $_GET['gonderi'];
$stmt = mysqli_prepare($db, "SELECT * FROM posts WHERE ID = ?;");
mysqli_stmt_bind_param($stmt, "i", $postid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
$p_row = mysqli_fetch_assoc($result);

if(!mysqli_num_rows($result)){
    header('location: /index.php');
}

$stmt = mysqli_prepare($db, "SELECT * FROM users WHERE ID = ?;");
mysqli_stmt_bind_param($stmt, "i", $p_row['userID']);
mysqli_stmt_execute($stmt);
$result_user = mysqli_stmt_get_result($stmt);
$u_row = mysqli_fetch_assoc($result_user);

$stmt = mysqli_prepare($db, "SELECT * FROM categories WHERE ID = ?;");
mysqli_stmt_bind_param($stmt, "i", $p_row['postCategory']);
mysqli_stmt_execute($stmt);
$result_cat = mysqli_stmt_get_result($stmt);
$c_row = mysqli_fetch_assoc($result_cat);

$stmt = mysqli_prepare($db, "SELECT * FROM comments WHERE postID = ?;");
mysqli_stmt_bind_param($stmt, "i", $postid);
mysqli_stmt_execute($stmt);
$result_comments = mysqli_stmt_get_result($stmt);

$stmt = mysqli_prepare($db, "SELECT * FROM post_likes WHERE postID = ?;");
mysqli_stmt_bind_param($stmt, "i", $p_row['ID']);
mysqli_stmt_execute($stmt);
$likes = mysqli_stmt_get_result($stmt);

$userid = (isset($_SESSION['ID']) ? $_SESSION['ID'] : '0xFFFF');

date_default_timezone_set('Europe/Istanbul');

function getMonth($timestamp)
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

    $ay = $aylar[date('m', $timestamp) - 1];

    return $ay;
}


function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

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

    $timest = ltrim($datetime, '@');

    $ay = $aylar[date('m', $timest) - 1];

    $string = array(
        'y' => 'yıl',
        'm' => 'ay',
        'w' => 'hafta',
        'd' => 'gün',
        'h' => 'saat',
        'i' => 'dakika',
        's' => 'saniye',
    );
    $res = '';
    if(($now->getTimestamp() - $ago->getTimestamp()) < 86400)
    {
        if(($now->getTimestamp() - $ago->getTimestamp()) < 60)
        {
            $res = 'şimdi';
        }
        else
        {
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v;
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            $res = $string ? implode(', ', $string) . ' önce' : 'şimdi';
        }
    }
    else
    {
        $res = date("H:i · d ", $ago->getTimestamp()). $ay . date(" Y", $ago->getTimestamp());
    }

    return $res;
}

function turnUrlIntoHyperlink($string){
    //The Regular Expression filter
    $reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";

    // Check if there is a url in the text
    if(preg_match_all($reg_exUrl, $string, $url)) {

        // Loop through all matches
        foreach($url[0] as $newLinks){
            if(strstr( $newLinks, ":" ) === false){
                $link = 'http://'.$newLinks;
            }else{
                $link = $newLinks;
            }

            // Create Search and Replace strings
            $search  = $newLinks;
            $replace = '<a id="post_link" href="'.$link.'" title="'.$newLinks.'" target="_blank">'.$link.'</a>';
            $string = str_replace($search, $replace, $string);
        }
    }

    //Return result
    return $string;
}

if(isset($_SESSION['uname'])) { $user = $_SESSION['uname'];}
if(isset($_SESSION['errors'])) { $errors = $_SESSION['errors']; }
?>

<?php
function iyelikEkle($kelime,$soneEkle='', $bicimlendir=false)
{
    $encoding = 'UTF-8';
    $baglac = "'";
    $sonHarf  =  substr(mb_strtolower($kelime,$encoding),-1); // Son harfi alma
    $sonHarfAlternatif =  substr(mb_strtolower($kelime,$encoding),-2,1); // Sondan bir önceki harfi alma
    $sesliHarfler = 'aeıioüuü'; // Sesli harfler

    // Son Harf sesli sessiz kontrol
    if(strrchr($sesliHarfler, $sonHarf)) {
        $kontrolHarf = $sonHarf;
        $iyelikEki = array('nın','nin','nun','nün');
    }else { // Son harf içinde sesli harfler yoksa sonran bir önceki harf kontrol edilir
        $kontrolHarf = $sonHarfAlternatif;
        $iyelikEki = array('ın','in','un','ün');
    }

    // Son harfe göre iyelik ekleme
    switch($kontrolHarf) {
        case "a":
        case "ı":
            $iyelik = $iyelikEki[0];
            break;
        case "e":
        case "i":
            $iyelik = $iyelikEki[1];
            break;
        case "o":
        case "u":
            $iyelik = $iyelikEki[2];
            break;
        case "ö":
        case "ü":
            $iyelik = $iyelikEki[3];
            break;
        default:
            $iyelik = 'in';
            break;
    }

    $_kelime = "{$kelime}{$baglac}{$iyelik} {$soneEkle}";

    switch($bicimlendir) {
        case "k": // Küçük döndür
            $_kelime = mb_strtolower($_kelime,$encoding);
            break;
        case "b": // Büyük döndür
            $_kelime = mb_strtoupper($_kelime,$encoding);
            break;
        case "i": // Büyük döndür
            $_kelime = ucfirst(mb_strtolower($_kelime,$encoding));
            break;
    }


    return $_kelime;
}
?>


<head>
    <title>Base ~ <?php echo iyelikEkle(htmlspecialchars($u_row['Username'],false)); ?> <?php echo $c_row['name']; ?>'ndeki gönderisi</title>

    <script src="../js/post-func.js" type="text/javascript"></script>
</head>

<style>
    .post_bottom4{
        display:none;
    }
</style>


<body id="yorumlar">

<div id="myModal" class="modal">
    <!-- Modal content -->
    <div id="modalid" class="modal-content">
        <div id="m_kapat" class="modal_kapat"></div>
        <div id="c_area" class="index_area"></div>
    </div>

</div>

<?php  include('../func/headbar.php');	?>

<div id="content-wrap">
    <?php
    include('../func/sidebar.php');
    ?>


    <div id="headerbar" class="header"></div>

    <div class="bigdick">

        <div id="left-cont" class="lcont">

        </div>


        <div id="body-cont" class="bcont">
            <div style="display: flex; height: 50px; border-bottom: 1px solid #99D4D6;">
                <div class="geri-tusu" style="width: 50px; text-align: center; line-height: 50px; font-size: 20pt; color: #FF707C; cursor: pointer; transition: all .4s;" onclick="back();"><i class="fas fa-arrow-left"></i></div>
                <div style="line-height: 50px; font-family: 'Kalam'; font-size: 25px;"><span style="padding-left: 10px;">Yorumlar</span></div>
            </div>
            <div class="post_area">

                <div id="load_data"></div>

                <div class="comments">

                    <?php
                    if(!mysqli_num_rows($result_comments))
                    {
                        echo '<div class="no_post" style="text-align: center; margin: 10px; font-size: 18px; color: 555; padding: 30px;"><i class="no_com_text" style="color: #888">Burda hiç yorum yok.</i></div>';
                    }
                    else
                    {
                        while($row = mysqli_fetch_array($result_comments))
                        {
                            if($row['silindi'] == 1)
                            {
                             echo '<div class="post_comment" style="padding: 10px; position: relative; border-bottom: 1px solid #99D4D6;">
                            <p style="text-align: center; color: #666; font-size: 10pt;"><i>Bu yorum silinmiş.</i></p>
                            </div>';
                            }
                            else
                            {

                            $result_c_user = mysqli_query($db, "SELECT * FROM users WHERE ID = ".$row['userID']);
                            $rcu_row = mysqli_fetch_assoc($result_c_user);

                            $user_liked = 0;

                            if(isset($_SESSION['ID'])) {
                                $stmt = mysqli_prepare($db, "SELECT * FROM comment_likes WHERE cmtID=? and userID=?;");
                                mysqli_stmt_bind_param($stmt, "ii", $row['ID'], $_SESSION['ID']);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                mysqli_stmt_close($stmt);
                                $user_liked = mysqli_num_rows($result);
                            }

                            $stmt = mysqli_prepare($db, "SELECT * FROM comment_likes WHERE cmtID = ?;");
                            mysqli_stmt_bind_param($stmt, "i", $row['ID']);
                            mysqli_stmt_execute($stmt);
                            $likes = mysqli_stmt_get_result($stmt);
                            mysqli_stmt_close($stmt);

                            $like_cnt = mysqli_num_rows($likes);

                            if(isset($_SESSION["ID"]) && $row['userID'] == $_SESSION["ID"])
                            {
                                $cmtmenu = '
									<div class="post-dropdown-menu">
										<div class="post-secenek-btn" onclick="postDropdown(this);"><p><i class="fas fa-chevron-down"></i></p></div>
										<div class="post-secenek-menu">
											<a href="javascript:void(0)" onclick="postSecenek(999, '.$row['ID'].');"><p><i class="far fa-edit"></i> Yorumu düzenle</p></a>
											<a href="javascript:void(0)" onclick="postSecenek(999, '.$row['ID'].');"><p><i class="far fa-trash-alt"></i> Yorumu sil</p></a>
										</div>
									</div>
									';
                            }
                            else
                            {
                                $cmtmenu = '
									<div class="post-dropdown-menu">
										<div class="post-secenek-btn" onclick="postDropdown(this);"><p><i class="fas fa-chevron-down"></i></p></div>
										<div class="post-secenek-menu">
											<a href="javascript:void(0)" onclick="postSecenek(999, '.$row['ID'].');"><p><i class="fas fa-exclamation-triangle"></i> Yorumu şikayet et</p></a>
										</div>
									</div>
									';
                            }
                            ?>

                            <div class="post_comment" id="<?php echo $row['ID']; ?>" style="padding-bottom: 20px; transition: all .4s; position: relative; border-bottom: 1px solid #99D4D6;">
                                <a href="/p/<?php echo htmlspecialchars($rcu_row['Username']) ?>"><img class="c_profile_pic" src="<?php echo $rcu_row['profilePic']; ?>" height="35" width="35" onerror="this.src='/images/avatar.png';"></a>
                                <a href="/p/<?php echo htmlspecialchars($rcu_row['Username']) ?>" class="c_username_label" style="font-size: 17px;"> <?php echo $rcu_row['Username']; echo ($rcu_row['Onayli'] ? ' <p title="Onaylı Hesap" class="mavi-tik"><i class="fas fa-check-circle"></i></p>' : ''); ?></a>
                                <p class="c_post_text" style="font-size: 10.5pt;"><?php echo str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>',htmlspecialchars($row['comment'])); ?></p>
                                <?php echo $cmtmenu; ?>
                                <div class="post_bottom2" style="margin-top: 10px; color: #666; font-size: 13px; padding-left: 8px;"><div class="c_like" style="width: 15px; height: 15px; float: left; margin: -4px 5px 0 0; font-size: 20px; cursor: pointer;" onclick="like_comment(<?php echo $row['ID']; ?>)"><div class="btn begen"><svg viewBox="-20 -90 555 592" xmlns="http://www.w3.org/2000/svg"><path id="c_like_button_<?php echo $row['ID']; ?>" style="fill: <?php echo ($user_liked ? '#ff0000' : 'transparent'); ?>" d="m471.382812 44.578125c-26.503906-28.746094-62.871093-44.578125-102.410156-44.578125-29.554687 0-56.621094 9.34375-80.449218 27.769531-12.023438 9.300781-22.917969 20.679688-32.523438 33.960938-9.601562-13.277344-20.5-24.660157-32.527344-33.960938-23.824218-18.425781-50.890625-27.769531-80.445312-27.769531-39.539063 0-75.910156 15.832031-102.414063 44.578125-26.1875 28.410156-40.613281 67.222656-40.613281 109.292969 0 43.300781 16.136719 82.9375 50.78125 124.742187 30.992188 37.394531 75.535156 75.355469 127.117188 119.3125 17.613281 15.011719 37.578124 32.027344 58.308593 50.152344 5.476563 4.796875 12.503907 7.4375 19.792969 7.4375 7.285156 0 14.316406-2.640625 19.785156-7.429687 20.730469-18.128907 40.707032-35.152344 58.328125-50.171876 51.574219-43.949218 96.117188-81.90625 127.109375-119.304687 34.644532-41.800781 50.777344-81.4375 50.777344-124.742187 0-42.066407-14.425781-80.878907-40.617188-109.289063zm0 0"/></svg></div></div> · <span id="y_begeni_sayi_<?php echo $row['ID']; ?>" style="display: contents; font-size: 10pt;"><?php echo $like_cnt; ?> beğeni</span> · <i class="far fa-clock"></i> <?php echo date("H:i · d ", $row['date']). getMonth($row['date']) . date(" Y", $row['date']); ?></div>
                            </div>
                            <?php
                            }
                        }
                    }

                    if(isset($_SESSION['uname'])){
                        ?><div id="err_div"></div>
                        <div class="textarea-bg" style= "margin-top: 20px;">
                            <form method='post' action="" onsubmit="return chk('comment', '<?php echo $postid; ?>');">
                                <textarea class="post_textarea" id="comment_area" name="entry" placeholder="Kibarca yaz bakalım." maxlength="250"></textarea>
                                <div class="pb_out"><div id="c_text_progress" class="pb_in"></div></div>
                                <div class="ta-2" style="text-align: right;">
                                    <div id="commentarea_feedback"></div>
                                    <div class="gonder-spin sk-chase">
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                        <div class="sk-chase-dot"></div>
                                    </div>
                                    <button type="submit" id="comm_sbtn" class="gonderButonu" name="send-btn" disabled>Gönder Gitsin!</button>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <div style="margin: 20px 0; border-bottom: 1px solid #99D4D6;"></div>
                        <div class="right_login">
                            <p style="color: #000; text-align: center;">Yorum yapmak için hemen şimdi üye ol!</p>
                            <a class="home_reg-btn" href="/turnike/uyeol">Kayıt Ol</a>
                            <a class="home_log-btn" href="/turnike">Giriş Yap</a>
                        </div>
                    <?php }	?>

                </div>

            </div>
        </div>

        <div id="right-cont" class="rcont">
            <?php
            if(isset($_SESSION['uname'])){ ?>
                <p>Üyesin.</p>
            <?php } else { ?>
                <p>Üye değilsin!</p>
            <?php }	?>
        </div>
    </div>

    <script src="../js/post-js.js" type="text/javascript"></script>

    <script>



        function highlightElement(element) {
            const background = $('<div></div>');

            $(background).css({
                'position':'relative',
                'top':'-' + $(element).height() + 'px',
                'background-color':'#F5EEB9',
                'z-index':'-10',
                'height':($(element).height()+20) + 'px',
                'width':$(element).width() + 'px',
                'margin-bottom':'-' + $(element).height() + 'px',
                'padding':'0px',
                'float':'left',
            });

            $(background).appendTo(element);

            $(background).fadeOut(5000);

            return true;
        }

        $(document).ready(function(){
            const scroll_yorum = <?php echo (isset($_GET['yorum']) ? $_GET['yorum'] : "0"); ?>;

            if(scroll_yorum)
            {
                const yorum_scroll = document.getElementById(scroll_yorum);
                if(yorum_scroll)
                {
                    yorum_scroll.scrollIntoView();
                }
                else
                {
                    iziToast.show({
                        title: '<i class="fas fa-times"></i>',
                        message: 'Yorum bulunamadı. Silinmiş olabilir.',
                        color: 'red',
                        position: pos
                    });
                }


                highlightElement(document.getElementById(scroll_yorum));

            }

            const limit = 1;
            const start = 0;


            function load_posts(limit, start)
            {
                $.ajax({
                    url:"/loadposts",
                    method:"POST",
                    data:{limit:limit, start:start, req:"<?php echo EncryptThis('SELECT * FROM posts WHERE ID = '.$postid); ?>", yorum:1},
                    cache:false,
                    success:function(data)
                    {
                        $('#load_data').append(data);
                    }
                });
            }

            load_posts(limit, start);

        });

    </script>

    <div class="push"></div>
</div>
<?php include('../func/footer.php'); ?>

</body>
</html>