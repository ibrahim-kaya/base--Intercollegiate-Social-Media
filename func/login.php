<!DOCTYPE html>
<html>

<?php include('../func/server.php');
include_once('../func/includes.php');
?>

<head>
    <link rel="stylesheet" type="text/css" href="/css/login.css"/>
</head>

<body id="giris">

	<?php  include('../func/headbar.php');	?>
	
	<div id="content-wrap">
	
	<?php include('../func/sidebar.php'); ?>
	

	<div class="bigdick">
		<div id="left-cont" class="lcont">
			
		</div>
			
			<div id="body-cont" class="bcont">
				<div id="form-field">
				<?php 
					if(isset($_GET['page'])){
						switch($_GET['page']) {
						case 'uyeol': 
							include 'reg-form.php';
							break;
						default: include 'login-form.php';
						}
					}
					else
					{
						include 'login-form.php';
					}
				?>
				</div>
			</div>
			
		<div id="right-cont" class="rcont">
			
		</div>
	</div>
	<?php include('../func/footer.php'); ?>
</body>

</html>