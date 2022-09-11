<?php
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) { header('location: /'); return; }

include_once('../func/config.php');

$username = (isset($_SESSION['uname']) ? $_SESSION['uname'] : '0xFFFF');
$userid = (isset($_SESSION['ID']) ? $_SESSION['ID'] : '0xFFFF');

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
			$replace = '<a class="post_link" href="'.$link.'" title="'.$newLinks.'" target="_blank">'.$link.'</a>';
			$string = str_replace($search, $replace, $string);
		}
	}

	//Return result
	return $string;
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


if(isset($_POST["limit"], $_POST["start"], $_POST["req"]))
{
	$stmt = mysqli_prepare($db, DecryptThis($_POST["req"])." ORDER BY ID DESC LIMIT ?, ?;");
	mysqli_stmt_bind_param($stmt, "ii", $_POST["start"], $_POST["limit"]);
	mysqli_stmt_execute($stmt);
	$result_post = mysqli_stmt_get_result($stmt);
	mysqli_stmt_close($stmt);

	while($row = mysqli_fetch_array($result_post))
	{
		if($row['silindi'] == 1)
		{
			echo '
			<div class="post">
			<p style="text-align: center; color: #666; font-size: 10pt;"><i>Bu yorum silinmiş.</i></p>
			</div>';
		}
		else
		{


		$stmt = mysqli_prepare($db, "SELECT * FROM users WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt, "i", $row['userID']);
		mysqli_stmt_execute($stmt);
		$result_user = mysqli_stmt_get_result($stmt);
		$u_row = mysqli_fetch_assoc($result_user);
		mysqli_stmt_close($stmt);

		$stmt = mysqli_prepare($db, "SELECT * FROM comment_likes WHERE cmtID = ?;");
		mysqli_stmt_bind_param($stmt, "i", $row['ID']);
		mysqli_stmt_execute($stmt);
		$likes = mysqli_stmt_get_result($stmt);
		mysqli_stmt_close($stmt);

		$like_cnt = mysqli_num_rows($likes);


		date_default_timezone_set('Europe/Istanbul');

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

		$ay = $aylar[date('m', $row['date']) - 1];
		?>

		<?php
		$user_liked = 0;

		if($userid != '0xFFFF')
		{
			$stmt = mysqli_prepare($db, "SELECT * FROM comment_likes WHERE cmtID=? and userID=?;");
			mysqli_stmt_bind_param($stmt, "ii", $row['ID'], $userid);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			mysqli_stmt_close($stmt);
			$user_liked = mysqli_num_rows($result);

		}

		$st = mysqli_prepare($db, "SELECT `users`.`Username` FROM `comments` INNER JOIN `posts` ON `comments`.`postID` = `posts`.`ID` INNER JOIN `users` ON `posts`.`userID` = `users`.`ID` WHERE `comments`.`ID` = ?;");
		mysqli_stmt_bind_param($st, "i", $row['ID']);
		mysqli_stmt_execute($st);
		$res = mysqli_stmt_get_result($st);
		$post_user = mysqli_fetch_assoc($res);
		mysqli_stmt_close($st);

		if($username != '0xFFFF' && htmlspecialchars($u_row['Username']) == $username)
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

		echo '
 	<div id="'.$row['ID'].'" class="post">
		<a href="/p/'.htmlspecialchars($u_row['Username']).'" style="display: inline-block; height: 42px; margin: 10px 10px 15px 10px;"><img class="profile_pic" src="'.$u_row['profilePic'].'" height="42" width="42" onerror="this.src=\'/images/avatar.png\';"></a>
		<a href="/p/'.htmlspecialchars($u_row['Username']).'" class="username_label" style="margin-top: 10px;">'.htmlspecialchars($u_row['Username']).''.($u_row['Onayli'] ? ' <p title="Onaylı Hesap" class="mavi-tik"><i class="fas fa-check-circle"></i></p>' : '').'</a> 
		<a href="/gonderi/'.$row['postID'].'&yorum='.$row['ID'].'" style="position: absolute; top: 40px;">@'.$post_user['Username'].' adlı kişiye yanıt</a>
		<p class="post_text">'.str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>',turnUrlIntoHyperlink(htmlspecialchars($row['comment']))).'</p> 
		
		'.$cmtmenu.'
		
		<p class="post_time_bot" style="margin: 5px 0 5px 5px;"><a href="/gonderi/'.$row['postID'].'&yorum='.$row['ID'].'" title="'.date("H:i · d ", $row['date']). $ay . date(" Y", $row['date']).'"><i class="far fa-clock"></i> '.time_elapsed_string('@'.$row['date']).'</a></p>
		<div class="post_bottom" style="border-top: 1px solid #A8DADC; height: 35px;">
			<div class="post_bottom3" style="width: 20px; height: 20px; float: left; margin: 10px 5px 10px 10px; font-size: 20px; cursor: pointer;" onclick="like_comment('.$row['ID'].')"><div class="btn begen"><svg viewBox="-20 -90 555 592" xmlns="http://www.w3.org/2000/svg"><path id="c_like_button_'.$row['ID'].'" style="fill: '.($user_liked ? '#ff0000' : 'transparent').'" d="m471.382812 44.578125c-26.503906-28.746094-62.871093-44.578125-102.410156-44.578125-29.554687 0-56.621094 9.34375-80.449218 27.769531-12.023438 9.300781-22.917969 20.679688-32.523438 33.960938-9.601562-13.277344-20.5-24.660157-32.527344-33.960938-23.824218-18.425781-50.890625-27.769531-80.445312-27.769531-39.539063 0-75.910156 15.832031-102.414063 44.578125-26.1875 28.410156-40.613281 67.222656-40.613281 109.292969 0 43.300781 16.136719 82.9375 50.78125 124.742187 30.992188 37.394531 75.535156 75.355469 127.117188 119.3125 17.613281 15.011719 37.578124 32.027344 58.308593 50.152344 5.476563 4.796875 12.503907 7.4375 19.792969 7.4375 7.285156 0 14.316406-2.640625 19.785156-7.429687 20.730469-18.128907 40.707032-35.152344 58.328125-50.171876 51.574219-43.949218 96.117188-81.90625 127.109375-119.304687 34.644532-41.800781 50.777344-81.4375 50.777344-124.742187 0-42.066407-14.425781-80.878907-40.617188-109.289063zm0 0"/></svg></div></div>
			<div class="post_bottom2" style="margin: 10px 0 0 5px; color: #555; font-size: 13px; float:left; line-height: 20px;">· <span id="y_begeni_sayi_'.$row['ID'].'" style="display: contents; font-size: 10pt; margin-left: 5px;">'. $like_cnt .' beğeni</span></div>
			<div style="float: right; display: flex; align-items: center; transition: all .4s;"><div style="width: 20px; height: 20px; margin: 10px; font-size: 20px; cursor: pointer;" onclick="postSecenek(0, '.$row['ID'].');"><i class="far fa-share-square"></i></div></div>
			
		</div>
	</div>';
		}
	}
}