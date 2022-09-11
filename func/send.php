<?php
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) { header('location: /'); return; }
include_once('../func/config.php');
include_once('../func/fonksiyonlar.php');

if(isset($_SESSION))
{
    if(!isset($_SESSION['errors'])) $_SESSION['errors'] = array();
    if(!isset($_SESSION['msgs'])) $_SESSION['msgs'] = array();
}

if(!isset($_POST['from']))
{
	header("location: /anasayfa");
}

	function getIP($ip = null, $deep_detect = TRUE){
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		} else {
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		return $ip;
	}


	$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=".getIP()));
	$loc = $geo["geoplugin_city"].', '.$geo["geoplugin_countryName"];

	
	
if ($_POST['from'] == "uni") {
	$p_userid = @$_SESSION['ID'];
	$p_text = mysqli_real_escape_string($db, $_POST['entry']);
	$uni_id = $_POST['uni_id'];
	if(!isset($p_userid)){
		array_push($_SESSION['errors'], "Giriş yapmamışsın!");
	}
	if (empty($p_text)) { array_push($_SESSION['errors'], "Bir şey yazmamışsın?"); }
	
	if (count($_SESSION['errors']) == 0) {		
		$var_time = time();
		$var_ip = getIP();
		
		if ($stmt = mysqli_prepare($db, "INSERT INTO posts (userID, post, postTime, postCategory, IP, device, location) 
				  VALUES(?, ?, ?, ?, ?, ?, ?);")) {
			mysqli_stmt_bind_param($stmt, "isiisss", $p_userid, $p_text, $var_time, $uni_id, $var_ip, $_SERVER['HTTP_USER_AGENT'], $loc);
			if(mysqli_stmt_execute($stmt))
			{
                $lastid = $stmt->insert_id;
                fonksiyonlar::log_kayit($db, 2, $_SESSION['ID'], "Gönderi paylaştı. (ID: ".$lastid.")");
				echo 'succ';
			}
			else
			{
				array_push($_SESSION['errors'], "Gönderi gönderilemedi!");
				echo 'err';
			}
			mysqli_stmt_close($stmt);
		}
	}
	else
	{
	echo 'err';
	}
} 
else if ($_POST['from'] == "comment") 
{
	$str = '';
	$p_userid = @$_SESSION['ID'];
	$var_time = time();
	$p_text = mysqli_real_escape_string($db, $_POST['entry']);
	if(!isset($p_userid)){
	array_push($_SESSION['errors'], "Giriş yapmamışsın!");
	}
	if (empty($p_text)) { array_push($_SESSION['errors'], "Bir şey yazmamışsın?"); }
		
	if (count($_SESSION['errors']) == 0) 
	{
		$var_time = time();
		$var_ip = getIP();
        $last_id = 0;
		
		if ($stmt = mysqli_prepare($db, "INSERT INTO comments (postID, userID, comment, date, IP, device, location) 
				  VALUES(?, ?, ?, ?, ?, ?, ?);")) {
			mysqli_stmt_bind_param($stmt, "iisisss", $_POST['post_id'], $p_userid, $p_text, $var_time, $var_ip, $_SERVER['HTTP_USER_AGENT'], $loc);
			if(mysqli_stmt_execute($stmt))
			{			
				$st = mysqli_prepare($db, "SELECT * FROM comments WHERE postID=?");
				mysqli_stmt_bind_param($st, "i", $_POST['post_id']);
				mysqli_stmt_execute($st);
				$result = mysqli_stmt_get_result($st);
                $last_id = $stmt->insert_id;
				echo mysqli_num_rows($result);
				mysqli_stmt_close($st);
                fonksiyonlar::log_kayit($db, 3, $_SESSION['ID'], "Yorum yaptı. (ID: ".$last_id.")");
			}
			else
			{
				array_push($_SESSION['errors'], "Gönderi gönderilemedi!");
				echo 'err';
			}
			mysqli_stmt_close($stmt);

            $stm = mysqli_prepare($db, "SELECT * FROM posts WHERE ID=?;");
            mysqli_stmt_bind_param($stm, "i", $_POST['post_id']);
            mysqli_stmt_execute($stm);
            $res = mysqli_stmt_get_result($stm);
            $postdata = mysqli_fetch_assoc($res);
            mysqli_stmt_close($stm);

            $clink = "/gonderi/".$postdata['ID']."&yorum=".$last_id;

            $stm = mysqli_prepare($db, "INSERT INTO `bildirimler`(`userID`, `noti_userID`, `type`, `icerik`, `link`, `tarih`) VALUES (?, ?, '1', ' Gönderine yorum yaptı.', ?, ?);");
            mysqli_stmt_bind_param($stm, "iisi", $postdata['userID'], $_SESSION['ID'], $clink, $var_time);
            mysqli_stmt_execute($stm);
            mysqli_stmt_close($stm);
			
		}
	}
	else
	{
		echo 'err';
	}
	
}
