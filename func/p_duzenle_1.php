<?php 
/*if(isset($_POST['uni'])) echo $_POST['uni']; 
if(isset($_POST['DogumTarihi'])) echo $_POST['DogumTarihi']; */
if(isset($_POST['dt_gonder'])) 
{	
	if($_POST['DogumTarihi'])
	{
		$d_tarihi = datetoStr('@'.strtotime($_POST['DogumTarihi']));
		$stmt = mysqli_prepare($db, "UPDATE `users` SET `dogumTarihi`=? WHERE `ID`=?;");
		mysqli_stmt_bind_param($stmt, "si", $d_tarihi, $userid);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
        fonksiyonlar::log_kayit($db, 5, $_SESSION['ID'], "Doğum tarihini değiştirdi. (Yeni tarih: ".$d_tarihi.")");
        array_push($_SESSION['msgs'], "Doğum tarihi bilgin başarıyla güncellendi!");
		echo '<script>window.location.href = window.location.href;</script>';
	}
}	

if(isset($_POST['uni_gonder'])) 
{	
	if($_POST['uni'] && is_numeric($_POST['uni']))
	{
		while($row = mysqli_fetch_assoc($unires))
		{
			if($row['ID'] == $_POST['uni'])
			{
				$stmt = mysqli_prepare($db, "UPDATE `users` SET `Uni`=? WHERE `ID`=?;");
				mysqli_stmt_bind_param($stmt, "ii", $_POST['uni'], $userid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
                fonksiyonlar::log_kayit($db, 5, $_SESSION['ID'], "Üniversitesini değiştidi. (Eski ID: ".$_SESSION['Uni'].", Yeni ID:".$_POST['uni'].")");
                $_SESSION['Uni'] = $_POST['uni'];
                array_push($_SESSION['msgs'], "Üniversite bilgin başarıyla güncellendi!");
				break;
			}
		}
		echo '<script>window.location.href = window.location.href;</script>';
	}
}

function datetoStr($datetime) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
	
	$aylar = array(
		'Oca',
		'Şub',
		'Mar',
		'Nis',
		'May',
		'Haz',
		'Tem',
		'Ağu',
		'Eyl',
		'Eki',
		'Kas',
		'Ara'
	);
		 
	$ay = $aylar[date('m', $ago->getTimestamp()) - 1];


	$res = date("d ", $ago->getTimestamp()). $ay . date(" Y", $ago->getTimestamp());

    return $res;
}

?>
 
<p class="flow_header" style="margin-left: 10px; font-family: 'Kalam'; font-size: 25px;">Görünüşünü Düzelt</p>

<p class="set-field-header">Kapak Resmini Değiştir:</p>
<div class="set-field-cont">
    <div class="pp-panel" style="text-align: center;">
        <label for="cover_degistir">
            <img class="profil-resmi-sec profile-img" src="<?php echo $_SESSION['coverPic']; ?>" onerror="this.src='/images/cover.png';" width="250px" height="86px" style="background-color: #C5E7E8;"/>
        </label>
        <br />
        <input type="file" name="cover_degistir" id="cover_degistir" />
        <br />
        <div id="uploaded_image"></div>
    </div>
</div>

<p class="set-field-header">Profil Resmini Değiştir:</p>
<div class="set-field-cont">
    <div class="pp-panel" style="text-align: center;">
        <label for="pp_degistir">
            <img class="profil-resmi-sec profile-img" src="<?php echo $_SESSION['profilePic']; ?>" onerror="this.src='/images/avatar.png';" width="104px" height="104px" style="background-color: #C5E7E8; border-radius: 50%;"/>
        </label>
        <br />
        <input type="file" name="pp_degistir" id="pp_degistir" />
        <br />
        <div id="uploaded_image"></div>
    </div>
</div>

<p class="set-field-header">Üniversiteni Seç:</p>
<form id="uni_form" action="" method="post">
	<div class="set-field-cont">
		<select name="uni" class="select-css">
			<option value="0">Üniversite seç:</option>
			<?php
				while($row = mysqli_fetch_assoc($unires))
				{
					echo '<option value="'.$row['ID'].'">'.$row['name'].'</option>';
				}
			?>
		</select>
		<button class="ara-btn" style="background-color: #5CC1FF; margin-left: 10px; padding: 0 10px;" type="submit" name="uni_gonder">Bunu Seç</button>
		<div style="width: 100%;"></div>
		<p style="margin: 5px 0 0 5px; font-size: 9pt; color: #666;">(Mevcut: <b><?php echo ($userinf['Uni']) ? $uniinf['name'] : 'Yok'; ?></b>)</p>
		<div class="kaldir-btn" style="<?php echo ($userinf['Uni']) ? '' : 'display:none;'; ?>"onclick="kaldir(0);"><p style="font-size: 10pt; margin: 0;"><i class="far fa-trash-alt"></i> Kaldır</p></div>
	</div>
</form>

<p class="set-field-header">Diğer ayarlar:</p>
<div class="set-field-cont">
	<form id="dt_form" action="" method="post">
		<label for="dgmtarihi">Doğum Tarihi:</label>
		<div style="width: 100%;"></div>
		<input class="date-input" name="DogumTarihi" type="date" id="dgmtarihi">
		<button class="ara-btn" style="background-color: #5CC1FF; margin-left: 10px; padding: 0 10px;" type="submit" name="dt_gonder">Değiştir</button>
	</form>
	<div style="width: 100%;"></div>
	<p style="margin: 5px 0 0 5px; font-size: 9pt; color: #666;">(Mevcut: <b><?php echo ($userinf['dogumTarihi']) ? $userinf['dogumTarihi'] : 'Yok'; ?></b>)</p>
	<div class="kaldir-btn" onclick="kaldir(1);" style="<?php echo ($userinf['dogumTarihi']) ? '' : 'display:none;'; ?>"><p style="font-size: 10pt; margin: 0;"><i class="far fa-trash-alt"></i> Kaldır</p></div>
</div>

<div id="uploadimageModal" class="modal_e" role="dialog">
    <div class="modal-dialog">
        <div style="max-height: calc(100vh - 100px);" class="modal-content_e">
            <div class="modal-header">
                <div id="sel-header" data-select="0"></div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="margin:0;">Profil Resmi Değiştir</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 text-center">
                        <div id="image_demo"></div>
                    </div>

                    <div class="btn-cont">
                        <div class="prof-spin sk-chase">
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                            <div class="sk-chase-dot"></div>
                        </div>
                        <button class="btn btn-success crop_image">Onayla</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>