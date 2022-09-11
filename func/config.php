<?php
if (! isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] == 'off' ) {
    $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirect_url");
    exit();
}

include_once('login_func.php');


if(!$db = mysqli_connect('localhost', 'root', '', 'base_db')){
	header('Location: /baglanamadik');
}
$db->set_charset('utf8mb4');
// Check connection
if (!$db) {
 die("Connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION))
{
	session_start();
}