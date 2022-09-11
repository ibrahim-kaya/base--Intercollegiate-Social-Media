<style>

.e_cont{
	justify-content: center;
	display: flex;
	margin: 0 0 10px 0;
}

.e_message{
	color: #ff1e00;
	border: 1px solid #ff2400;
	border-radius: 50px;
	padding: 5px 10px;
	font-size:14px;
}

#ppSelector{
	font-family: 'Bellota Text';
	border: 1px solid #666;
	background-color: #2e415e;
	border-radius: 10px;
	padding: 5px;
}

#yukle_btn{
	border: 0;
	font-family: 'Bellota Text';
	padding: 7px 15px;
	border-radius: 10px;
	background-color: #8fbfe0;
}

#ppDisplay{
	height: 128px; 
	width: 128px; 
	object-fit: contain;
	border-radius: 50%; 
	box-shadow: 0px 0px 5px 2px rgba(0,0,0,0.1); 
	cursor: pointer;
}

</style>

<?php 
include_once('../func/config.php');

if(!isset($_POST['edit_id'])) return;

if($_POST['edit_id'] == 1)
{
	$result_uni = mysqli_query($db, "SELECT * FROM categories");
	
	$str2 = '';
	$str1 = '<form action="../func/edit_apply.php" method="post">  <input type="hidden" id="edit_id" name="editID" value="1">
			<div class="uni_list" style="background-color: #D3EDEE; overflow: auto; width: 100%;">
			<div style="font-size: 22px;"><p style="margin: 15px 0 15px 10px;">Üniversiteler</p></div>

			  <select id="unis" name="uni" size="10" style = "background-color: #E2F3F4; border: 0; width: 100%; font-size: 25px; text-align: center;color: #222; font-family: \'Patrick Hand\', cursive;">
			  <option value="" disabled selected>Üniversitenizi Seçin</option>
			  <option value="0">(X) Kaldır</option>';

	while($uni_row = mysqli_fetch_array($result_uni))
	{ 
	$str2 = $str2.'<option value="'.$uni_row['ID'].'">'. $uni_row['name'] .'</option>';
	}

	echo $str1.$str2.'</select></div> <button type="submit" style="float: right;">Seç</button></form>';
}
elseif($_POST['edit_id'] == 2){
	echo '
			<div id="c_err_div"></div>
			<div style="text-align: center;">
			<form method="post" action="" onsubmit="return apply_edit(2);">
				<select id="selGun" class="dogumGunu" name="d_Gun">
				<option value="0">- Gün -</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
				</select><select id="selAy" class="dogumGunu" name="d_Ay">
				<option value="0">- Ay -</option>
				<option value="1">Ocak</option>
				<option value="2">Şubat</option>
				<option value="3">Mart</option>
				<option value="4">Nisan</option>
				<option value="5">Mayıs</option>
				<option value="6">Haziran</option>
				<option value="7">Temmuz</option>
				<option value="8">Ağustos</option>
				<option value="9">Eylül</option>
				<option value="10">Ekim</option>
				<option value="11">Kasım</option>
				<option value="12">Aralık</option>
				</select><select id="selYil" class="dogumGunu" name="d_Yil">
				<option value="0">- Yıl -</option>
				<option value="2020">2020</option>
				<option value="2019">2019</option>
				<option value="2018">2018</option>
				<option value="2017">2017</option>
				<option value="2016">2016</option>
				<option value="2015">2015</option>
				<option value="2014">2014</option>
				<option value="2013">2013</option>
				<option value="2012">2012</option>
				<option value="2011">2011</option>
				<option value="2010">2010</option>
				<option value="2009">2009</option>
				<option value="2008">2008</option>
				<option value="2007">2007</option>
				<option value="2006">2006</option>
				<option value="2005">2005</option>
				<option value="2004">2004</option>
				<option value="2003">2003</option>
				<option value="2002">2002</option>
				<option value="2001">2001</option>
				<option value="2000">2000</option>
				<option value="1999">1999</option>
				<option value="1998">1998</option>
				<option value="1997">1997</option>
				<option value="1996">1996</option>
				<option value="1995">1995</option>
				<option value="1994">1994</option>
				<option value="1993">1993</option>
				<option value="1992">1992</option>
				<option value="1991">1991</option>
				<option value="1990">1990</option>
				<option value="1989">1989</option>
				<option value="1988">1988</option>
				<option value="1987">1987</option>
				<option value="1986">1986</option>
				<option value="1985">1985</option>
				<option value="1984">1984</option>
				<option value="1983">1983</option>
				<option value="1982">1982</option>
				<option value="1981">1981</option>
				<option value="1980">1980</option>
				<option value="1979">1979</option>
				<option value="1978">1978</option>
				<option value="1977">1977</option>
				<option value="1976">1976</option>
				<option value="1975">1975</option>
				<option value="1974">1974</option>
				<option value="1973">1973</option>
				<option value="1972">1972</option>
				<option value="1971">1971</option>
				<option value="1970">1970</option>
				<option value="1969">1969</option>
				<option value="1968">1968</option>
				<option value="1967">1967</option>
				<option value="1966">1966</option>
				<option value="1965">1965</option>
				<option value="1964">1964</option>
				<option value="1963">1963</option>
				<option value="1962">1962</option>
				<option value="1961">1961</option>
				<option value="1960">1960</option>
				<option value="1959">1959</option>
				<option value="1958">1958</option>
				<option value="1957">1957</option>
				<option value="1956">1956</option>
				<option value="1955">1955</option>
				<option value="1954">1954</option>
				<option value="1953">1953</option>
				<option value="1952">1952</option>
				<option value="1951">1951</option>
				<option value="1950">1950</option>
				<option value="1949">1949</option>
				<option value="1948">1948</option>
				<option value="1947">1947</option>
				<option value="1946">1946</option>
				<option value="1945">1945</option>
				<option value="1944">1944</option>
				<option value="1943">1943</option>
				<option value="1942">1942</option>
				<option value="1941">1941</option>
				<option value="1940">1940</option>
				<option value="1939">1939</option>
				<option value="1938">1938</option>
				<option value="1937">1937</option>
				<option value="1936">1936</option>
				<option value="1935">1935</option>
				<option value="1934">1934</option>
				<option value="1933">1933</option>
				<option value="1932">1932</option>
				<option value="1931">1931</option>
				<option value="1930">1930</option>
				</select>
				<button type="submit" id="bday_sbtn" class="gonderButonu" name="send-bday-btn">Onayla</button>
			</form></div>
	';
}
elseif($_POST['edit_id'] == 3){
	echo '<div style="text-align: center; color: #fff;">
	<div id="c_err_div"></div>
	<form id="ppForm" action="" method="POST" enctype="multipart/form-data" onsubmit="return apply_edit(1);">
	<div style="width: 128px; height: 128px; margin: 0 auto 20px auto;"><img id="ppDisplay" title="Profil resmi seç..." src="/images/pp_placeholder.png" onclick="ppSecici()" /></div>
	<input id="ppSelector" type="file" name="file" style="display: none;" onchange="ppGoster(this)">
	<button id="yukle_btn" type="submit" name="submit"><i class="fas fa-cloud-upload-alt"></i> Bunu Profil Resmi Yap</button>
	</div>';
}
?>
