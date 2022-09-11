-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 11 Eyl 2022, 04:59:55
-- Sunucu sürümü: 5.7.39
-- PHP Sürümü: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `xpdevilc_base`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `abonelikler`
--

CREATE TABLE `abonelikler` (
  `userID` int(11) NOT NULL,
  `uniID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `abonelikler`
--

INSERT INTO `abonelikler` (`userID`, `uniID`) VALUES
(1, 2),
(17, 3),
(16, 2),
(16, 4),
(20, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bildirimler`
--

CREATE TABLE `bildirimler` (
  `n_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `noti_userID` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `icerik` varchar(256) COLLATE utf8_turkish_ci NOT NULL,
  `link` text COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(24) CHARACTER SET latin1 NOT NULL,
  `okundu` int(11) NOT NULL DEFAULT '0',
  `goruldu` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `bildirimler`
--

INSERT INTO `bildirimler` (`n_id`, `userID`, `noti_userID`, `type`, `icerik`, `link`, `tarih`, `okundu`, `goruldu`) VALUES
(5, 5, 1, 0, ' Gönderini beğendi.', '', '1603729206', 1, 1),
(6, 5, 1, 0, ' Gönderini beğendi.', '', '1603729210', 1, 1),
(7, 5, 1, 0, ' Gönderini beğendi.', '', '1603977331', 1, 1),
(8, 5, 1, 0, ' Gönderini beğendi.', '', '1603977335', 1, 1),
(9, 14, 14, 0, ' Gönderini beğendi.', '', '1604425112', 1, 1),
(12, 5, 1, 0, ' Gönderini beğendi.', '', '1607279994', 1, 1),
(44, 20, 1, 2, ' Seni takip etmeye başladı.', '', '1622633907', 0, 0),
(21, 14, 1, 2, ' Seni takip etmeye başladı.', '', '1608309035', 1, 1),
(22, 14, 1, 2, ' Seni takip etmeye başladı.', '', '1608309041', 1, 1),
(23, 14, 1, 2, ' Seni takip etmeye başladı.', '', '1608309059', 1, 1),
(24, 20, 14, 0, ' Gönderini beğendi.', '/gonderi/15', '1608489861', 0, 1),
(25, 20, 20, 0, ' Gönderini beğendi.', '/gonderi/15', '1608490047', 0, 1),
(26, 14, 20, 0, ' Gönderini beğendi.', '/gonderi/14', '1608490053', 1, 1),
(27, 20, 1, 1, ' Gönderine yorum yaptı.', '/gonderi/15&yorum=11', '1608551918', 0, 0),
(28, 14, 14, 1, ' Gönderine yorum yaptı.', '/gonderi/14&yorum=12', '1608552170', 1, 1),
(29, 14, 14, 1, ' Gönderine yorum yaptı.', '/gonderi/14&yorum=13', '1608560366', 1, 1),
(30, 14, 14, 1, ' Gönderine yorum yaptı.', '/gonderi/14&yorum=14', '1608563699', 1, 1),
(31, 14, 14, 1, ' Gönderine yorum yaptı.', '/gonderi/14&yorum=15', '1608563753', 1, 1),
(32, 20, 16, 0, ' Gönderini beğendi.', '/gonderi/15', '1609151835', 0, 0),
(33, 16, 1, 2, ' Seni takip etmeye başladı.', '', '1609152031', 0, 1),
(37, 20, 1, 2, ' Seni takip etmeye başladı.', '', '1610245431', 0, 0),
(38, 20, 1, 2, ' Seni takip etmeye başladı.', '', '1610245449', 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_turkish_ci NOT NULL,
  `pic` varchar(128) COLLATE utf8_turkish_ci NOT NULL,
  `kapak` text COLLATE utf8_turkish_ci NOT NULL,
  `info` varchar(128) COLLATE utf8_turkish_ci NOT NULL,
  `kisaltma` varchar(12) COLLATE utf8_turkish_ci NOT NULL,
  `kurulus` text COLLATE utf8_turkish_ci NOT NULL,
  `sehir` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`ID`, `name`, `pic`, `kapak`, `info`, `kisaltma`, `kurulus`, `sehir`) VALUES
(1, 'Öyle Ortaya', 'https://pbs.twimg.com/profile_images/631084044239810560/7yM0xoSD_400x400.png', '/images/uni/kapak/kapak-yok.jpg', 'Öylesine yazılmış şeyler.', 'Öylesine', 'n/a', 'n/a'),
(2, 'Namık Kemal Üniversitesi', 'https://esas.nku.edu.tr/assets/images/nkulogo.jpg', '/images/uni/kapak/nku.jpg', 'Tekirdağ\'de bir üniversite.', 'NKÜ', '17 Mar 2006', 'Tekirdağ'),
(3, 'Akdeniz Üniversitesi', 'https://i.pinimg.com/originals/4e/26/f7/4e26f7b238aa58008eb1efc5b8f84cc3.jpg', '/images/uni/kapak/kapak-yok.jpg', 'Antalya\'da bir üniversite.', 'AÜ', 'n/a', 'Antalya'),
(4, 'Ege Üniversitesi', 'https://egefish.ege.edu.tr/files/egefish/icerik/logo-eu_eng.png', '/images/uni/kapak/kapak-yok.jpg', 'İzmir\'de bir üniversite.', 'EÜ', 'n/a', 'İzmir'),
(5, 'İstanbul Üniversitesi', 'https://upload.wikimedia.org/wikipedia/tr/9/92/Istanbul_Universitesi.png', '/images/uni/kapak/kapak-yok.jpg', 'İstanbul\'da bir üniversite.', 'İÜ', 'n/a', 'İstanbul'),
(6, 'Adnan Menderes Üniversitesi', 'https://cdn.freelogovectors.net/wp-content/uploads/2018/04/adnan-menderes-universitesi-logo_freelogovectors.net_.png', '/images/uni/kapak/kapak-yok.jpg', 'Aydın\'da bir üniversite.', 'ADÜ', 'n/a', 'Aydın');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE `comments` (
  `ID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `comment` varchar(256) COLLATE utf8_turkish_ci NOT NULL,
  `date` varchar(24) COLLATE utf8_turkish_ci NOT NULL,
  `IP` varchar(24) COLLATE utf8_turkish_ci NOT NULL,
  `device` varchar(256) COLLATE utf8_turkish_ci NOT NULL,
  `location` varchar(128) COLLATE utf8_turkish_ci NOT NULL,
  `silindi` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `comments`
--

INSERT INTO `comments` (`ID`, `postID`, `userID`, `comment`, `date`, `IP`, `device`, `location`, `silindi`) VALUES
(1, 5, 4, 'asd', '1600176839', '', '', '', 0),
(2, 5, 4, 'second comment', '1600178884', '', '', '', 0),
(3, 7, 4, 'Test', '1601450265', '', '', '', 0),
(4, 7, 4, 'Test 2', '1601450279', '', '', '', 0),
(5, 7, 15, 'Abe ben  gibarca yazıyom çküden bi gız sevdim bene yazsın', '1601486977', '', '', '', 0),
(6, 6, 1, 'Rruttur', '1602181600', '', '', '', 0),
(7, 12, 1, 'Test', '1602454863', '176.43.199.225', 'Mozilla/5.0 (iPhone; CPU OS 14_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/28.2  Mobile/15E148 Safari/605.1.15', 'Antalya, Turkey', 0),
(8, 8, 1, 'Qwerty', '1602544083', '46.154.15.203', 'Mozilla/5.0 (iPhone; CPU OS 14_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/28.2  Mobile/15E148 Safari/605.1.15', 'Konya, Turkey', 0),
(9, 12, 1, 'Qwerty', '1602716572', '46.154.13.59', 'Mozilla/5.0 (iPhone; CPU OS 14_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/28.2  Mobile/15E148 Safari/605.1.15', 'Huyuk, Turkey', 0),
(10, 14, 14, 'yorum', '1604425144', '94.123.163.250', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36', 'Kahramanmaraş, Turkey', 0),
(11, 15, 1, 'En kısa sürede ekleyeceğiz efenim :D', '1608551918', '176.232.60.167', 'Mozilla/5.0 (iPhone; CPU OS 14_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/30.0  Mobile/15E148 Safari/605.1.15', 'Antalya, Turkey', 0),
(12, 14, 14, 'a\\na', '1608552170', '176.232.60.167', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0', 'Antalya, Turkey', 0),
(13, 14, 14, 'test', '1608560366', '176.232.60.167', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0', 'Antalya, Turkey', 0),
(14, 14, 14, '5', '1608563699', '176.232.60.167', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0', 'Antalya, Turkey', 0),
(15, 14, 14, '6', '1608563753', '198.16.66.157', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0', 'Amsterdam, Netherlands', 0),
(16, 12, 4, 'Qwerty', '1609178229', '46.154.7.125', 'Mozilla/5.0 (Linux; Android 8.0.0; RNE-L21) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.101 Mobile Safari/537.36', 'Antalya, Turkey', 0),
(17, 16, 1, 'Yes, I\\\'m here!', '1651323846', '78.165.230.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36', 'Istanbul, Turkey', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comment_likes`
--

CREATE TABLE `comment_likes` (
  `cmtID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `tarih` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `comment_likes`
--

INSERT INTO `comment_likes` (`cmtID`, `userID`, `tarih`) VALUES
(2, 4, 1609178311),
(11, 1, 1636031112),
(17, 1, 1651323872);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `log_kayitlari`
--

CREATE TABLE `log_kayitlari` (
  `log_ID` int(11) NOT NULL,
  `logTuru` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `icerik` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `tarih_timestamp` int(11) NOT NULL,
  `tarih_yazi` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `ip` text NOT NULL,
  `konum` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `log_kayitlari`
--

INSERT INTO `log_kayitlari` (`log_ID`, `logTuru`, `userID`, `icerik`, `tarih_timestamp`, `tarih_yazi`, `ip`, `konum`) VALUES
(1, 0, 14, 'Otomatik giri? yapt?.', 1608563569, '21/12/2020 18:12', '176.232.60.167', 'Antalya, Turkey'),
(2, 0, 14, 'Çıkış yaptı.', 1608563638, '21/12/2020 18:13', '176.232.60.167', 'Antalya, Turkey'),
(3, 0, 14, 'Giriş yaptı.', 1608563652, '21/12/2020 18:14', '176.232.60.167', 'Antalya, Turkey'),
(4, 3, 14, 'Yorum yaptı. (ID: 14)', 1608563699, '21/12/2020 18:14', '176.232.60.167', 'Antalya, Turkey'),
(5, 3, 14, 'Yorum yaptı. (ID: 15)', 1608563753, '21/12/2020 18:15', '198.16.66.157', 'Amsterdam, Netherlands'),
(6, 0, 1, 'Otomatik giriş yaptı.', 1608566480, '21/12/2020 19:01', '176.232.60.167', 'Antalya, Turkey'),
(7, 0, 1, 'Otomatik giriş yaptı.', 1608569654, '21/12/2020 19:54', '176.232.60.167', 'Antalya, Turkey'),
(8, 0, 1, 'Otomatik giriş yaptı.', 1608572937, '21/12/2020 20:48', '176.232.60.167', 'Antalya, Turkey'),
(9, 0, 14, 'Otomatik giriş yaptı.', 1608580599, '21/12/2020 22:56', '176.232.60.167', 'Antalya, Turkey'),
(10, 0, 1, 'Otomatik giriş yaptı.', 1608585011, '22/12/2020 00:10', '176.232.60.167', 'Antalya, Turkey'),
(11, 0, 14, 'Otomatik giriş yaptı.', 1608590448, '22/12/2020 01:40', '176.232.60.167', 'Antalya, Turkey'),
(12, 0, 1, 'Otomatik giriş yaptı.', 1608603033, '22/12/2020 05:10', '176.232.60.167', 'Antalya, Turkey'),
(13, 0, 1, 'Otomatik giriş yaptı.', 1608629112, '22/12/2020 12:25', '176.232.60.167', 'Antalya, Turkey'),
(14, 0, 1, 'Otomatik giriş yaptı.', 1608629914, '22/12/2020 12:38', '176.232.60.167', 'Antalya, Turkey'),
(15, 0, 21, 'Otomatik giriş yaptı.', 1608630812, '22/12/2020 12:53', '78.187.91.109', 'Mersin, Turkey'),
(16, 0, 14, 'Otomatik giriş yaptı.', 1608655540, '22/12/2020 19:45', '176.232.60.167', 'Antalya, Turkey'),
(17, 0, 14, 'Otomatik giriş yaptı.', 1608721557, '23/12/2020 14:05', '176.232.60.167', 'Antalya, Turkey'),
(18, 0, 14, 'Çıkış yaptı.', 1608721562, '23/12/2020 14:06', '176.232.60.167', 'Antalya, Turkey'),
(19, 0, 1, 'Giriş yaptı.', 1608724593, '23/12/2020 14:56', '176.232.60.167', 'Antalya, Turkey'),
(20, 0, 1, 'Otomatik giriş yaptı.', 1608744814, '23/12/2020 20:33', '5.25.150.11', ', Turkey'),
(21, 0, 1, 'Giriş yaptı.', 1609064516, '27/12/2020 13:21', '5.25.160.50', ', Turkey'),
(22, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1609064516, '27/12/2020 13:21', '5.25.160.50', ', Turkey'),
(23, 0, 1, 'Giriş yaptı.', 1609064535, '27/12/2020 13:22', '5.25.160.50', ', Turkey'),
(24, 0, 4, 'Giriş yaptı.', 1609101689, '27/12/2020 23:41', '5.25.160.50', ', Turkey'),
(25, 0, 16, 'Giriş yaptı.', 1609102727, '27/12/2020 23:58', '85.99.22.228', 'Istanbul, Turkey'),
(26, 5, 16, 'Profil resmini değiştirdi.', 1609102805, '28/12/2020 00:00', '85.99.22.228', 'Istanbul, Turkey'),
(27, 5, 16, 'Doğum tarihini değiştirdi. (Yeni tarih: 01 Ara 1996)', 1609102823, '28/12/2020 00:00', '85.99.22.228', 'Istanbul, Turkey'),
(28, 0, 1, 'Otomatik giriş yaptı.', 1609151173, '28/12/2020 13:26', '5.25.160.50', ', Turkey'),
(29, 0, 16, 'Giriş yaptı.', 1609151638, '28/12/2020 13:33', '85.99.16.79', 'Istanbul, Turkey'),
(30, 0, 1, 'Çıkış yaptı.', 1609151675, '28/12/2020 13:34', '5.25.160.50', ', Turkey'),
(31, 0, 1, 'Giriş yaptı.', 1609151975, '28/12/2020 13:39', '5.25.160.50', ', Turkey'),
(32, 6, 1, 'Kullanıcıyı takipten çıktı. (ID: 16)', 1609152028, '28/12/2020 13:40', '5.25.160.50', ', Turkey'),
(33, 6, 1, 'Kullanıcıyı takip etti. (ID: 16)', 1609152031, '28/12/2020 13:40', '5.25.160.50', ', Turkey'),
(34, 0, 4, 'Otomatik giriş yaptı.', 1609153837, '28/12/2020 14:10', '5.25.160.50', ', Turkey'),
(35, 0, 1, 'Otomatik giriş yaptı.', 1609176970, '28/12/2020 20:36', '5.25.160.50', ', Turkey'),
(36, 0, 5, 'Giriş yaptı.', 1609177267, '28/12/2020 20:41', '5.25.160.50', ', Turkey'),
(37, 0, 5, 'Giriş yaptı.', 1609177522, '28/12/2020 20:45', '5.25.160.50', ', Turkey'),
(38, 0, 1, 'Otomatik giriş yaptı.', 1609177600, '28/12/2020 20:46', '5.25.160.50', ', Turkey'),
(39, 0, 4, 'Giriş yaptı.', 1609177978, '28/12/2020 20:52', '46.154.7.125', 'Antalya, Turkey'),
(40, 3, 4, 'Yorum yaptı. (ID: 16)', 1609178229, '28/12/2020 20:57', '46.154.7.125', 'Antalya, Turkey'),
(41, 0, 1, 'Otomatik giriş yaptı.', 1609187629, '28/12/2020 23:33', '5.25.160.50', ', Turkey'),
(42, 0, 1, 'Otomatik giriş yaptı.', 1609191626, '29/12/2020 00:40', '5.25.160.50', ', Turkey'),
(43, 0, 1, 'Otomatik giriş yaptı.', 1609242929, '29/12/2020 14:55', '5.25.160.50', ', Turkey'),
(44, 0, 1, 'Giriş yaptı.', 1609243128, '29/12/2020 14:58', '5.25.160.50', ', Turkey'),
(45, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1609243128, '29/12/2020 14:58', '5.25.160.50', ', Turkey'),
(46, 0, 1, 'Giriş yaptı.', 1609243134, '29/12/2020 14:58', '5.25.160.50', ', Turkey'),
(47, 0, 1, 'Giriş yaptı.', 1609259107, '29/12/2020 19:25', '5.25.160.50', ', Turkey'),
(48, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1609259108, '29/12/2020 19:25', '5.25.160.50', ', Turkey'),
(49, 0, 1, 'Giriş yaptı.', 1609364911, '31/12/2020 00:48', '5.25.167.190', ', Turkey'),
(50, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1609364912, '31/12/2020 00:48', '5.25.167.190', ', Turkey'),
(51, 0, 1, 'Giriş yaptı.', 1609364916, '31/12/2020 00:48', '5.25.167.190', ', Turkey'),
(52, 0, 1, 'Otomatik giriş yaptı.', 1609621102, '02/01/2021 23:58', '5.25.168.154', ', Turkey'),
(53, 0, 16, 'Otomatik giriş yaptı.', 1609622608, '03/01/2021 00:23', '46.106.96.81', 'Bursa, Turkey'),
(54, 0, 1, 'Giriş yaptı.', 1609938311, '06/01/2021 16:05', '5.25.168.154', ', Turkey'),
(55, 0, 1, 'Giriş yaptı.', 1610039032, '07/01/2021 20:03', '5.25.170.198', 'Izmir, Turkey'),
(56, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1610039032, '07/01/2021 20:03', '5.25.170.198', 'Izmir, Turkey'),
(57, 0, 1, 'Giriş yaptı.', 1610245342, '10/01/2021 05:22', '5.25.163.192', 'Izmir, Turkey'),
(58, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1610245342, '10/01/2021 05:22', '5.25.163.192', 'Izmir, Turkey'),
(59, 0, 1, 'Giriş yaptı.', 1610245345, '10/01/2021 05:22', '5.25.163.192', 'Izmir, Turkey'),
(60, 6, 1, 'Kullanıcıyı takip etti. (ID: 20)', 1610245431, '10/01/2021 05:23', '5.25.163.192', 'Izmir, Turkey'),
(61, 6, 1, 'Kullanıcıyı takipten çıktı. (ID: 20)', 1610245437, '10/01/2021 05:23', '5.25.163.192', 'Izmir, Turkey'),
(62, 6, 1, 'Kullanıcıyı takip etti. (ID: 20)', 1610245449, '10/01/2021 05:24', '5.25.163.192', 'Izmir, Turkey'),
(63, 0, 1, 'Giriş yaptı.', 1610744069, '15/01/2021 23:54', '5.25.162.102', 'Izmir, Turkey'),
(64, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1610744069, '15/01/2021 23:54', '5.25.162.102', 'Izmir, Turkey'),
(65, 0, 1, 'Giriş yaptı.', 1610744074, '15/01/2021 23:54', '5.25.162.102', 'Izmir, Turkey'),
(66, 0, 1, 'Giriş yaptı.', 1610746799, '16/01/2021 00:39', '5.25.162.102', 'Izmir, Turkey'),
(67, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1610746800, '16/01/2021 00:40', '5.25.162.102', 'Izmir, Turkey'),
(68, 0, 1, 'Giriş yaptı.', 1610746804, '16/01/2021 00:40', '5.25.162.102', 'Izmir, Turkey'),
(69, 0, 1, 'Otomatik giriş yaptı.', 1610811563, '16/01/2021 18:39', '5.25.162.102', 'Izmir, Turkey'),
(70, 0, 1, 'Giriş yaptı.', 1610811896, '16/01/2021 18:44', '5.25.162.102', 'Izmir, Turkey'),
(71, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1610811896, '16/01/2021 18:44', '5.25.162.102', 'Izmir, Turkey'),
(72, 0, 1, 'Giriş yaptı.', 1610811900, '16/01/2021 18:45', '5.25.162.102', 'Izmir, Turkey'),
(73, 0, 1, 'Otomatik giriş yaptı.', 1610818160, '16/01/2021 20:29', '5.25.162.102', 'Izmir, Turkey'),
(74, 0, 1, 'Otomatik giriş yaptı.', 1611006431, '19/01/2021 00:47', '5.25.172.36', 'Antalya, Turkey'),
(75, 0, 1, 'Otomatik giriş yaptı.', 1611159723, '20/01/2021 19:22', '5.25.169.201', 'Antalya, Turkey'),
(76, 0, 1, 'Giriş yaptı.', 1611281003, '22/01/2021 05:03', '5.25.169.201', 'Antalya, Turkey'),
(77, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1611281003, '22/01/2021 05:03', '5.25.169.201', 'Antalya, Turkey'),
(78, 0, 1, 'Giriş yaptı.', 1611281006, '22/01/2021 05:03', '5.25.169.201', 'Antalya, Turkey'),
(79, 0, 1, 'Otomatik giriş yaptı.', 1611281720, '22/01/2021 05:15', '5.25.169.201', 'Antalya, Turkey'),
(80, 0, 1, 'Otomatik giriş yaptı.', 1611283927, '22/01/2021 05:52', '5.25.169.201', 'Antalya, Turkey'),
(81, 0, 1, 'Otomatik giriş yaptı.', 1611611229, '26/01/2021 00:47', '46.154.19.188', 'Antalya, Turkey'),
(82, 0, 1, 'Otomatik giriş yaptı.', 1611611229, '26/01/2021 00:47', '46.154.19.188', 'Antalya, Turkey'),
(83, 0, 1, 'Otomatik giriş yaptı.', 1611611229, '26/01/2021 00:47', '46.154.19.188', 'Antalya, Turkey'),
(84, 0, 1, 'Otomatik giriş yaptı.', 1611611229, '26/01/2021 00:47', '46.154.19.188', 'Antalya, Turkey'),
(85, 0, 1, 'Otomatik giriş yaptı.', 1611622361, '26/01/2021 03:52', '5.25.172.167', 'Antalya, Turkey'),
(86, 0, 1, 'Otomatik giriş yaptı.', 1612045940, '31/01/2021 01:32', '46.154.4.76', 'Antalya, Turkey'),
(87, 0, 5, 'Giriş yaptı.', 1612773891, '08/02/2021 11:44', '46.154.27.16', 'Antalya, Turkey'),
(88, 0, 1, 'Giriş yaptı.', 1613162586, '12/02/2021 23:43', '46.154.27.51', 'Antalya, Turkey'),
(89, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1613162586, '12/02/2021 23:43', '46.154.27.51', 'Antalya, Turkey'),
(90, 0, 1, 'Giriş yaptı.', 1613162590, '12/02/2021 23:43', '46.154.27.51', 'Antalya, Turkey'),
(91, 0, 1, 'Otomatik giriş yaptı.', 1613477675, '16/02/2021 15:14', '31.223.78.214', 'Adana, Turkey'),
(92, 0, 1, 'Giriş yaptı.', 1615390875, '10/03/2021 18:41', '31.223.79.91', 'Adana, Turkey'),
(93, 0, 1, 'Giriş yaptı.', 1616073491, '18/03/2021 16:18', '31.223.78.226', 'Adana, Turkey'),
(94, 0, 1, 'Otomatik giriş yaptı.', 1616247261, '20/03/2021 16:34', '31.223.78.234', 'Adana, Turkey'),
(95, 0, 4, 'Giriş yaptı.', 1616412379, '22/03/2021 14:26', '31.142.41.172', 'Izmir, Turkey'),
(96, 0, 1, 'Otomatik giriş yaptı.', 1616706819, '26/03/2021 00:13', '31.223.78.185', 'Adana, Turkey'),
(97, 0, 1, 'Otomatik giriş yaptı.', 1616945006, '28/03/2021 18:23', '31.223.78.159', 'Adana, Turkey'),
(98, 0, 1, 'Giriş yaptı.', 1618312988, '13/04/2021 14:23', '31.223.79.83', 'Adana, Turkey'),
(99, 0, 1, 'Otomatik giriş yaptı.', 1618656610, '17/04/2021 13:50', '31.223.79.37', 'Adana, Turkey'),
(100, 0, 1, 'Otomatik giriş yaptı.', 1618759882, '18/04/2021 18:31', '31.223.79.37', 'Adana, Turkey'),
(101, 0, 1, 'Otomatik giriş yaptı.', 1618773812, '18/04/2021 22:23', '31.223.79.37', 'Adana, Turkey'),
(102, 0, 1, 'Giriş yaptı.', 1620462712, '08/05/2021 11:31', '31.223.79.52', 'Adana, Turkey'),
(103, 0, 1, 'Otomatik giriş yaptı.', 1620548701, '09/05/2021 11:25', '31.223.79.52', 'Adana, Turkey'),
(104, 0, 4, 'Giriş yaptı.', 1622299455, '29/05/2021 17:44', '46.2.232.62', 'Istanbul, Turkey'),
(105, 0, 1, 'Giriş yaptı.', 1622631983, '02/06/2021 14:06', '31.206.30.52', 'Istanbul, Turkey'),
(106, 6, 1, 'Kullanıcıyı takipten çıktı. (ID: 20)', 1622633904, '02/06/2021 14:38', '31.206.30.52', 'Istanbul, Turkey'),
(107, 6, 1, 'Kullanıcıyı takip etti. (ID: 20)', 1622633907, '02/06/2021 14:38', '31.206.30.52', 'Istanbul, Turkey'),
(108, 0, 1, 'Giriş yaptı.', 1624447417, '23/06/2021 14:23', '31.223.78.217', 'Adana, Turkey'),
(109, 0, 1, 'Otomatik giriş yaptı.', 1624577292, '25/06/2021 02:28', '31.223.78.217', 'Adana, Turkey'),
(110, 0, 1, 'Otomatik giriş yaptı.', 1625413105, '04/07/2021 18:38', '31.223.78.179', 'Adana, Turkey'),
(111, 0, 1, 'Giriş yaptı.', 1626224179, '14/07/2021 03:56', '31.223.78.165', 'Adana, Turkey'),
(112, 0, 1, 'Otomatik giriş yaptı.', 1626595004, '18/07/2021 10:56', '31.223.79.14', 'Adana, Turkey'),
(113, 0, 1, 'Giriş yaptı.', 1627729226, '31/07/2021 14:00', '31.223.79.51', 'Adana, Turkey'),
(114, 0, 1, 'Giriş yaptı.', 1630140016, '28/08/2021 11:40', '31.223.78.158', 'Adana, Turkey'),
(115, 0, 4, 'Giriş yaptı.', 1630254012, '29/08/2021 19:20', '78.174.78.158', 'Kahramanmara?, Turkey'),
(116, 0, 1, 'Otomatik giriş yaptı.', 1631172635, '09/09/2021 10:30', '31.223.78.246', 'Adana, Turkey'),
(117, 0, 1, 'Giriş yaptı.', 1633635098, '07/10/2021 22:31', '31.223.79.29', 'Adana, Turkey'),
(118, 0, 1, 'Otomatik giriş yaptı.', 1633807206, '09/10/2021 22:20', '31.223.79.29', 'Adana, Turkey'),
(119, 0, 1, 'Otomatik giriş yaptı.', 1634166517, '14/10/2021 02:08', '31.223.79.86', 'Adana, Turkey'),
(120, 0, 1, 'Otomatik giriş yaptı.', 1634223740, '14/10/2021 18:02', '31.223.79.86', 'Adana, Turkey'),
(121, 0, 1, 'Giriş yaptı.', 1634402078, '16/10/2021 19:34', '46.154.67.121', 'Antalya, Turkey'),
(122, 0, 1, 'Otomatik giriş yaptı.', 1636031070, '04/11/2021 16:04', '46.155.149.135', 'Izmir, Turkey'),
(123, 0, 1, 'Giriş yaptı.', 1636111794, '05/11/2021 14:29', '31.223.79.40', 'Adana, Turkey'),
(124, 0, 1, 'Atıldı. (Cookie uyuşmazlığı ihtimali)', 1636111795, '05/11/2021 14:29', '31.223.79.40', 'Adana, Turkey'),
(125, 0, 1, 'Giriş yaptı.', 1636111799, '05/11/2021 14:29', '31.223.79.40', 'Adana, Turkey'),
(126, 0, 1, 'Otomatik giriş yaptı.', 1636467345, '09/11/2021 17:15', '31.223.79.84', 'Adana, Turkey'),
(127, 0, 1, 'Otomatik giriş yaptı.', 1636474680, '09/11/2021 19:18', '31.223.79.84', 'Adana, Turkey'),
(128, 0, 1, 'Giriş yaptı.', 1637580004, '22/11/2021 14:20', '46.106.246.60', 'Istanbul, Turkey'),
(129, 0, 1, 'Otomatik giriş yaptı.', 1637604435, '22/11/2021 21:07', '46.106.246.60', 'Istanbul, Turkey'),
(130, 0, 1, 'Giriş yaptı.', 1638904292, '07/12/2021 22:11', '31.223.79.63', 'Adana, Turkey'),
(131, 1, 22, 'Kayıt oldu.', 1646254799, '02/03/2022 23:59', '88.248.36.32', 'Mardin, Turkey'),
(132, 1, 23, 'Kayıt oldu.', 1648711675, '31/03/2022 10:27', '18.192.120.36', 'Frankfurt am Main, Germany'),
(133, 2, 23, 'Gönderi paylaştı. (ID: 17)', 1648711723, '31/03/2022 10:28', '18.192.120.36', 'Frankfurt am Main, Germany'),
(134, 0, 1, 'Giriş yaptı.', 1649688680, '11/04/2022 17:51', '78.165.78.139', 'Antakya, Turkey'),
(135, 0, 1, 'Giriş yaptı.', 1650155106, '17/04/2022 03:25', '31.223.79.47', 'Adana, Turkey'),
(136, 0, 1, 'Otomatik giriş yaptı.', 1650431622, '20/04/2022 08:13', '31.223.78.197', 'Adana, Turkey'),
(137, 0, 1, 'Giriş yaptı.', 1651323808, '30/04/2022 16:03', '78.165.230.128', 'Istanbul, Turkey'),
(138, 3, 1, 'Yorum yaptı. (ID: 17)', 1651323846, '30/04/2022 16:04', '78.165.230.128', 'Istanbul, Turkey'),
(139, 0, 1, 'Giriş yaptı.', 1655819203, '21/06/2022 16:46', '88.225.27.94', 'Istanbul, Turkey'),
(140, 0, 1, 'Giriş yaptı.', 1657053254, '05/07/2022 23:34', '46.154.81.226', 'Antalya, Turkey'),
(141, 2, 1, 'Gönderi paylaştı. (ID: 18)', 1657053280, '05/07/2022 23:34', '46.154.81.226', 'Antalya, Turkey');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `posts`
--

CREATE TABLE `posts` (
  `ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `post` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postTime` varchar(24) COLLATE utf8_turkish_ci NOT NULL,
  `postCategory` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `IP` varchar(24) COLLATE utf8_turkish_ci NOT NULL,
  `device` varchar(256) COLLATE utf8_turkish_ci NOT NULL,
  `location` varchar(128) COLLATE utf8_turkish_ci NOT NULL,
  `silindi` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `posts`
--

INSERT INTO `posts` (`ID`, `userID`, `post`, `postTime`, `postCategory`, `IP`, `device`, `location`, `silindi`) VALUES
(1, 4, 'Time test after resetting posts.', '1600078482', '1', '', '', '', 0),
(2, 4, 'test', '1600078851', '1', '', '', '', 0),
(3, 4, 'test', '1600079042', '1', '', '', '', 0),
(4, 4, 'asd', '1600079904', '1', '', '', '', 0),
(5, 4, 'Test', '1600175659', '2', '', '', '', 0),
(6, 10, 'Test gönderi.', '1600192642', '1', '', '', '', 0),
(7, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas elementum sed elit eu sollicitudin. Fusce tempor non augue a viverra. Cras aliquam tristique vestibulum. Nunc molestie molestie elementum. Ut blandit id justo eu ultricies. Suspendiss', '1600197071', '2', '', '', '', 0),
(8, 1, 'test.', '1601571086', '2', '', '', '', 0),
(9, 16, 'Heeeeey', '1602193543', '4', '', '', '', 1),
(10, 1, 'asd', '1602233702', '3', '', '', '', 0),
(11, 1, 'Info check.', '1602375645', '1', '46.154.15.203', 'Mozilla/5.0 (iPhone; CPU OS 14_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/28.2  Mobile/15E148 Safari/605.1.15', ', Turkey', 0),
(12, 1, 'Info test.', '1602450663', '2', '176.43.199.225', 'Mozilla/5.0 (iPhone; CPU OS 14_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/28.2  Mobile/15E148 Safari/605.1.15', 'Antalya, Turkey', 0),
(13, 5, 'User post test.', '1603203096', '1', '176.43.194.69', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0', 'Antalya, Turkey', 0),
(14, 14, 'Test.', '1604425109', '1', '94.123.163.250', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36', 'Kahramanmaraş, Turkey', 0),
(15, 20, 'Benim üniversitem neden eklenmemiş? :D\\nSivas Cumhuriyet Üniversitesi istiyoruz', '1608489235', '1', '176.239.210.242', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36', 'Ankara, Turkey', 0),
(16, 1, 'Houston... Can you hear me?', '1608547728', '3', '176.232.60.167', 'Mozilla/5.0 (iPhone; CPU OS 14_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/30.0  Mobile/15E148 Safari/605.1.15', 'Antalya, Turkey', 0),
(17, 23, 'bum', '1648711723', '1', '18.192.120.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36 Edg/99.0.1150.55', 'Frankfurt am Main, Germany', 0),
(18, 1, 'Tırrik', '1657053280', '2', '46.154.81.226', 'Mozilla/5.0 (Android 12; Mobile; rv:102.0) Gecko/102.0 Firefox/102.0', 'Antalya, Turkey', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `post_likes`
--

CREATE TABLE `post_likes` (
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `tarih` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `post_likes`
--

INSERT INTO `post_likes` (`postID`, `userID`, `tarih`) VALUES
(7, 4, 1608411600),
(6, 1, 1608411600),
(7, 15, 1608411600),
(6, 15, 1608411600),
(5, 15, 1608411600),
(4, 15, 1608411600),
(7, 1, 1608411600),
(10, 17, 1608411600),
(12, 1, 1608411600),
(14, 14, 1608411600),
(13, 1, 1608411600),
(15, 14, 1608411600),
(15, 20, 1608411600),
(14, 20, 1608411600),
(15, 16, 1609151835),
(5, 4, 1609178301),
(8, 1, 1637580020),
(16, 1, 1651323886);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sifre_sifirlama`
--

CREATE TABLE `sifre_sifirlama` (
  `sfrSifirlaID` int(11) NOT NULL,
  `sfrSifirlaEmail` text NOT NULL,
  `sfrSifirlaSelector` text NOT NULL,
  `sfrSifirlaToken` longtext NOT NULL,
  `sfrSifirlaSure` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `sifre_sifirlama`
--

INSERT INTO `sifre_sifirlama` (`sfrSifirlaID`, `sfrSifirlaEmail`, `sfrSifirlaSelector`, `sfrSifirlaToken`, `sfrSifirlaSure`) VALUES
(6, 'kaya_ibrahim@msn.com', '96e3f0e913b1e8fd', '$2y$10$XTcfLQdCOoz1ib5WJ9goquSM.EfWm6XvfIo/73cvX5W6NJ9HEZGvO', '1622301236');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Username` varchar(24) COLLATE utf8_turkish_ci NOT NULL,
  `Password` varchar(128) COLLATE utf8_turkish_ci NOT NULL,
  `EMail` varchar(36) COLLATE utf8_turkish_ci NOT NULL,
  `profilePic` varchar(128) COLLATE utf8_turkish_ci NOT NULL DEFAULT '',
  `coverPic` varchar(128) COLLATE utf8_turkish_ci NOT NULL,
  `kayitTarihi` varchar(24) COLLATE utf8_turkish_ci NOT NULL,
  `Uni` int(11) NOT NULL DEFAULT '0',
  `dogumTarihi` varchar(24) COLLATE utf8_turkish_ci NOT NULL DEFAULT '0',
  `Onayli` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`ID`, `Username`, `Password`, `EMail`, `profilePic`, `coverPic`, `kayitTarihi`, `Uni`, `dogumTarihi`, `Onayli`) VALUES
(1, 'XpDeviL', '827ccb0eea8a706c4c34a16891f84e7b', 'kaya_ibrahim@msn.com', 'https://i1.wp.com/xpdevil.com/wp-content/uploads/2017/11/rounded-icon.png', '/uploads/cover_pics/cp_1.png', '1602885563', 2, '30 Haz 1995', 1),
(3, 'Admin', '81dc9bdb52d04dc20036dbd8313ed055', '1@1', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 1),
(4, 'base', '81dc9bdb52d04dc20036dbd8313ed055', '2@2', '/uploads/pp_4.jpeg', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 2, '6 Mar 1996', 1),
(5, 'User', '81dc9bdb52d04dc20036dbd8313ed055', 'my@mail.com', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(6, 'another user', '81dc9bdb52d04dc20036dbd8313ed055', 'mail2@mail.com', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(7, 'user3', '81dc9bdb52d04dc20036dbd8313ed055', '123@1234', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 5, '0', 0),
(8, 'user4', '81dc9bdb52d04dc20036dbd8313ed055', '3@3', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(9, 'user5', '81dc9bdb52d04dc20036dbd8313ed055', '5@5', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(10, 'benimadim24karakterlibir', '81dc9bdb52d04dc20036dbd8313ed055', 'asd@123.com', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(11, 'dilara', 'b4d202c57e84fe541db42e011e58f73d', 'Dilarahacerkaya@gmail.com', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(12, 'rumuz', '81dc9bdb52d04dc20036dbd8313ed055', 'my@m2ail.com', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(13, 'wed', '81dc9bdb52d04dc20036dbd8313ed055', 'mail@mails.com', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(14, 'Tester', '81dc9bdb52d04dc20036dbd8313ed055', 'djdk@djkd.com', '/uploads/profile_pics/pp_14.png', '/uploads/cover_pics/cp_14.png', '1602885563', 0, '0', 0),
(15, 'Samed', 'd7322ed717dedf1eb4e6e52a37ea7bcd', 'samed.sahin.07@gmail.com', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(16, 'Tknn', '9c3b257ab4ad1fdfd892a35ff9ce3bd5', 'tulayklkn1@gmail.com', '/uploads/profile_pics/pp_16.png', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '01 Ara 1996', 0),
(17, 'linqinprk', '53a3e40e68c15fa678fddf11c2b5acda', 'devkartal57@gmail.com', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(18, 'rmysustbs', '98be405608ed99325d4217d19b40345f', 'ustabasrumeysa@gmail.com', '', 'https://i.pinimg.com/originals/93/ed/17/93ed175d22fa85e009e67c18963ccb94.jpg', '1602885563', 0, '0', 0),
(20, 'adamkarga', '4dd9367d2223b6d545ad61506168f70a', 'adamkarga.net@gmail.com', '/uploads/profile_pics/pp_20.png', '/uploads/cover_pics/cp_20.png', '1608489181', 1, '22 Kas 1992', 0),
(21, 'rabbit13', '696e5b582b43215b5e2a3a545c8264fd', 'rabiacayir39@gmail.com', '', '', '1608557334', 0, '0', 0),
(22, 'testtt', '0020227927113dbf36cd6aa9b2a34356', 'test4747@gmail.com', '', '', '1646254799', 0, '0', 0),
(23, 'Matthew Harper', 'e10adc3949ba59abbe56e057f20f883e', 'testtt@gmail.com', '', '', '1648711675', 0, '0', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_follows`
--

CREATE TABLE `user_follows` (
  `FollowerID` int(11) NOT NULL,
  `FollowingID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `user_follows`
--

INSERT INTO `user_follows` (`FollowerID`, `FollowingID`) VALUES
(1, 4),
(1, 16),
(1, 15),
(17, 1),
(4, 5),
(1, 20);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_sessions`
--

CREATE TABLE `user_sessions` (
  `session_id` int(11) NOT NULL,
  `session_userid` int(11) NOT NULL,
  `session_token` varchar(34) CHARACTER SET latin1 NOT NULL,
  `session_serial` varchar(34) CHARACTER SET latin1 NOT NULL,
  `session_date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `user_sessions`
--

INSERT INTO `user_sessions` (`session_id`, `session_userid`, `session_token`, `session_serial`, `session_date`) VALUES
(108, 1, 'n89tQ0eHnxxpiakV1ujHcQTAyv6DvCxF', 'QcuAtjaxiluFQUu89D4xeMaV1qekxylI', 1657053254),
(2, 6, '1nxYHxsjnpwkQaCeFFxqeV6NFQnZevvW', 'inxT6pACH7Yew9vtDFsjxoxUa7eekQQH', 1603203036),
(81, 5, '08pqvIQtMQiuxAvxnjY4xs1e7kwZoxeW', 'Qtjekqal4qWv8NHFox6n0xeuQTZcAQxF', 1612773891),
(95, 4, 'wn7oFISAo7VQFnxqu9vxjly0xvQTUuen', 'tC9eeFyxVl8sv77IvHZaHT1M6DFAn4Fn', 1630254012),
(53, 14, 'xleQFAe9tqZ47iuwjDnUnxFNQ8yMlkYc', 'nZeIxuQ71Vqtk9ceH0TFeno6lUDj8vsj', 1608563652),
(47, 20, '6ncQuixD8xUsxueFqjMk0xQ89ukWNYZ7', 'ZnMiaoakUjcxSFxopFx79HyQelvVlkjH', 1608489181),
(49, 7, 'nQYn0ZeF9eotcyHx7uaulU1Cji8owWVa', 'oHN80jnxU7QFHn6i91eI7Quu8DTlAvja', 1608555414),
(51, 21, 'Fv80s9yQSYqHxxFQHcoUenxVtMn7uwxA', 'ea8CVj7xpDIQAZ78snkFF6wia94kYovN', 1608557334),
(59, 16, 'natj8elTekQFq0wxuvjueIDiu8vWFQoc', 'ciFyuTnUwFpaxue9k7AjQnuM0FHvZQQD', 1609151638),
(102, 22, 'Fue8jQFvxZAHpkc6HI98svaQxFjuTk1x', 'cuqs9ovxHF878kQYpyFk0oCexIDSjUT4', 1646254799),
(103, 23, 'YU7xuH8HaonQquSVZ6xN4aDq1nulFnTw', 'cx7ojqnp4yDuFjuFTsAxva6QuSYekQUC', 1648711675);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `bildirimler`
--
ALTER TABLE `bildirimler`
  ADD PRIMARY KEY (`n_id`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `log_kayitlari`
--
ALTER TABLE `log_kayitlari`
  ADD PRIMARY KEY (`log_ID`);

--
-- Tablo için indeksler `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `sifre_sifirlama`
--
ALTER TABLE `sifre_sifirlama`
  ADD PRIMARY KEY (`sfrSifirlaID`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `bildirimler`
--
ALTER TABLE `bildirimler`
  MODIFY `n_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `log_kayitlari`
--
ALTER TABLE `log_kayitlari`
  MODIFY `log_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- Tablo için AUTO_INCREMENT değeri `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `sifre_sifirlama`
--
ALTER TABLE `sifre_sifirlama`
  MODIFY `sfrSifirlaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
