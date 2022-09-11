<?php include_once('encryption.php');
include_once('fonksiyonlar.php');

	class login_func
	{
		public static function checkLoginState($dbh)
		{
			if(!isset($_SESSION))
			{
				session_start();
			}
			
			if(isset($_COOKIE['UIF']) && isset($_COOKIE['token']) && isset($_COOKIE['serial']))
			{
				$decryptedID = DecryptThis($_COOKIE['UIF']);
				if(!$decryptedID) $decryptedID = 0;

				$userid = $decryptedID;
				$token = $_COOKIE['token'];
				$serial = $_COOKIE['serial'];
				
				if ($stmt = mysqli_prepare($dbh, "SELECT user_sessions.*, users.* FROM user_sessions INNER JOIN users ON users.ID = user_sessions.session_userid WHERE session_userid=? AND session_token=? AND session_serial=?;")) {
					mysqli_stmt_bind_param($stmt, "iss", $userid, $token, $serial);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					
					if($result->num_rows)
					{
						if(!isset($_SESSION['ID']))
						{
							$row = mysqli_fetch_assoc($result);
							
							if($row['session_userid'] > 0)
							{
								$decryptedID = DecryptThis($_COOKIE['UIF']);
								if(!$decryptedID) $decryptedID = 0;
								
								if (
									$row['session_userid'] == $decryptedID &&
									$row['session_token'] == $_COOKIE['token'] &&
									$row['session_serial'] == $_COOKIE['serial']
								)
								{
									login_func::createSession($row);
									fonksiyonlar::log_kayit($dbh, 0, $decryptedID, "Otomatik giriş yaptı.");
									return true;
								}
							}
						}
					}
					else
					{
						if(isset($_SESSION['ID']))
						{
							header("location: /action?act=kick");
						}
					}
					mysqli_stmt_close($stmt);
				}
			}
		}
		
		public static function createRecord($dbh, $u_userid)
		{
			$token = login_func::createString(32);
			$serial = login_func::createString(32);
			$zaman = time();
			
			if ($stmt = mysqli_prepare($dbh, "DELETE FROM `user_sessions` WHERE session_userid=?;")) {
				mysqli_stmt_bind_param($stmt, "i", $u_userid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if ($stmt = mysqli_prepare($dbh, "INSERT INTO `user_sessions`(`session_userid`, `session_token`, `session_serial`, `session_date`) VALUES (?,?,?,?);")) {
				mysqli_stmt_bind_param($stmt, "issi", $u_userid, $token, $serial, $zaman);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}

			login_func::createCookie($u_userid, $token, $serial);
		}
		
		public static function createCookie($u_userid, $token, $serial)
		{
			$encryptedID = EncryptThis($u_userid);

			setcookie('UIF', $encryptedID, time() + (86400) * 30, "/");
			setcookie('token', $token, time() + (86400) * 30, "/");
			setcookie('serial', $serial, time() + (86400) * 30, "/");
		}
		
		public static function deleteCookies()
		{
			setcookie('UIF', '', time() - 1, "/");
			setcookie('token', '', time() - 1, "/");
			setcookie('serial', '', time() - 1, "/");
		}
		
		public static function createSession(&$row)
		{
			if(!isset($_SESSION))
			{
				session_start();
			}
			$_SESSION['uname'] = $row['Username'];
			$_SESSION['umail'] = $row['EMail'];
			$_SESSION['ID'] = $row['ID'];
			$_SESSION['Uni'] = $row['Uni'];
			$_SESSION['profilePic'] = $row['profilePic'];
			$_SESSION['coverPic'] = $row['coverPic'];
			$_SESSION['last_notify_id'] = 0;
		}
		
		public static function createString($len)
		{
			$string = "IequFsuSFHqA77xwxxMjjDlQ6FC80VHTNpvkYoUQca9nZWen4xay8Qiloveu1tkn";
			return substr(str_shuffle($string), 0, $len);
		}
	}
