	<?php
	include_once('config.php');
	include_once('encryption.php');
    require_once('Mobile_Detect.php');

    $detect = new Mobile_Detect;
	
	login_func::checkLoginState($db);

    unset($_SESSION['reklam_gordu']);
	?>
	
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Üniversitende olan biteni takip et!">
	<meta name="keywords" content="base, universite, üniversite, olay, itiraf, kampüs, kampus">
	<meta charset="utf-8" />
	
	<script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
	

	<script src="../js/iziToast.min.js" type="text/javascript"></script>
	<script type="text/javascript">let pos = <?php echo($detect->isMobile() ? '\'bottomRight\'' : '\'topCenter\''); ?></script>
	<script src="../js/gn.js" type="text/javascript"></script>

	<?php if(isset($_SESSION['ID'])) echo '<script src="../js/notify.js" type="text/javascript"></script>'; ?>

	<link href="https://fonts.googleapis.com/css2?family=Bellota+Text&display=swap" rel="stylesheet"> 
	<link href='https://fonts.googleapis.com/css?family=Duru+Sans' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Kalam' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Cagliostro' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
	<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css2?family=Commissioner&family=Gugi&display=swap" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css2?family=Mukta+Mahee:wght@400&display=swap" rel="stylesheet"> 

	<link rel="stylesheet" type="text/css" href="/css/stil.css"/>
	
	<link rel="stylesheet" href="/css/izitoast/iziToast.min.css">
	
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" sizes="120x120" href="/images/apple-touch-icon-120x120-precomposed.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="/images/apple-touch-icon-152x152-precomposed.png" />
	
	</head>

	<noscript>

		<style>
			#content-wrap, #head-bar, #footer{
				display: none;
			}
		</style>
		

		<div style="text-align: center;">
			<div class="err-div" style="padding: 0 30px 50px 30px">
				<div id="js-hata" style="padding-top: 50px;">
					<img src="/images/javascript-kapali.png" width="192" height="192">
					<h1>JavaScript Kapalı!</h1>Tarayıcının ayarlarından <strong>javascript</strong> engellenmiş görünüyor.<br>Siteden verim alabilmek için <strong>javascript</strong>i etkinleştirmen lazım.
				</div>
			</div>
		</div>

	</noscript>
	
	<body><div id="not"></div></body>