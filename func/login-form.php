<head>
    <title>Base ~ Giriş Yap</title>
</head>

<div style="margin-top: 10px; text-align: center; padding: 20px 0; background-color: #F3B9BD; box-shadow: 0px -4px 8px 0px rgba(0,0,0,0.2); display: flex; justify-content: center;">
    <svg height="32pt" viewBox="0 0 512 512" width="32pt" xmlns="http://www.w3.org/2000/svg"><path d="m192 213.332031c-58.816406 0-106.667969-47.847656-106.667969-106.664062 0-58.816407 47.851563-106.667969 106.667969-106.667969s106.667969 47.851562 106.667969 106.667969c0 58.816406-47.851563 106.664062-106.667969 106.664062zm0-181.332031c-41.171875 0-74.667969 33.492188-74.667969 74.667969 0 41.171875 33.496094 74.664062 74.667969 74.664062s74.667969-33.492187 74.667969-74.664062c0-41.175781-33.496094-74.667969-74.667969-74.667969zm0 0"/><path d="m474.667969 490.667969h-117.335938c-20.585937 0-37.332031-16.746094-37.332031-37.335938v-74.664062c0-20.589844 16.746094-37.335938 37.332031-37.335938h117.335938c20.585937 0 37.332031 16.746094 37.332031 37.335938v74.664062c0 20.589844-16.746094 37.335938-37.332031 37.335938zm-117.335938-117.335938c-2.941406 0-5.332031 2.390625-5.332031 5.335938v74.664062c0 2.945313 2.390625 5.335938 5.332031 5.335938h117.335938c2.941406 0 5.332031-2.390625 5.332031-5.335938v-74.664062c0-2.945313-2.390625-5.335938-5.332031-5.335938zm0 0"/><path d="m453.332031 373.332031h-74.664062c-8.832031 0-16-7.167969-16-16v-48c0-29.394531 23.933593-53.332031 53.332031-53.332031s53.332031 23.9375 53.332031 53.332031v48c0 8.832031-7.167969 16-16 16zm-58.664062-32h42.664062v-32c0-11.753906-9.578125-21.332031-21.332031-21.332031s-21.332031 9.578125-21.332031 21.332031zm0 0"/><path d="m266.667969 448h-250.667969c-8.832031 0-16-7.167969-16-16v-74.667969c0-55.871093 45.460938-101.332031 101.332031-101.332031h186.667969c17.835938 0 35.390625 4.714844 50.753906 13.652344 7.636719 4.4375 10.214844 14.230468 5.78125 21.867187-4.4375 7.660157-14.230468 10.21875-21.890625 5.78125-10.472656-6.078125-22.464843-9.300781-34.644531-9.300781h-186.667969c-38.226562 0-69.332031 31.105469-69.332031 69.332031v58.667969h234.667969c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/></svg>
    <p style="margin: 10px; font-family: 'Gugi'; font-size: 18pt;">Giris Yap</p>
</div>

<div class="form-box">

    <div class="social-icons">
        <p style="font-family: 'Bai Jamjuree', sans-serif; font-size: 14px;">Sosyal medya ile giriş:</p>
        <img src="/images/fb.png"/>
        <img src="/images/tw.png"/>
        <img src="/images/gp.png"/>
    </div>

    <?php include('errors.php'); ?>

    <form id="login-form" class="log-form" method="post" action="">
        <div style="margin-top: 50px; display: flex; flex-direction: column; align-items: center;">
            <div class="item-cont">
                <div class="input-icon"><i style="height: 100%;" class="fas fa-user"></i></div>
                <input type="text" class="log-form input" name="username" placeholder="Kullanıcı Adı veya E-Mail" required>
            </div>
            <div class="item-cont">
                <div class="input-icon"><i style="height: 100%;" class="fas fa-lock"></i></div>
                <input type="password" class="log-form input" name="password" placeholder="Şifre" required>
            </div>
            <a style="font-size: 9pt;" href="/sifremi-unuttum"><i class="fas fa-question"></i> Şifreyi unuttuk iyi mi</a>
        </div>
        <button type="submit" class="log-form submit-btn" name="login_user">Girişimi Yap</button>
    </form>

</div>

<div style="background-color: #CEF4BB; height: 100px; padding-top: 20px; text-align: center; margin-bottom: 50px; box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.2);">
    <p style="margin: 0 0 10px 0;">Yoksa senin bir hesabın yok mu?</p>
    <a href="/turnike/uyeol" class="log-form submit-btn" style="text-decoration: none; width: max-content;">Hemen Kaydol!</a>
</div>