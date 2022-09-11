<?php
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) { header('location: /'); return; }
include_once('../func/config.php');

$postid = $_POST['gonderi'];

if ($stmt = mysqli_prepare($db, "SELECT * FROM `users` INNER JOIN `post_likes` ON `users`.`ID` = `post_likes`.`userID` WHERE `postID` = ?;")) {
	mysqli_stmt_bind_param($stmt, "i", $postid);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);


	if(!mysqli_num_rows($result))
	{
		echo '<div class="no_post" style="text-align: center; margin: 10px; font-size: 13px; color: 555;"><i class="no_com_text" style="color: #888">Bunu kimse beğenmemiş.</i></div>';
	}
	else
	{
		$str='';
		while($row = mysqli_fetch_array($result))
		{
			$str = $str.'
			<style>
				.begeni_isim_bg {
					padding-left: 20px; 
					background-color: #E8F6FF; 
					transition: all .4s;
				}
				
				.begeni_isim_bg:hover {
					background-color: #C2E8FF; 
				}
			</style>
			
			<a href="/p/'.htmlspecialchars($row['Username']).'"><div class="begeni_isim_bg">
			<img class="profile_pic" src="'.$row['profilePic'].'" height="42" width="42" onerror="this.src=\'/images/avatar.png\';" style="display: inline-block; height: 42px; margin: 10px;">
			<span class="username_label" style="text-decoration: none;">'.htmlspecialchars($row['Username']).''.($row['Onayli'] ? ' <p class="mavi-tik"><i class="fas fa-check-circle"></i></p>' : '').'</span> 
			</div></a>
			';
		}
		echo $str;
	}
	
	mysqli_stmt_close($stmt);
}
 ?>