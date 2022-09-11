<?php
	if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) { header('location: /'); return; }
	include_once('../func/config.php');

if ($stmt = mysqli_prepare($db, "SELECT * FROM `categories`;")) {
	mysqli_stmt_execute($stmt);
	$result_uni = mysqli_stmt_get_result($stmt);

	
	$str2 = '';
	$str1 = '<div class="uni_list" style="background-color: #D3EDEE; border-radius: 0 0 5px 5px; overflow: auto; width: 100%; max-height: 300px;">';
    $strheader = '<div style="font-size: 22px; padding-left: 5px;"><p style="margin: 15px 0 15px 0;">Üniversiteler</p></div>';

	while($uni_row = mysqli_fetch_array($result_uni))
	{
        if($_SESSION['Uni'] == $uni_row['ID']){
            $strBenimUnim = '<div style="font-size: 22px; padding-left: 5px;"><p style="margin: 15px 0 15px 0;">Benim Üniversitem</p></div>
        <a href="/uni/'. $uni_row['ID'] .'"><div class="uni_li"><img src="'. $uni_row['pic'] .'"> <p>'. $uni_row['name'] .'</p></div></a>';
        }
        else{
            $str2 = $str2.'<a href="/uni/'. $uni_row['ID'] .'"><div class="uni_li"><img src="'. $uni_row['pic'] .'"> <p>'. $uni_row['name'] .'</p></div></a>';
        }
	}

    if($_SESSION['Uni']){
        $strheader = '<div style="font-size: 22px; padding-left: 5px;"><p style="margin: 15px 0 15px 0;">Diğer Üniversiteler</p></div>';
        echo $str1.$strBenimUnim.$strheader.$str2.'</div></div>';
    }
    else
    {
        echo $str1.$strheader.$str2.'</div></div>';
    }
	
	mysqli_stmt_close($stmt);
}