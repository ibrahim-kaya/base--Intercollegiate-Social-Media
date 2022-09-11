<?php
include_once('../func/config.php');
include_once('../func/fonksiyonlar.php');

if(isset($_GET['act']))
{
    $type = $_GET['act'];

    if($type == 'logout')
    {
        fonksiyonlar::log_kayit($db, 0, $_SESSION['ID'], "Çıkış yaptı.");
        session_start();
        session_unset();
        session_destroy();
        login_func::deleteCookies();
        header('location: /index.php');

    }
    else if($type == 'kick')
    {
        fonksiyonlar::log_kayit($db, 0, $_SESSION['ID'], "Atıldı. (Cookie uyuşmazlığı ihtimali)");
        session_start();
        session_unset();
        session_destroy();
        login_func::deleteCookies();
        session_start();
        array_push($_SESSION['errors'], "Güvenlik parametreleri uyuşmadığı için hesabınızdan otomatik olarak çıkış yaptınız.<br/>Hesabınıza farklı bir cihazdan giriş yapılmış olabilir.");
        header('location: /index.php');
    }
}