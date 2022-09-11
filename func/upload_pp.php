<?php

include_once('../func/config.php');
include_once('../func/fonksiyonlar.php');

if(isset($_POST["image"]) && isset($_POST["type"]))
{
    $data = $_POST["image"];
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);
    $data = base64_decode($image_array_2[1]);

    if($_POST['type'] == "0") {
        $filename = '/uploads/profile_pics/pp_'.$_SESSION['ID'].'.png'; // output file name
        $w = 200;
        $h = 200;
        $str = 'UPDATE users SET profilePic="'.$filename.'" WHERE ID=?;';
    }
    else if($_POST['type'] == "1") {
        $filename = '/uploads/cover_pics/cp_'.$_SESSION['ID'].'.png'; // output file name
        $w = 600;
        $h = 206;
        $str = 'UPDATE users SET coverPic="'.$filename.'" WHERE ID=?;';
    }
    else
    {
        array_push($_SESSION['errors'], ($_POST['type'] ? 'Kapak' : 'Profil')." fotoğrafını güncelleyemedik. Sistemsel bir sorun oldu.");
        echo '<script>location.reload();</script>';
        return;
    }



    $im = imagecreatefromstring($data);
    $source_width = imagesx($im);
    $source_height = imagesy($im);
    $ratio =  $source_height / $source_width;
    $new_width = $w; // assign new width to new resized image
    $new_height = $h;


    $thumb = imagecreatetruecolor($new_width, $new_height);

    $transparency = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
    imagefilledrectangle($thumb, 0, 0, $new_width, $new_height, $transparency);
    imagecolortransparent($thumb, imagecolorallocatealpha($im, 0, 0, 0, 127));
    imagealphablending($thumb, false);
    imagesavealpha($thumb, true);
    imagecopyresampled($thumb, $im, 0, 0, 0, 0, $new_width, $new_height, $source_width, $source_height);
    imagepng($thumb, '..'.$filename, 9);
    imagedestroy($im);


    $st = mysqli_prepare($db, $str);
    mysqli_stmt_bind_param($st, "i", $_SESSION['ID']);
    if(mysqli_stmt_execute($st))
    {
        if($_POST['type']) $_SESSION['coverPic'] = $filename;
        else $_SESSION['profilePic'] = $filename;

        fonksiyonlar::log_kayit($db, 5, $_SESSION['ID'], ($_POST['type'] ? 'Kapak' : 'Profil')." resmini değiştirdi.");

        array_push($_SESSION['msgs'], ($_POST['type'] ? 'Kapak' : 'Profil')." resmin başarıyla güncellendi!");
    }
    else
    {
        array_push($_SESSION['errors'], ($_POST['type'] ? 'Kapak' : 'Profil')." resmini güncelleyemedik. Sistemsel bir sorun oldu.");
    }
    mysqli_stmt_close($st);


    echo '<script>location.reload();</script>';

}