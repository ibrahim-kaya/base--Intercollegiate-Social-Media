<?php 
include_once('../func/config.php');

if(!isset($_POST['editID'])) 
	header("location: /anasayfa");

if($_POST['editID'] == 1){
	if(!isset($_POST['uni'])) 
		header("location: /anasayfa");

	$uniid = $_POST["uni"];
	
	if($uniid != 0) {
		$result = mysqli_query($db, "SELECT * FROM categories WHERE ID = $uniid");

	if (!$result)
		header("location: /anasayfa");
	}
	
	if(!isset($_SESSION['ID']))
		header("location: /anasayfa");
	$uid = $_SESSION['ID'];
	$uname = $_SESSION['uname'];
	
  	$sonuc = mysqli_query($db, "UPDATE users SET Uni=$uniid WHERE ID=$uid");
	header("location: /profil/$uname");
}
else if($_POST['editID'] == 2){
	if(!isset($_POST['val1']) or !isset($_POST['val2']) or !isset($_POST['val3'])) return;
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
	$ay = $aylar[$_POST['val2'] - 1];
	$dtStr = $_POST['val1'].' '. $ay .' '. $_POST['val3'];
	$uid = $_SESSION['ID'];
	
  	$sonuc = mysqli_query($db, "UPDATE usesrs SET dogumTarihi='$dtStr' WHERE ID=$uid");
	if ($sonuc)
		echo 'succ';
		else {
		array_push($_SESSION['errors'], "Başaramadık. Bir sorun oluştu."); 
		echo 'err';
		}
}
?>