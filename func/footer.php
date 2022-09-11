<script src="../js/genel-alt.js" type="text/javascript"></script>

<div class="mobile_navigasyon" style="<?php if(!isset($_SESSION['ID'])) { echo 'display: none;'; } ?>">
	<div class="mobile_home_btn" onclick="mobileNavigator(0);"><i class="fas fa-home"></i></div>
	<div class="mobile_ara_btn" onclick="mobileNavigator(1);"><i class="fas fa-search"></i></div>
	<div class="mobile_uni_btn" onclick="mobileNavigator(2);"><i class="fas fa-graduation-cap"></i></div>
	<div class="mobile_bildirim_btn" onclick="mobileNavigator(3);"><span class="bildirim_sayi">5</span><div id="bildirim_ico"><i class="fas fa-bell"></i></div></div>
	<div class="mobile_profil_btn" onclick="mobileNavigator(4);"><i class="fas fa-user"></i></div>
</div>

<script>
	function mobileNavigator(val)
	{
		switch(val)
		{
			case 0: window.location.href='/'; break;
			case 1: window.location.href='/ara'; break;
			case 3: toggleNotifi(); break;
			case 4: window.location.href = "/p/<?php if(isset($_SESSION['ID'])) echo $_SESSION['uname']; ?>"; break;
		}
	}
</script>

<footer id="footer">
<p style="font-size: 13px;"><a href="#">Gizlilik Politikası</a> · <a href="#">Kullanım Şartları</a> · <a href="#">Yardım</a> · <a href="#">İletişim</a></p>
<p style="font-size: 13px;"><a href="#">Twitter</a> · <a href="#">Instagram</a> · <a href="#">Facebook</a></p>
<p style="font-size: 13px;">Copyright 2020© <a href="#">base.com</a> · Tüm hakları saklıdır.</p>
</footer>