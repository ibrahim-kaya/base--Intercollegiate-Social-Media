<?php
include_once('../func/config.php');


$stmt = mysqli_prepare($db, "SELECT * FROM `categories`;");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

$uni_fame = array();
$zaman = strtotime('today midnight');

while ($uni = mysqli_fetch_array($result))
{
    $st = mysqli_prepare($db, "SELECT * FROM `posts` WHERE `postCategory` = ? AND `postTime` >= ?;");
    mysqli_stmt_bind_param($st, "ii", $uni['ID'], $zaman);
    mysqli_stmt_execute($st);
    $res = mysqli_stmt_get_result($st);
    $sayi = mysqli_num_rows($res);
    mysqli_stmt_close($st);
    if($sayi){
        if(!isset($uni_fame[$uni['ID']])) $uni_fame[$uni['ID']] = 0;
        $uni_fame[$uni['ID']] += $sayi;
    }

    $st = mysqli_prepare($db, "SELECT * FROM `comments` INNER JOIN `posts` ON `comments`.`postID` = `posts`.`ID` WHERE `posts`.`postCategory` = ? AND `comments`.`date` >= ?;");
    mysqli_stmt_bind_param($st, "ii", $uni['ID'], $zaman);
    mysqli_stmt_execute($st);
    $res = mysqli_stmt_get_result($st);
    $sayi = mysqli_num_rows($res);
    mysqli_stmt_close($st);
    if($sayi){
        if(!isset($uni_fame[$uni['ID']])) $uni_fame[$uni['ID']] = 0;
        $uni_fame[$uni['ID']] += $sayi;
    }

    $st = mysqli_prepare($db, "SELECT * FROM `post_likes` INNER JOIN `posts` ON `post_likes`.`postID` = `posts`.`ID` WHERE `posts`.`postCategory` = ? AND `post_likes`.`tarih` >= ?;");
    mysqli_stmt_bind_param($st, "ii", $uni['ID'], $zaman);
    mysqli_stmt_execute($st);
    $res = mysqli_stmt_get_result($st);
    $sayi = mysqli_num_rows($res);
    mysqli_stmt_close($st);
    if($sayi){
        if(!isset($uni_fame[$uni['ID']])) $uni_fame[$uni['ID']] = 0;
        $uni_fame[$uni['ID']] += $sayi;
    }
}

function sirala($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}

uasort($uni_fame, 'sirala');

$stmt = mysqli_prepare($db, "SELECT * FROM `categories`;");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$uniler = mysqli_fetch_all($result);
mysqli_stmt_close($stmt);

?>
    <table class="trending">
        <tr class="trending-header" style="border-bottom: #C7DAE5 1px solid;">
            <td colspan="2">
                <div style="display:flex; align-items: center; margin-left: 15px; padding-right: 15px;">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g xmlns="http://www.w3.org/2000/svg"><path d="m30 330h91v167h-91z" fill="#fed843" data-original="#fed843" style="" class=""/><path d="m271 300h91v197h-91z" fill="#fed843" data-original="#fed843" style="" class=""/><path d="m151 240h90v257h-90z" fill="#11beff" data-original="#ff641a" style="" class=""/><path d="m392 180h90v317h-90z" fill="#11beff" data-original="#ff641a" style="" class=""/><path d="m76 330h45v167h-45z" fill="#fabe2c" data-original="#fabe2c" style="" class=""/><path d="m196 240h45v257h-45z" fill="#00aff0" data-original="#f03800" style="" class=""/><path d="m316 300h46v197h-46z" fill="#fabe2c" data-original="#fabe2c" style="" class=""/><path d="m437 180h45v317h-45z" fill="#00aff0" data-original="#f03800" style="" class=""/><path d="m392 0v30h68.789l-144.789 143.789-60-60-60-60-191.605 190.606 21.21 21.21 170.395-169.394 60 60 60 60 166-165v68.789h30v-120z" fill="#97de3d" data-original="#97de3d" style="" class=""/><path d="m482 51.211v68.789h30v-120h-120v30h68.789l-144.789 143.789-60-60v42.422l60 60z" fill="#59c36a" data-original="#59c36a" style=""/><path d="m256 482h-256v30h256 256v-30z" fill="#7e2e2e" data-original="#2d5177" style="" class=""/><path d="m256 482h256v30h-256z" fill="#a22929" data-original="#32405d" style="" class=""/></g></g></svg>
                    <p style="margin-left: 15px; font-size: 11pt; color: #333; text-transform: uppercase; font-family: 'Duru Sans'; font-weight: 500;">Günün En Aktif Üniversiteleri</p>
                </div>
            </td>
        </tr>

        <tr class="trending-header" <?php if(!count($uni_fame)) echo 'style="display: none;"'; ?>>
            <td></td>
            <td><p style="margin: 0; font-size: 7pt; text-transform: uppercase; color: #666;">Etkileşimler</p></td>
        </tr>

        <?php if(!count($uni_fame))
        {
            ?>
            <tr class="trending-header">
                <td><p style="color: #666; text-align: center; font-style: italic;">(Bugün hiç etkileşim olmamış.)</p></td>
                <td></td>
            </tr>
            <?php
        }
        ?>


        <?php foreach($uni_fame as $i => $puan) {
            $key = array_search($i, array_column($uniler, '0'));
            ?>
            <tr>
                <td title="<?php echo $uniler[$key][1]; ?>">
                    <div style="display: flex; align-items: center;">
                        <img src="<?php echo $uniler[$key][2]; ?>" width="32px" height="32px" style="border-radius: 50%; margin-right: 10px;">
                        <p class="trending-uniadi"><?php echo $uniler[$key][1]; ?></p>
                    </div>
                </td>
                <td style="width: 50px; text-align: center;">
                    <p><?php echo $puan ?></p>
                </td>
            </tr>
        <?php } ?>

    </table>
<?php


// $timestamp = strtotime('today midnight')
//Bugünün postları: SELECT * FROM `posts` WHERE `postCategory` = 1 AND `postTime` >= 1608411600;
//Bugünün yorumları: SELECT * FROM `comments` INNER JOIN `posts` ON `comments`.`postID` = `posts`.`ID` WHERE `posts`.`postCategory` = 1 AND `comments`.`date` >= 1608411600;
//Bugünün likeları: SELECT * FROM `post_likes` INNER JOIN `posts` ON `post_likes`.`postID` = `posts`.`ID` WHERE `posts`.`postCategory` = 1 AND `post_likes`.`tarih` >= 1608411600;
?>