<!DOCTYPE html>
<html>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Exo+2:wght@300&display=swap');

        h1 {
            font-family: 'Dancing Script', cursive;
        }

        body {
            font-family: 'Exo 2', sans-serif;
        }

        #icerik {
            display: block;
            margin: 15px;
            padding: 20px;
            background-color: #eeeeff;
            box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.3);
            border-radius: 20px;
        }

        #icerik a{
            color: #477AC2;
            text-decoration: none;
        }
    </style>
</head>

<body>
<div>
    <div id="icerik">
        <div style="text-align: center;"><img src="https://base.xpdevil.com/images/icon.png" height="64px" width="64px" /></div>
        <h1 style="line-height: 30px;">Aramıza hoşgeldin, <?php echo $_SESSION['mail_isim']; ?>!</h1>
        <p>base ailesi olarak seni aramızda gördüğümüze ne kadar sevindik anlatamam! Artık paylaşım yapmaya başlayabilir, yapılan paylaşımları takip edebilirsin.</p>
        <p>Hemen bir üniversite sayfasına girip olan bitenleri görüntüleyebilirsin!</p>
        <p>Aklından geçenleri paylaşmaktan çekinme! Hoş vakit geçirmeni dileriz.</p><br>
        <p>Teşekkürler,</p>
        <p>base.com ekibi</p><br>
        <p style="text-align: center; font-size: 11px;"><a href="#">Yardım</a> · <a href="#">İletişim</a><br>Copyright 2020© <a href="#">base.com</a></pstyle>
    </div>
</div>
</body>
</html>