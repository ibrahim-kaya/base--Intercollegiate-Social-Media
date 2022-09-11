function abone_ol(uniid) {
    const btn = document.getElementById("profil_btn");
    $('.gonder-spin').css('display', 'block');
    $('#profil_btn').css('display', 'none');
    $.ajax({
        type: 'post',
        url: '/postislem',
        data: {islemid:3, uni_id:uniid},
        success: function(response) {
            if(response == "uyeDegil")
            {
                alert("Önce giriş yap.");
            }
            else if(response == "subscribed")
            {
                btn.classList.remove('takip_et');
                btn.classList.add('takibi_birak');
                btn.innerHTML = "Takibi Bırak";
                iziToast.show({
                    title: '<i class="fas fa-plus"></i>',
                    message: uni + " takip edildi",
                    image: uni_ico,
                    color: 'green',
                    position: pos
                });
            }
            else
            {
                btn.classList.remove('takibi_birak');
                btn.classList.add('takip_et');
                btn.innerHTML = "Takip Et";
                iziToast.show({
                    title: '<i class="fas fa-minus"></i>',
                    message: uni + " takipten çıkarıldı",
                    image: uni_ico,
                    color: 'red',
                    position: pos
                });
            }
            $('.gonder-spin').css('display', 'none');
            $('#profil_btn').css('display', 'block');
        }
    });
}