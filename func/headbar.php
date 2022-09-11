	<div id="head-bar" class="headbar">
	<?php
	if(!isset($_SESSION['ID'])){
	?>
		<div style="position: absolute; left: 50%;"><div style="position: relative; left: -50%;"><div class="header-logo" onclick="window.location.href='/anasayfa'"></div></div></div>
		<div class="wrapper" style="display:flex; justify-content:space-between;">
		<div id="av" onclick="openSlideMenu()"><i id="ac" class="fas fa-bars"></i></div>
		<div style="background-color: #DA1B2B; display: flex; justify-content: center; align-items: center; height: 60px; z-index: 1;"><a class="login-sec" href="/turnike"><i class="fas fa-user"></i></a></div>
		</div>
		
		
		
	<?php } else { ?>	
	<div style="position: absolute; left: 50%;"><div style="position: relative; left: -50%;"><div class="header-logo" onclick="window.location.href='/anasayfa'"></div></div></div>
	<div class="wrapper" style="display:flex; justify-content:space-between;">
		<div id="av" class="upper_avatar" onclick="openSlideMenu()">
			<div class="avatar1"><img src="<?php echo $_SESSION['profilePic']; ?>" height="42" width="42" onerror="this.src='/images/avatar.png';" style="background-color: #C5E7E8;"></div>
			<div class="nick1"><?php echo $_SESSION['uname']; ?></div>
		</div>
		<div class = "hb_icons_cont">
		<div class = "bildirimler_div">
		<div id="arama-kutusu" style="transition: all .8s; width: 0px; overflow: hidden; white-space: nowrap;">
			<form action="/ara" method="get">
				<input required class="ara-tb header-sb" style="width: 170px;" type="text" name="s" placeholder="Ne arayalım?" />
				<button class="ara-btn header-sb-btn" type="submit">Bul Getir</button>
			</form>
		</div>
		<span class = "bildirimler_btn" onclick="toggleSearchBox();" title="Ara"><i class="fas fa-search"></i></span></div>
		<div class = "bar-msg_div"><span class = "bildirimler_btn" title="Mesaj Kutusu"><i class="fas fa-inbox"></i></span></div>
		<div class = "bildirimler_div" onclick="toggleNotifi();" title="Bildirimler"><span class="bildirim_sayi"></span><span class = "bildirimler_btn"><i class="fas fa-bell"></i></span></div>
		</div>
		<div class="notifi-box" id="box" data-simplebar>
			<h2>Bildirimler</h2>
			<span id="bildirimleri-sil" style="color: #457B9D; font-size: 10pt; float: right; margin-top: -23px; margin-right: 10px; text-decoration: none; cursor: pointer;">Tümünü sil</span>
			<div id="notifi-icerik"><p style="color: #666; font-style: italic; text-align: center;">(Bildiriminiz yok)</p></div>
		</div>
	</div>
	<?php } ?>
	</div>
	
	<script src="../js/open-notify.js" type="text/javascript"></script>
	