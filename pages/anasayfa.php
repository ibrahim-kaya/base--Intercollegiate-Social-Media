<!DOCTYPE html>
<html lang="tr">

<?php
	include_once('../func/config.php');
	include_once('../func/includes.php');
	
	if(!isset($_SESSION['ID'])) { header('location: /'); return; }
	if(!isset($_SESSION['profilePic'])) {$_SESSION['profilePic'] = '';}
?>

<head>
	<title>Base ~ Anasayfa</title>
</head>

<body id="anasayfa">
	<div id="myModal" class="modal">
	<!-- Modal content -->
	  <div id="modalid" class="modal-content">
		<div id="m_kapat" class="modal_kapat"></div>
		<div id="c_area" class="index_area"></div>
	  </div>

	</div>
	
	<?php  include('../func/headbar.php');	?>
	
	<div id="content-wrap">
	
	<?php include('../func/sidebar.php'); ?>

	<div id="headerbar" class="header"></div>

	<div class="bigdick">
		
		<div id="left-cont" class="lcont">
            <?php include('../pages/sol_panel.php'); ?>
		</div>
			
			
		<div id="body-cont" class="bcont">
			<p class="flow_header" style="margin-left: 10px; font-family: 'Kalam'; font-size: 25px;">Olaylar Olaylar</p>
			<div class="post_area">
				<div id="load_data"></div>
				<div id="load_data_message"></div>
			</div>
		</div>
			
		<div id="right-cont" class="rcont">
			<?php include('../func/trending.php') ?>
		</div>
	</div>	
	<div class="push"></div>
</div>
	<?php include('../func/footer.php'); ?>

	<script src="../js/post-func.js" type="text/javascript"></script>
    <script src="../js/post-js.js" type="text/javascript"></script>

	<script>

		$(document).ready(function(){
		 post_load("<?php echo EncryptThis('SELECT a.* FROM posts a WHERE (EXISTS (SELECT NULL FROM abonelikler b WHERE b.uniID = a.postCategory and b.userID='.$_SESSION['ID'].') or a.userID = '.$_SESSION['ID'].') and a.silindi = 0'); ?>");
		});

	</script>
</body>

</html>