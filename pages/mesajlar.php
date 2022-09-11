<!DOCTYPE html>
<html>

<?php
	include_once('../func/config.php');
	include_once('../func/includes.php');
?>


<head>
	<title>Base ~ Ara</title>
</head>

<body>

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
		
		<div class="ara-cont">
			<form action="" method="get">
				<input required class="ara-tb tb-width" style="color: #000;" type="text" name="s" placeholder="Ne arayalım?" />
				<input class="ara-btn" style="margin-left: 10px;" type="submit" value="Bul Getir" />
			</form>
		</div>
		
		<div class="post_area">
			<p class="flow_header" style="margin-left: 10px; font-family: 'Kalam'; font-size: 25px;">"<?php echo $searchq; ?>" ile ilgili bunları bulduk:</p>
			<div id="load_data"><?php if(!isset($output)) echo 'Bulamadık bi\' şey'; ?></div>
			<div id="load_data_message"></div>
		</div>
		</div>
			
		<div id="right-cont" class="rcont">

		</div>
	</div>

	<?php if(isset($output)) echo $output; ?>
	
	<div class="push"></div>
</div>
	<?php include('../func/footer.php'); ?>
</body>

</html>