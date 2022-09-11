<?php
function getUserIP($ip = null, $deep_detect = TRUE){
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }
    return $ip;
}

class fonksiyonlar
{
    public static function log_kayit($database, $log_turu, $userid, $icerik)
    {
        date_default_timezone_set('Europe/Istanbul');
        $var_time = time();
        $time_text = date("d/m/Y H:i");
        $var_ip = getUserIP();
        $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=".getUserIP()));
        $loc = $geo["geoplugin_city"].', '.$geo["geoplugin_countryName"];

        $statement = mysqli_prepare($database, "INSERT INTO `log_kayitlari`(`logTuru`, `userID`, `icerik`, `tarih_timestamp`, `tarih_yazi`, `ip`, `konum`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($statement, "iisisss", $log_turu, $userid, $icerik, $var_time, $time_text, $var_ip, $loc);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        mysqli_stmt_close($statement);
    }
}