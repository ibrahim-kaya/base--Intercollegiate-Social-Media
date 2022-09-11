<?php
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) { header('location: /'); return; }

include_once('../func/config.php');
include_once('../func/fonksiyonlar.php');

if(!isset($_POST['birisi'])) return;
if(!isset($_SESSION['ID'])) return;

$userid = $_SESSION['ID'];

if(!$_POST['birisi'])
{	
	$stmt = mysqli_prepare($db, "UPDATE `users` SET `Uni` = 0 WHERE `ID` = ?;");
	mysqli_stmt_bind_param($stmt, "i", $userid);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
    fonksiyonlar::log_kayit($db, 5, $_SESSION['ID'], "Üniversite bilgisini kaldırdı.");
    $_SESSION['Uni'] = 0;
    array_push($_SESSION['msgs'], "Üniversite bilgini kaldırdın!");
}
else
{
	$st = mysqli_prepare($db, "UPDATE `users` SET `dogumTarihi` = 0 WHERE `ID` = ?;");
	mysqli_stmt_bind_param($st, "i", $userid);
	mysqli_stmt_execute($st);
	mysqli_stmt_close($st);
    fonksiyonlar::log_kayit($db, 5, $_SESSION['ID'], "Doğum tarihi bilgisini kaldırdı.");
    array_push($_SESSION['msgs'], "Doğum tarihi bilgini kaldırdın!");
}


?>