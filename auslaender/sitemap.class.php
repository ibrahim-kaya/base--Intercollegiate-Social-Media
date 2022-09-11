<?php
class sitemap
{
	public $conn;
	public function __construct()
	{
		if(!$this->conn())
		{
			die('Failed to connect with MySQL');
			self::close();
		}
	}

	public function conn()
	{
		$host = "localhost";
		$user = "root";
		$pass = "";
		$name = "base_db";
		$conn = mysqli_connect($host,$user,$pass,$name);
		if (mysqli_connect_errno())
		{
		die("Failed to connect with MySQL: ".mysqli_connect_error());
		}
		else
		{
		return $this->conn = $conn;
		}


	}
	public function head()
	{
		echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
	}
	public function feed($url,$freq)
	{
		echo '
		<url>
		<loc>'.$url.'</loc>
		<changefreq>'.$freq.'</changefreq>
		</url>
		';
	}
	public function foot()
	{
		echo '</urlset>';
	}
	public function clean($string) {
	   $string = strtolower( preg_replace('@[\W_]+@', '-', $string) );
	   $string = rtrim($string,'-');
	   $string = strtolower($string);
	   return $string;
	}
	public function pages($pages)
	{
		$allpage = explode(',',$pages);
		foreach ($allpage as $page)
		{
			$link = 'http://'.$_SERVER['HTTP_HOST'].$page;
			self::feed($link,'monthly');
		}
	}
	public function close()
	{
		mysqli_close(self::conn());
	}
}

?>