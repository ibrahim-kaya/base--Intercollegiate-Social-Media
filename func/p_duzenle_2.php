<p class="flow_header" style="margin-left: 10px; font-family: 'Kalam'; font-size: 25px;">Hesap Ayarları</p>

<p class="set-field-header">Kullanıcı Adın:</p>
<div class="set-field-cont">
	<input class="pass-input" type="text" value="<?php echo $userinf['Username']; ?>" disabled>
</div>

<p class="set-field-header">E-Postan:</p>
<div class="set-field-cont">
	<input class="pass-input" type="text" value="<?php echo $userinf['EMail']; ?>" disabled>
</div>

<p class="set-field-header">Şifreni Değiştir:</p>
<div class="set-field-cont">
	<div>
		<form id="sifre_form" action="" method="post">
			<input class="pass-input" placeholder="Eski Şifre" name="eskiSifre" type="password">
			<input class="pass-input" placeholder="Yeni Şifre" name="yeniSifre" type="password">
			<input class="pass-input" placeholder="Yeni Şifre (bi' daha) "name="yeniSifreTk" type="password">
			<button class="ara-btn" style="background-color: #5CC1FF; float: right; padding: 0 10px;" type="submit" name="pass_gonder">Değiştir</button>
		</form>
	</div>
</div>

<p class="set-field-header">Zaman Dilimi:</p>
<div class="set-field-cont">
	<select name="uni" class="select-css">
		<option value="0">Zaman dilimi seç:</option>
		<option value="Europe/Istanbul">Avrupa/Istanbul</option>
		<option value="Europe/Oslo">Avrupa/Oslo</option>
	</select>
	<div style="width: 100%;"></div>
	<p style="margin: 5px 0 0 5px; font-size: 9pt; color: #666;">(Mevcut: <b>Avrupa/Istanbul</b>)</p>
</div>