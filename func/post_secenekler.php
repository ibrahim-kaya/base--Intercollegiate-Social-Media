<?php 
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) { header('location: /'); return; }
include_once('../func/config.php');
require_once "../func/Mobile_Detect.php";

$detect = new Mobile_Detect;

if(!isset($_POST['eylem']) || !isset($_POST['value'])) return;

$userid = $_SESSION['ID'];

if($_POST['eylem'] == 0) // Paylaş
{?>
	<style>
	
	.link-box {
		resize: none; 
		height: 30px; 
		white-space: nowrap; 
		overflow: hidden; 
		font-size: 12pt; 
		font-family: 'Bellota Text'; 
		vertical-align: middle; 
		margin-right: 5px;
		display:inline-block;
		padding-top: 10px;
		border-radius: 10px;
		border: none;
		background-color: #D7E5ED;
		border: 1px solid #84AFC8;
	}
	
	.link-btn {
		height: 35px; 
		display: inline-block; 
		background-color: #62C1F8; 
		border-radius: 10px; 
		border: 1px solid #3BB2F7; 
		color: #fff; 
		vertical-align: middle; 
		text-align: center; 
		width: 80px;
		cursor: pointer;
		transition: all .4s;
	}
	
	.link-btn:hover {
		background-color: #8BD0F9;
	}
	</style>
	

	
	<div style="height: auto; width: auto; text-align: center; padding: 10px 0 20px 0;">
		<textarea id="link" class="link-box">http://base.com/gonderi/<?php echo $_POST['value']; ?></textarea>
		<div class="link-btn" onclick="copyLink(<?php echo $_POST['value']; ?>)"><div style="width: auto; height: inherit; display: table-cell; width: inherit; vertical-align: middle;"><span>Kopyala</span><div></div>
	</div>
<?php }
else if($_POST['eylem'] == 1) // Düzenle
{?>
	E hadi düzenleyelim. <?php echo 'Ben: '.$userid.' Bu:'.$_POST['value']; ?>
<?php } 
else if($_POST['eylem'] == 2) // Sil
{?>
	<div style="height: auto; width: auto; text-align: center; padding: 20px 10px;">
		<h2 style="font-size: 17pt; font-weight: bold; margin: 0 0 20px 0;">Gönderiyi silelim mi?</h2><span>Bak bu işin geri dönüşü yok ona göre. İyi düşün.</span>
		
		<div class="btns">
			<a href="javascript:void(0)" class="btn1" onclick="btn1_click()">Vazgeçtim</a>
			<a href="javascript:void(0)" class="btn2" onclick="islemUygula(0, <?php echo $_POST['value']; ?>); btn1_click();">Sil Gitsin</a>
		</div>
	</div>

<?php }
else if($_POST['eylem'] == 3) // Gönderi Şikayet
{?>
	Vay ispikçi! <?php echo 'Ben: '.$userid.' Bu:'.$_POST['value']; ?>
<?php }
else if($_POST['eylem'] == 4) // Kişi Engelle
{
	$query = mysqli_query($db, "SELECT * FROM users WHERE ID=".$_POST['value']);
	$user_inf = mysqli_fetch_assoc($query);
?>
	
	<div style="height: auto; width: auto; text-align: center; padding: 20px 10px;">
		<h2 style="font-size: 17pt; font-weight: bold; margin: 0 0 20px 0;"><?php echo $user_inf['Username']; ?> adlı kişiyi engelleyelim mi?</h2><span>Engellediğin zaman bu kişinin gönderilerini, yorumlarını falan göremeyeceksin. O da seninkileri göremeyecek tabi.</span>
		
		<div class="btns">
			<a href="javascript:void(0)" class="btn1" onclick="btn1_click()">Vazgeçtim</a>
			<a href="javascript:void(0)" class="btn2" onclick=" ">Engelle Gitsin</a>
		</div>
	</div>
	
	
<?php } 
else if($_POST['eylem'] == 5) // Kişi Takip Et / Bırak
{
	if ($stmt = mysqli_prepare($db, "SELECT * FROM user_follows WHERE FollowerID=? and FollowingID=?;")) {
		mysqli_stmt_bind_param($stmt, "ii", $userid, $_POST['value']);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$following = mysqli_fetch_assoc($result);
	
		$st = mysqli_prepare($db, "SELECT * FROM users WHERE ID=?;");
		mysqli_stmt_bind_param($st, "i", $_POST['value']);
		mysqli_stmt_execute($st);
		$result = mysqli_stmt_get_result($st);
		$user_inf = mysqli_fetch_assoc($result);

		if($following)
		{ ?>
		<div style="height: auto; width: auto; text-align: center; padding: 20px 10px;">
			<h2 style="font-size: 17pt; font-weight: bold; margin: 0 0 20px 0;"><?php echo $user_inf['Username']; ?> adlı kişiyi takipten çıkalım mı?</h2><span>Emin misin? bak bi' daha düşün.</span>
			<div class="btns">
				<a href="javascript:void(0)" class="btn1" onclick="btn1_click();">Vazgeçtim</a>
				<a href="javascript:void(0)" class="btn2" onclick="UserTakip(<?php echo $_POST['value'].', \''.$user_inf['Username'].'\''; ?>); btn1_click();">Eminim</a>
			</div>
		</div>
		<?php }
		else
		{?>followed|<?php echo $user_inf['Username'].'|'.$user_inf['profilePic'];
		}
		mysqli_stmt_close($stmt);
		mysqli_stmt_close($st);
	}
}
else if($_POST['eylem'] == 6)  // Uni Takip Et / Bırak
{
	$following_uni_q = mysqli_query($db, "SELECT * FROM abonelikler WHERE userID=".$userid." and uniID=".$_POST['value']);
	$following_uni = mysqli_fetch_assoc($following_uni_q);
	
	if($following_uni)
	{ ?>
		Takibi bırakmak mı istiyorsun? <?php echo 'Ben: '.$userid.' Bu:'.$_POST['value']; ?>
	<?php }
	else
	{?>
		Takip edelim bakalım. <?php echo 'Ben: '.$userid.' Bu:'.$_POST['value']; ?>
	<?php }
}