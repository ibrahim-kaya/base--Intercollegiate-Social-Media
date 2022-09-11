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
        <h1 style="line-height: 30px;">Sevgili <?php echo $_SESSION['mail_isim']; ?>,</h1>
        <p>Üniversiteler arası sosyal medya platformu olan base.com’un yayın hayatına geçtiğini duyurmaktan kıvanç duyarız!</p>
        <p>Ve bu vesileyle, base ekibi olarak, sizleri de aramızda görmeyi çok isteriz.</p>
        <p>Bizi yalnız bırakmayacağınızı umuyoruz. </p><br>
        <p>En içten dileklerimizle,</p>
        <p>base.com ekibi</p><br>

        <a style="text-align: center; color: #fff; border: 1px solid #69CA48; padding: 10px; border-radius: 10px; background-color: #80D0FF;" href="https://base.xpdevil.com/turnike/uyeol">Hemen Katıl!</a>

        <p style="text-align: center; font-size: 11px; margin-top: 50px;"><a href="#">Yardım</a> · <a href="#">İletişim</a><br>Copyright 2020© <a href="#">base.com</a></pstyle>
    </div>
</div>
</body>
</html>