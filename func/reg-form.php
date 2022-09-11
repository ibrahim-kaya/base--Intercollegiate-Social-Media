
<style>

    input[type="checkbox"] {
        display:none;
        transition: all .4s;
    }


    input[type="checkbox"] + label::before {
        width: 15px;
        height: 15px;
        border-radius: 15px;
        border: 2px solid #8cad2d;
        background-color: transparent;
        display: block;
        content: "";
        float: left;
        margin-right: 5px;
    }
    input[type="checkbox"]:checked+label::before {
        box-shadow: inset 0px 0px 0px 3px #CBE5F6;
        background-color: #8cad2d;
    }

</style>

<head>
    <title>Base ~ Kaydol</title>
</head>

<div style="margin-top: 10px; text-align: center; padding: 20px 0; background-color: #F3B9BD; box-shadow: 0px -4px 8px 0px rgba(0,0,0,0.2); display: flex; justify-content: center;">
    <svg version="1.1" width="36" height="36" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path xmlns="http://www.w3.org/2000/svg" style="" d="M318.136,458.514H49.709v-84.505c0.06-41.159,33.404-74.503,74.563-74.563h97.727h4.971  c81.642,0.338,148.112-65.566,148.45-147.217c0.338-81.652-65.566-148.102-147.217-148.45S80.101,69.354,79.753,150.996  c-0.149,36.377,13.113,71.531,37.262,98.741C51.25,253.635-0.06,308.135,0,374.009v109.359c0,13.73,11.125,24.854,24.854,24.854  h293.282c13.73,0,24.854-11.125,24.854-24.854S331.866,458.514,318.136,458.514z M226.97,54.879  c53.845,1.541,96.246,46.428,94.705,100.272c-1.442,50.604-41.378,91.693-91.921,94.586h-7.755  c-53.755-3.38-94.596-49.699-91.216-103.454C133.985,95.332,175.929,55.476,226.97,54.879z" fill="#000000" data-original="#ff485a" class=""/><path style="" d="M487.146,398.864H338.019c-13.73,0-24.854-11.125-24.854-24.854s11.125-24.854,24.854-24.854   h149.126c13.73,0,24.854,11.125,24.854,24.854S500.875,398.864,487.146,398.864z" fill="#000000" data-original="#ffbbc0" class=""/>	<path style="" d="M412.583,473.427c-13.73,0-24.854-11.125-24.854-24.854V299.446   c0-13.73,11.125-24.854,24.854-24.854s24.854,11.125,24.854,24.854v149.126C437.437,462.302,426.312,473.427,412.583,473.427z" fill="#000000" data-original="#ffbbc0" class=""/></g></svg>
    <p style="margin: 10px; font-family: 'Gugi'; font-size: 18pt;">Hesap Olustur</p>
</div>

<div class="form-box">

    <div class="social-icons">
        <img src="/images/fb.png"/>
        <img src="/images/tw.png"/>
        <img src="/images/gp.png"/>
    </div>
    <?php include('errors.php'); ?>

    <form id="reg-form" class="log-form" method="post" action="">
        <div style="margin: 30px; display: flex; flex-direction: column; align-items: center;">
            <div class="item-cont">
                <div class="input-icon"><i style="height: 100%;" class="fas fa-user"></i></div>
                <input type="text" class="log-form input" name="username" placeholder="Kullanıcı Adı" required>
            </div>
            <div class="item-cont">
                <div class="input-icon"><i style="height: 100%;" class="fas fa-lock"></i></div>
                <input type="password" class="log-form input" name="password_1" placeholder="Şifre" required>
            </div>
            <div class="item-cont">
                <div class="input-icon"><i style="height: 100%;" class="fas fa-lock"></i></div>
                <input type="password" class="log-form input" name="password_2" placeholder="Şifre (bi' daha)" required>
            </div>
            <div class="item-cont">
                <div class="input-icon"><i style="height: 100%;" class="fas fa-envelope"></i></div>
                <input type="email" class="log-form input" name="email" placeholder="E-Posta Adresi" required>
            </div>
        </div>

        <div style="display: flex; justify-content: center;">
            <input required type="checkbox" id="sozlesme-cb" class="log-form check-box"><label for="sozlesme-cb" style="display: inline; font-size: 10.5pt;"><a href="#" target="_blank">Kullanıcı sözleşmesi</a>ni iyice okudum ve kabul ediyorum.</label></div>
        <button type="submit" class="log-form submit-btn" name="reg_user" style="margin-top: 30px;" onclick="if(!document.getElementById('sozlesme-cb').checked){alert('Sözleşmeyi kabul etmeden şurdan şuraya salmam!')}">Beni Üye Eyle</button>
    </form>
</div>

<div style="background-color: #CEF4BB; height: 100px; padding-top: 20px; text-align: center; margin-bottom: 50px; box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.2);">
    <p style="margin: 0 0 10px 0;">Zaten bir hesabın var mı?</p>
    <a href="/turnike" class="log-form submit-btn" style="text-decoration: none; width: max-content;">Giriş Yap</a>
</div>
