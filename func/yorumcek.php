<style>

    .post_comment{
        border-bottom: 1px solid #A8DADC;
        padding: 10px 0 20px 0;
        transition: all .4s;
    }

    .post_comment:last-child {
        border-bottom: 0px;
    }

</style>

<?php
include_once('../func/config.php');

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



$postid = $_POST['gonderi'];

$stmt = mysqli_prepare($db, "SELECT * FROM posts WHERE ID = ?;");
mysqli_stmt_bind_param($stmt, "i", $postid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$p_row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($db, "SELECT * FROM users WHERE ID = ?;");
mysqli_stmt_bind_param($stmt, "i", $p_row['userID']);
mysqli_stmt_execute($stmt);
$result_user = mysqli_stmt_get_result($stmt);
$u_row = mysqli_fetch_assoc($result_user);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($db, "SELECT * FROM comments WHERE postID = ?;");
mysqli_stmt_bind_param($stmt, "i", $postid);
mysqli_stmt_execute($stmt);
$result_comments = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

date_default_timezone_set('Europe/Istanbul');

function getMonth($timestamp) {
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

if($p_row['silindi'])
{
    $str1 = '
				<div class="post">
				<p style="text-align: center; color: #666; font-size: 10pt;"><i>Bu gönderi silinmiş.</i></p>
				</div>

			<div class="comments">';
}
else
{
    if(isset($_POST["usern"]) && htmlspecialchars($u_row['Username']) == $_POST["usern"])
    {
        $postmenu = '
		<div class="post-dropdown-menu">
			<div class="post-secenek-btn" onclick="postDropdown(this);"><p><i class="fas fa-chevron-down"></i></p></div>
			<div class="post-secenek-menu">
				<a href="#"><p style="font-size: 14px;"><i class="far fa-edit"></i> Gönderiyi düzenle</p></a>
				<a href="#"><p style="font-size: 14px;"><i class="far fa-trash-alt"></i> Gönderiyi sil</p></a>
				<a href="#"><p style="font-size: 14px;"><i class="fas fa-link"></i> Gönderi bağlantısını kopyala</p></a>
			</div>
		</div>
		';
    }
    else
    {
        $postmenu = '
		<div class="post-dropdown-menu">
			<div class="post-secenek-btn" onclick="postDropdown(this);"><p><i class="fas fa-chevron-down"></i></p></div>
			<div class="post-secenek-menu">
				<a href="#"><p style="font-size: 14px;"><i class="fas fa-exclamation-triangle"></i> Gönderiyi şikayet et</p></a>
				<a href="#"><p style="font-size: 14px;"><i class="fas fa-ban"></i> '.htmlspecialchars($u_row['Username']).' adlı kullanıcıyı engelle</p></a>
				<a href="#"><p style="font-size: 14px;"><i class="fas fa-link"></i> Gönderi bağlantısını kopyala</p></a>
			</div>
		</div>
		';
    }

    $str1 = '
				<div class="post">
				<a href="#" style="display: inline-block; height: 42px; margin: 10px 10px 10px 10px;"><img class="profile_pic" src=" '. $u_row['profilePic'] .' " height="35" width="35" onerror="this.src=\'/images/avatar.png\';"></a>
				<a href="#" class="username_label" style="font-size: 16px;"> '. $u_row['Username'] .''.($u_row['Onayli'] ? ' <p title="Onaylı Hesap" class="mavi-tik"><i class="fas fa-check-circle"></i></p>' : '').'</a>
				<p class="post_text" style="font-size: 13px;"> '. str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', turnUrlIntoHyperlink(htmlspecialchars($p_row['post']))) .' </p> '.$postmenu.'
				<p class="post_time_bot"><i class="far fa-clock" style="margin-left: 5px;"></i> '.date("H:i · d ", $p_row['postTime']). getMonth($p_row['postTime']) . date(" Y", $p_row['postTime']).'</p>
			</div>

			<div class="comments">';
}

$str2 = '';

if(!mysqli_num_rows($result_comments))
{
    $str2 = '<div class="no_post" style="text-align: center; margin: 10px; font-size: 13px; color: 555;"><i class="no_com_text" style="color: #888">Burda hiç yorum yok.</i></div>';
}else{
    while($row = mysqli_fetch_array($result_comments))
    {
        if($row['silindi'] == 1)
        {
            $str2 .= '
			<div class="post_comment">
			<p style="text-align: center; color: #666; font-size: 10pt;"><i>Bu yorum silinmiş.</i></p>
			</div>';
        }
        else {
            $user_liked = 0;

            if (isset($_SESSION['ID'])) {
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


            $result_c_user = mysqli_query($db, "SELECT * FROM users WHERE ID = " . $row['userID']);
            $rcu_row = mysqli_fetch_assoc($result_c_user);
            $str2 .= '
			
				<div class="post_comment">
				<a href="/p/' . htmlspecialchars($rcu_row['Username']) . '"><img class="c_profile_pic" src="' . $rcu_row['profilePic'] . '" height="30" width="30" onerror="this.src=\'/images/avatar.png\';"></a>
				<a href="/p/' . htmlspecialchars($rcu_row['Username']) . '" class="c_username_label">' . $rcu_row['Username'] . '' . ($rcu_row['Onayli'] ? ' <p title="Onaylı Hesap" class="mavi-tik"><i class="fas fa-check-circle"></i></p>' : '') . '</a>
				<p class="c_post_text" style="font-size: 13px;">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', htmlspecialchars($row['comment'])) . '</p>
				<div class="post_bottom2" style="margin-top: 10px; color: #999; font-size: 12px; padding-left: 8px;"><div class="c_like" style="width: 15px; height: 15px; float: left; margin: -4px 5px 0 0; font-size: 20px; cursor: pointer;" onclick="like_comment(' . $row['ID'] . ')"><div class="btn begen"><svg viewBox="-20 -90 555 592" xmlns="http://www.w3.org/2000/svg"><path id="c_like_button_' . $row['ID'] . '" style="fill: ' . ($user_liked ? '#ff0000' : 'transparent') . '" d="m471.382812 44.578125c-26.503906-28.746094-62.871093-44.578125-102.410156-44.578125-29.554687 0-56.621094 9.34375-80.449218 27.769531-12.023438 9.300781-22.917969 20.679688-32.523438 33.960938-9.601562-13.277344-20.5-24.660157-32.527344-33.960938-23.824218-18.425781-50.890625-27.769531-80.445312-27.769531-39.539063 0-75.910156 15.832031-102.414063 44.578125-26.1875 28.410156-40.613281 67.222656-40.613281 109.292969 0 43.300781 16.136719 82.9375 50.78125 124.742187 30.992188 37.394531 75.535156 75.355469 127.117188 119.3125 17.613281 15.011719 37.578124 32.027344 58.308593 50.152344 5.476563 4.796875 12.503907 7.4375 19.792969 7.4375 7.285156 0 14.316406-2.640625 19.785156-7.429687 20.730469-18.128907 40.707032-35.152344 58.328125-50.171876 51.574219-43.949218 96.117188-81.90625 127.109375-119.304687 34.644532-41.800781 50.777344-81.4375 50.777344-124.742187 0-42.066407-14.425781-80.878907-40.617188-109.289063zm0 0"/></svg></div></div> · <span id="y_begeni_sayi_' . $row['ID'] . '" style="display: contents; font-size: 10pt;">' . $like_cnt . ' beğeni</span> · <i class="far fa-clock"></i> ' . date("H:i · d ", $row['date']) . getMonth($row['date']) . date(" Y", $row['date']) . '</div>
				</div> ';
        }
    }
}

if(isset($_SESSION['ID'])) {
    $str3 = '
			<div id="c_err_div"></div>
			<div class="textarea-bg" style= "margin: 20px 10px 10px 10px;">
			<form method="post" action="" onsubmit="return chk(\'comment\', \''.$postid.'\');">
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
					<button type="submit" id="comm_sbtn" class="gonderButonu" name="send-comment-btn" disabled>Gönder Gitsin!</button>
				</div>
			</form>
			</div>';
} else $str3 = '<div style="margin-top: 20px; border-bottom: 1px solid var(--border);"></div>
					<div class="right_login" style="padding-top: 30px;">
					<p style="color: #000; text-align: center; margin-bottom: 3px;">Söylemek istediğin bir şey mi var?</p>
					<p style="color: #000; text-align: center; margin-top: 3px;">Yorum yapmak için hemen şimdi üye ol!</p>
					<a class="home_reg-btn" href="/turnike/uyeol">Kayıt Ol</a>
					<a class="home_log-btn" href="/turnike">Giriş Yap</a>
					</div>';

echo $str1.$str2.'</div>'.$str3;
