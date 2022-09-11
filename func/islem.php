<?php
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) { header('location: /'); return; }
include_once('../func/config.php');

if(!isset($_POST['islemid'])) return;

if($_POST['islemid'] == 0) // Gönderi sil
{
    $stmt = mysqli_prepare($db, "SELECT * FROM posts WHERE userID=? and ID=?;");
    mysqli_stmt_bind_param($stmt, "ii", $_SESSION['ID'], $_POST['value']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if($post = mysqli_fetch_assoc($result)){
        $st = mysqli_prepare($db, "UPDATE posts SET silindi=1 WHERE ID=?;");
        mysqli_stmt_bind_param($st, "i", $_POST['value']);
        mysqli_stmt_execute($st);
        mysqli_stmt_close($st);

        echo 'Gönderi silindi|<p style="text-align: center; color: #666; font-size: 10pt;"><i>Bu gönderi silindi.</i></p>';
    }
    else
    {
        echo 'err|Gönderi bulunamadı veya bu gönderiyi sen yazmamışsın.';
    }

}
else if($_POST['islemid'] == 1) // like
{
    if(!isset($_SESSION['ID']))
    {
        echo 'uyeDegil';
    }
    else {
        $stmt = mysqli_prepare($db, "SELECT * FROM post_likes WHERE postID=? and userID=?;");
        mysqli_stmt_bind_param($stmt, "ii", $_POST['post_id'], $_SESSION["ID"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $isliked = mysqli_num_rows($result);
        mysqli_stmt_close($stmt);

        if ($isliked) {
            $stmt = mysqli_prepare($db, "DELETE FROM `post_likes` WHERE `postID`=? AND `userID`=?;");
            mysqli_stmt_bind_param($stmt, "ii", $_POST['post_id'], $_SESSION["ID"]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo 'disliked';
        } else {
            $stmt = mysqli_prepare($db, "SELECT * FROM posts WHERE ID=?;");
            mysqli_stmt_bind_param($stmt, "i", $_POST['post_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $postdata = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            $var_time = time();

            $stmt = mysqli_prepare($db, "INSERT INTO `post_likes`(`postID`, `userID`, `tarih`) VALUES (?, ?, ?);");
            mysqli_stmt_bind_param($stmt, "iii", $_POST['post_id'], $_SESSION["ID"], $var_time);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $link = "/gonderi/".$_POST['post_id'];

            $stmt = mysqli_prepare($db, "INSERT INTO `bildirimler`(`userID`, `noti_userID`, `type`, `icerik`, `link`, `tarih`) VALUES (?, ?, '0', ' Gönderini beğendi.', ?, ?);");
            mysqli_stmt_bind_param($stmt, "iisi", $postdata['userID'], $_SESSION['ID'], $link, $var_time);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo 'liked';
        }
    }
}
else if($_POST['islemid'] == 2) // get likes
{
    $stmt = mysqli_prepare($db, "SELECT * FROM post_likes WHERE postID=?;");
    mysqli_stmt_bind_param($stmt, "i", $_POST['post_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $likes = mysqli_num_rows($result);
    mysqli_stmt_close($stmt);
    echo $likes;
}
else if($_POST['islemid'] == 3) // subscribe
{
    if(isset($_SESSION['ID']))
    {
        $stmt = mysqli_prepare($db, "SELECT * FROM abonelikler WHERE uniID=? and userID=?;");
        mysqli_stmt_bind_param($stmt, "ii", $_POST['uni_id'], $_SESSION["ID"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $issub = mysqli_num_rows($result);
        mysqli_stmt_close($stmt);

        if($issub)
        {
            $stmt = mysqli_prepare($db, "DELETE FROM `abonelikler` WHERE `uniID`=? AND `userID`=?;");
            mysqli_stmt_bind_param($stmt, "ii", $_POST['uni_id'], $_SESSION["ID"]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo 'unsubscribed';
        }
        else
        {
            $stmt = mysqli_prepare($db, "INSERT INTO `abonelikler`(`uniID`, `userID`) VALUES (?, ?);");
            mysqli_stmt_bind_param($stmt, "ii", $_POST['uni_id'], $_SESSION["ID"]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo 'subscribed';
        }
    }
    else
    {
        echo 'uyeDegil';
    }
}
else if($_POST['islemid'] == 4) // follow
{
    $stmt = mysqli_prepare($db, "SELECT * FROM user_follows WHERE FollowingID=? and FollowerID=?;");
    mysqli_stmt_bind_param($stmt, "ii", $_POST['follow_id'], $_SESSION["ID"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $issub = mysqli_num_rows($result);
    mysqli_stmt_close($stmt);

    if($issub)
    {
        $stmt = mysqli_prepare($db, "DELETE FROM `user_follows` WHERE `FollowingID`=? AND `FollowerID`=?;");
        mysqli_stmt_bind_param($stmt, "ii", $_POST['follow_id'], $_SESSION["ID"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($db, "SELECT * FROM user_follows WHERE FollowingID=?;");
        mysqli_stmt_bind_param($stmt, "i", $_POST['follow_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $follower_cnt = mysqli_num_rows($result);
        mysqli_stmt_close($stmt);

        fonksiyonlar::log_kayit($db, 6, $_SESSION['ID'], "Kullanıcıyı takipten çıktı. (ID: ".$_POST['follow_id'].")");

        echo 'unfollowed|'.$follower_cnt;
    }
    else
    {
        $var_time = time();

        $stmt = mysqli_prepare($db, "INSERT INTO `user_follows`(`FollowingID`, `FollowerID`) VALUES (?,?);");
        mysqli_stmt_bind_param($stmt, "ii", $_POST['follow_id'], $_SESSION["ID"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($db, "SELECT * FROM user_follows WHERE FollowingID=?;");
        mysqli_stmt_bind_param($stmt, "i", $_POST['follow_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $follower_cnt = mysqli_num_rows($result);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($db, "INSERT INTO `bildirimler`(`userID`, `noti_userID`, `type`, `icerik`, `tarih`) VALUES (?,?,'2',' Seni takip etmeye başladı.',?);");
        mysqli_stmt_bind_param($stmt, "iii", $_POST['follow_id'], $_SESSION["ID"], $var_time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        fonksiyonlar::log_kayit($db, 6, $_SESSION['ID'], "Kullanıcıyı takip etti. (ID: ".$_POST['follow_id'].")");

        echo 'followed|'.$follower_cnt;
    }
}
else if($_POST['islemid'] == 5) // comment like
{
    if(!isset($_SESSION['ID']))
    {
        echo 'uyeDegil';
    }
    else {
        $stmt = mysqli_prepare($db, "SELECT * FROM comment_likes WHERE cmtID=? and userID=?;");
        mysqli_stmt_bind_param($stmt, "ii", $_POST['comment_id'], $_SESSION["ID"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $isliked = mysqli_num_rows($result);
        mysqli_stmt_close($stmt);

        if ($isliked) {
            $stmt = mysqli_prepare($db, "DELETE FROM `comment_likes` WHERE `cmtID`=? AND `userID`=?;");
            mysqli_stmt_bind_param($stmt, "ii", $_POST['comment_id'], $_SESSION["ID"]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo 'disliked';
        } else {
            $stmt = mysqli_prepare($db, "SELECT * FROM comments WHERE ID=?;");
            mysqli_stmt_bind_param($stmt, "i", $_POST['comment_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $postdata = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            $var_time = time();
            $clink = "/gonderi/".$postdata['postID']."&yorum=".$_POST['comment_id'];

            $stmt = mysqli_prepare($db, "INSERT INTO `comment_likes`(`cmtID`, `userID`, `tarih`) VALUES (?, ?, ?);");
            mysqli_stmt_bind_param($stmt, "iii", $_POST['comment_id'], $_SESSION["ID"], $var_time);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $stmt = mysqli_prepare($db, "INSERT INTO `bildirimler`(`userID`, `noti_userID`, `type`, `icerik`, `link`, `tarih`) VALUES (?, ?, '0', ' Yorumunu beğendi.', ?, ?);");
            mysqli_stmt_bind_param($stmt, "iisi", $postdata['userID'], $_SESSION['ID'], $clink, $var_time);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo 'liked';
        }
    }
}
else if($_POST['islemid'] == 6) // get comment likes
{
    $stmt = mysqli_prepare($db, "SELECT * FROM comment_likes WHERE cmtID=?;");
    mysqli_stmt_bind_param($stmt, "i", $_POST['comment_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $likes = mysqli_num_rows($result);
    mysqli_stmt_close($stmt);
    echo $likes;
}