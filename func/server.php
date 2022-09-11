<?php
include_once('../func/config.php');
include_once('../func/fonksiyonlar.php');

if(isset($_SESSION['ID'])) header('location: /anasayfa');

function checkEmail($email) {
    $find1 = strpos($email, '@');
    $find2 = strpos($email, '.');
    return ($find1 !== false && $find2 !== false && $find2 > $find1);
}

// initializing variables
$username = "";
$email    = "";
if(!isset($_SESSION['errors'])) $_SESSION['errors'] = array();
if(!isset($_SESSION['msgs'])) $_SESSION['msgs'] = array();

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, trim($_POST['username']));
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $_SESSION['errors'] array
  if (empty($username)) { array_push($_SESSION['errors'], "Username is required"); }
  if (empty($email)) { array_push($_SESSION['errors'], "Email is required"); }
  if (empty($password_1)) { array_push($_SESSION['errors'], "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($_SESSION['errors'], "Şifreler uyuşmuyor. Bi' kontrol et istersen.");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE Username='$username' OR EMail='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  
  
  $stmt = mysqli_prepare($db, "SELECT * FROM users WHERE Username=? OR EMail=? LIMIT 1;");
  mysqli_stmt_bind_param($stmt, "ss", $username, $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);
  
  
  if ($user) { // if user exists
    if (!strcasecmp($user['Username'], $username)) {
      array_push($_SESSION['errors'], "Bu kullanıcı adını kapmışlar. Başka seçmen lazım.");
    }

    else if (!strcasecmp($user['EMail'], $email)) {
      array_push($_SESSION['errors'], "Bu E-Mail zaten kayıtlı. Şifreni mi unuttun?");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($_SESSION['errors']) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database
	$var_time = time();
	$st = mysqli_prepare($db, "INSERT INTO users (Username, EMail, Password, kayitTarihi) 
  			  VALUES(?, ?, ?, ?);");
	mysqli_stmt_bind_param($st, "sssi", $username, $email, $password, $var_time);
	mysqli_stmt_execute($st);
	mysqli_stmt_close($st);

      $lastid = $db->insert_id;

      if ($stmt = mysqli_prepare($db, "SELECT * FROM users WHERE ID=?;")) {
          mysqli_stmt_bind_param($stmt, "i", $lastid);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);

          $l_row = mysqli_fetch_assoc($result);
          if (mysqli_num_rows($result)) {
              login_func::createRecord($db, $l_row['ID']);
              login_func::createSession($l_row);
              fonksiyonlar::log_kayit($db, 1, $l_row['ID'], "Kayıt oldu.");
              $_SESSION['mail_isim'] = $username;
              $_SESSION['mail_adres'] = $email;

              header("location: /hosgeldin");
          }
      }
  }
  
  
}


// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($_SESSION['errors'], "Kullanıcı adı ya da e-mail girmeden olmaz!");
  }
  if (empty($password)) {
  	array_push($_SESSION['errors'], "Bi' de şifre yazman lazım.");
  }

  if (count($_SESSION['errors']) == 0) {
  	$password = md5($password);
  	$qstr = "SELECT * FROM users WHERE ".(checkEmail($username) ? "EMail" : "Username")."=? AND Password=?;";

	if ($stmt = mysqli_prepare($db, $qstr)) {
		mysqli_stmt_bind_param($stmt, "ss", $username, $password);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$l_row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) == 1) {
			
			login_func::createRecord($db, $l_row['ID']);
			login_func::createSession($l_row);
            fonksiyonlar::log_kayit($db, 0, $l_row['ID'], "Giriş yaptı.");
			/*$_SESSION['uname'] = $l_row['Username'];
			$_SESSION['ID'] = $l_row['ID'];
			$_SESSION['profilePic'] = $l_row['profilePic'];
			$_SESSION['last_notify_id'] = 0;
			$_SESSION['success'] = "You are now logged in";*/

			header('location: /anasayfa');
		}else {
			array_push($_SESSION['errors'], "Kullanıcı adıyla şifre uyuşmuyor?");
		}
		mysqli_stmt_close($stmt);
	}
  }
}
?>