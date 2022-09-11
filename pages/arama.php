<!DOCTYPE html>
<html>

<?php
include_once('../func/config.php');
include_once('../func/includes.php');


if(isset($_GET['s'])){
    if($_GET['s']){


        $searchq = htmlspecialchars($_GET['s']);
        $searchq = mysqli_real_escape_string($db, $searchq);
        $param = "%{$searchq}%";
        $stmt = mysqli_prepare($db, "SELECT * FROM posts WHERE post LIKE ?;");
        mysqli_stmt_bind_param($stmt, "s", $param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $found = mysqli_num_rows($result);
        mysqli_stmt_close($stmt);

        if($found) {
            $output = '
		<script>
            $(document).ready(function(){
             post_load("'.EncryptThis('SELECT * FROM posts WHERE post LIKE "'.$param.'"').'");
            });
		</script>';
        }
    }
    else
    {
        unset($_GET);
    }
}
?>


<head>
	<title>Base ~ Ara</title>

    <script src="../js/post-func.js" type="text/javascript"></script>
</head>

<body id="arama">

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
                <div style="display: flex; margin: 0 10px; align-items: center;">
                    <input required class="ara-tb tb-width" style="color: #000;" type="text" name="s" placeholder="Ne arayalım?" <?php echo (isset($_GET['s']) ? 'value="'.$_GET['s'].'"' : '') ?>/>
                    <button class="ara-btn" style="margin-left: 10px;" type="submit" >Bul Getir</button>
                </div>
			</form>
		</div>
		
		<div class="post_area">
            <?php if(isset($_GET['s'])) { ?>
			<p class="flow_header" style="margin-left: 10px; font-family: 'Kalam'; font-size: 25px;">"<?php echo $searchq; ?>" ile ilgili bunları bulduk:</p>
			<div id="load_data"><?php if(!isset($output)) echo 'Bulamadık bi\' şey'; ?></div>
			<div id="load_data_message"></div>
            <?php } ?>
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