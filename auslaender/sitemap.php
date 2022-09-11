<?php
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');
date_default_timezone_set('Europe/Istanbul');
define('slash','/');
define('m','monthly');
define('a','always');
define('w','weekly');
define('d','daily');
$url = 'http://'.$_SERVER['HTTP_HOST'];
include_once 'sitemap.class.php';
$sitemap = new sitemap;
$sitemap->head();
$sitemap->feed($url,m);

$query = "SELECT * FROM posts ORDER BY ID";
if ($result = mysqli_query($sitemap->conn(), $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$link = $url.slash.'gonderi'.slash.sitemap::clean($row['ID']);
		sitemap::feed($link,a);
	}
	mysqli_free_result($result);
}
$pages = '/about-us,/contact-us,/privacy-policy';
sitemap::pages($pages);
$sitemap->foot();
$sitemap->close();
?>


 
 
 