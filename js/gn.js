function openSlideMenu(){
    document.getElementById('menu').style.width = '250px';
    document.getElementById('av').style.opacity = "0";
}
function closeSlideMenu(){
    document.getElementById('menu').style.width = '0px';
    document.getElementById('av').style.opacity = "1";
}

function uyeolModalGoster(){
    $('#m_kapat').html("<span style='float: right;'><i class='fas fa-times'></i></span>");
    modalAc();
    m_id.innerHTML = `
    <div class="right_login">
        <p style="color: #000; text-align: center; font-family: 'Montserrat';">Üniversitende olan biten her şey bir tık uzağında!</p>
        <p style="color: #000; text-align: center; font-family: 'Montserrat'">base'in tüm özelliklerinden faydalanmak için hemen şimdi üye olabilirsin!</p>
        <a class="home_reg-btn" href="/turnike/uyeol">Kayıt Ol</a>
        <a class="home_log-btn" href="/turnike">Giriş Yap</a>
    </div>
    `;
}

$(document).ready(function() {
    $('#bildirimleri-sil').click(function(){
        $.post("/notify", {act: 4}, function(data){
            if(data === "basarili")
            {
                $('#notifi-icerik').css('opacity', '0');
                setTimeout(function(){
                    $('#notifi-icerik').html('<p style="color: #666; font-style: italic; text-align: center;">(Bildiriminiz yok)</p>');
                    $('#notifi-icerik').css('opacity', '1');
                }, 400);
            }
            else
            {
                alert('Bir sorun oluştu!');
            }
        });
    });
});

function bildirimSil(id) {
    $.post("/notify", {act: 3, noti_id:id}, function(data){
        if(data === "basarili")
        {
            $('#n_'+id).css('opacity', '0');
            $('#n_'+id).parent().css('transform', 'scaleY(0)');
            $('#n_'+id).parent().prev('div').css('opacity', '0');
            setTimeout(function(){
                $('#n_'+id).parent().css('display', 'none');
                $('#n_'+id).parent().prev('div').css('display', 'none');
            }, 400);
        }
        else
        {
            alert('Bir sorun oluştu!');
        }
    });
}

function modalAc() {
    modalid.style.maxWidth = '700px';
    modalid.style.width = '80%';
    modal.style.visibility = "visible";
    modal.style.opacity = "1";
    modalid.style.transform = "scaleY(1)";
    document.body.style.overflow = 'hidden';
}

function modalKapat() {
    document.getElementById("myModal").style.opacity="0";
    document.getElementById("modalid").style.transform="scaleY(0)";
    setTimeout(function(){
        document.getElementById("myModal").style.visibility = "hidden";
        document.body.style.overflow = 'auto';
        m_id.innerHTML = "";
    }, 300);
}