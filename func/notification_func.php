<?php
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) { header('location: /'); return; }
include_once('../func/config.php');
require_once "../func/Mobile_Detect.php";

if(!isset($_POST['act'])) return;
if(!isset($_SESSION['ID'])) return;

$detect = new Mobile_Detect;

$type = $_POST['act'];
$uid = $_SESSION['ID'];


if($type == 0) // kontol
{
	if ($stmt = mysqli_prepare($db, "SELECT bildirimler.*, users.profilePic, users.Username FROM bildirimler INNER JOIN users ON bildirimler.noti_userID=users.ID WHERE bildirimler.userID=? and bildirimler.goruldu=0;")) {
		mysqli_stmt_bind_param($stmt, "i", $uid);
		mysqli_stmt_execute($stmt);
		$query = mysqli_stmt_get_result($stmt);
		
		$lastid = '';
		$nots = '';
		while($row = mysqli_fetch_array($query))
		{ 
			if($row['n_id'] > $_SESSION['last_notify_id'])
			{
				$nots = $nots.'			
					<script>
					showNot(\''.$row['icerik'].'\');
					function showNot(txt)
					{
						var ico = ["/images/like.svg", "/images/comment.svg", "/images/follow.svg"];
						var pos = "'.($detect->isMobile() ? 'bottomCenter' : 'topRight').'";

						iziToast.show({
							title: "'.$row['Username'].'",
							message: txt,
							theme: "dark",
							image: "'.$row['profilePic'].'",
							iconUrl: ico['.$row['type'].'],
							iconColor: "#FFFFFF",
							layout: 2,
							position: pos,
							timeout: 10000
						});
					}
					</script>';
			}

			$lastid = $row['n_id']; 
		}

		$islast = ($lastid == $_SESSION['last_notify_id']) ? '1' : '0';
		$_SESSION['last_notify_id'] = $lastid;
		
		$st = mysqli_prepare($db, "UPDATE `bildirimler` SET `goruldu` = 1 WHERE `userID` = ?;");
		mysqli_stmt_bind_param($st, "i", $uid);
		mysqli_stmt_execute($st);
		mysqli_stmt_close($st);
		
		echo $nots;
		mysqli_stmt_close($stmt);
	}
}
else if($type == 1) // yenile
{
	date_default_timezone_set('Europe/Istanbul');

	function convert_time($datetime, $full = false) {
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
			 
		$ay = $aylar[date('m') - 1];

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

	if ($stmt = mysqli_prepare($db, "SELECT bildirimler.*, users.profilePic, users.Username FROM bildirimler INNER JOIN users ON bildirimler.noti_userID = users.ID WHERE bildirimler.userID=? ORDER BY n_id DESC;")) {
		mysqli_stmt_bind_param($stmt, "i", $uid);
		mysqli_stmt_execute($stmt);
		$query = mysqli_stmt_get_result($stmt);
	
		$nots = '';
		$new_nots = 0;
		while($row = mysqli_fetch_array($query))
		{ 
			$ico = array('<i style="color: red;" class="fas fa-heart"></i>', '<i style="color: #2881B8;" class="fas fa-comment"></i>', '<i style="color: #28B851;" class="fas fa-user-plus"></i>');
			$nots = $nots.'			
				<div class="notifi-delete" onclick="bildirimSil('.$row['n_id'].')">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="18px" height="18px"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
				</div>	
				<div class="not" style="overflow: hidden; transition: transform 0.4s ease;">
				<a href="'.($row["type"] == 2 ? "/p/".$row["Username"] : $row["link"]).'" id="n_'.$row['n_id'].'"><div class="notifi-item'.($row['okundu'] ? '' : ' notify-new').'">
					<img src="'.$row['profilePic'].'" onerror="this.src=\'/images/avatar.png\';" alt="img">
					<div class="text">
					   <h4>'.$row['Username'].'</h4>
					   <p>'.$ico[$row['type']].' '.$row['icerik'].' · '.convert_time('@'.$row['tarih']).'</p>
					</div>  
				</div></a></div>';
			if(!$row['okundu'])
			{
				$new_nots++;
			}
		}
		echo $new_nots.'|'.$nots;
		mysqli_stmt_close($stmt);
	}
}
else if($type == 2) // okundu işaretle
{
	if ($st = mysqli_prepare($db, "UPDATE `bildirimler` SET `okundu` = 1 WHERE `userID` = ?;")){
		mysqli_stmt_bind_param($st, "i", $uid);
		mysqli_stmt_execute($st);
		mysqli_stmt_close($st);
	}
}

else if($type == 3) // bildirim sil
{
    $stmt = mysqli_prepare($db, "SELECT * FROM bildirimler WHERE n_id=?;");
    mysqli_stmt_bind_param($stmt, "i", $_POST['noti_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $notidata = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if($notidata['userID'] != $_SESSION['ID']){
        echo "basarisiz";
    }
    else
    {
        $stmt = mysqli_prepare($db, "DELETE FROM bildirimler WHERE n_id=?;");
        mysqli_stmt_bind_param($stmt, "i", $_POST['noti_id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "basarili";
    }
}

else if($type == 4) // tüm bildirimleri sil
{
    if(!isset($_SESSION['ID']))
    {
        echo 'basarisiz';
    }
    $stmt = mysqli_prepare($db, "DELETE FROM bildirimler WHERE userID=?;");
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "basarili";
}