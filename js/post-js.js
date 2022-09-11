
function postDropdown(element) {
    var elements = ".post-secenek-menu";
    $(elements).removeClass('show');
    $(element).next(elements).toggleClass("show");
}

/* W3Schools function to close the dropdown when clicked outside. */
window.onclick = function(event) {
    if (!event.target.closest('.post-secenek-btn')) {
        var dropdowns = document.getElementsByClassName("post-secenek-menu");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

function copyLink(val) {

    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val('http://' + window.location.hostname + '/gonderi/' + val).select();
    document.execCommand("copy");
    $temp.remove();

    iziToast.show({
        title: '<i class="fas fa-copy"></i>',
        message: 'Link Kopyalandı!',
        titleColor: '#468847',
        color: 'green',
        position: pos,
        timeout: 3000
    });
}

function like_post(postid) {

    $.ajax({
        type: 'post',
        url: '/postislem',
        data: {islemid:1, post_id:postid},
        success: function(response) {

            if(response == "uyeDegil")
            {
                uyeolModalGoster();
            }
            else
            {
                if (response == "liked") {
                    document.getElementById("like_button_" + postid).classList.add('play-like-anim');
                    document.getElementById("like_button_" + postid).classList.remove('play-dislike-anim');
                } else {
                    document.getElementById("like_button_" + postid).classList.add('play-dislike-anim');
                    document.getElementById("like_button_" + postid).classList.remove('play-like-anim');
                }
                $.ajax({
                    type: 'post',
                    url: '/postislem',
                    data: {islemid:2, post_id: postid},
                    success: function (response) {

                        $('#begeni_sayi_' + postid).html(response + " beğeni");
                    }
                });
            }
        }
    });
}

function like_comment(commentid) {

    $.ajax({
        type: 'post',
        url: '/postislem',
        data: {islemid:5, comment_id:commentid},
        success: function(response) {

            if(response == "uyeDegil")
            {
                uyeolModalGoster();
            }
            else
            {
                if (response == "liked") {
                    document.getElementById("c_like_button_" + commentid).classList.add('play-like-anim');
                    document.getElementById("c_like_button_" + commentid).classList.remove('play-dislike-anim');
                } else {
                    document.getElementById("c_like_button_" + commentid).classList.add('play-dislike-anim');
                    document.getElementById("c_like_button_" + commentid).classList.remove('play-like-anim');
                }
                $.ajax({
                    type: 'post',
                    url: '/postislem',
                    data: {islemid:6, comment_id: commentid},
                    success: function (response) {
                        $('#y_begeni_sayi_' + commentid).html(response + " beğeni");
                    }
                });
            }
        }
    });
}

function showLikes(postid){
    modalAc();
    $('#m_kapat').html("<span><i class='fas fa-angle-left'></i> Beğeniler</span>");
    $.ajax({
        type: 'post',
        url: '/loadlikes',
        data:{gonderi:postid},
        cache: false,
        success: function(html){
            m_id.innerHTML = html;
        }
    });
    return false;
}




function postSecenek(secenek, val){

    if(secenek == 7)
    {
        copyLink(val);
    }
    else
    {
        var scnk = ["Gönderiyi Paylaş", "Gönderi Düzenle", "Gönderi Sil", "Şikayet Et", "Kişiyi Engelle", "Takibi Bırak", "Takibi Bırak"];

        $('#m_kapat').html("<span><i class='fas fa-angle-left'></i> " + scnk[secenek] + "</span>");
        $.ajax({
            type: 'post',
            url: '/postopt',
            data:{eylem:secenek, value:val},
            cache: false,
            success: function(html){
                {
                    if(html.startsWith("followed"))
                    {
                        var data = html.split('|');
                        UserTakip(val, data[1]);

                        iziToast.show({
                            title: '<i class="fas fa-user-plus"></i>',
                            message: data[1] + ' takip edildi',
                            image: data[2],
                            color: 'green',
                            position: pos
                        });
                    }
                    else
                    {
                        modalAc();
                        m_id.innerHTML = html;
                    }
                }
            }
        });
        return false;
    }
}

function UserTakip(f_userid, f_username) {
    const btn = document.getElementById("profil_btn");
    $('.gonder-spin').css('display', 'block');
    $('#profil_btn').css('display', 'none');
    $.ajax({
        type: 'post',
        url: '/postislem',
        data: {islemid:4, follow_id:f_userid},
        success: function(response) {

            let divs;
            let btn;
            let data;
            if(response.startsWith("followed"))
            {
                divs = document.getElementsByClassName('user_' + f_userid + '_takip');
                [].slice.call( divs ).forEach(function ( div ) {
                    div.innerHTML = '<i class="fas fa-user-times"></i> ' + f_username + ' adlı kişiyi takibi bırak';
                });

                btn = document.getElementById("profil_btn");
                if(btn)
                {
                    btn.classList.remove('takip_et');
                    btn.classList.add('takibi_birak');
                    btn.innerHTML = "Takibi Bırak";
                    data = response.split('|');
                    document.getElementById("takipci_sayi").innerHTML = data[1];
                }
            }
            else if(response.startsWith("unfollowed"))
            {
                divs = document.getElementsByClassName( 'user_' + f_userid + '_takip' );
                [].slice.call( divs ).forEach(function ( div ) {
                    div.innerHTML = '<i class="fas fa-user-plus"></i> ' + f_username + ' adlı kişiyi takip et';
                });

                iziToast.show({
                    title: '<i class="fas fa-user-times"></i>',
                    message: f_username + ' takipten çıkarıldı.',
                    color: 'red',
                    position: pos
                });

                btn = document.getElementById("profil_btn");
                if(btn)
                {
                    btn.classList.remove('takibi_birak');
                    btn.classList.add('takip_et');
                    btn.innerHTML = "Takip Et";
                    data = response.split('|');
                    document.getElementById("takipci_sayi").innerHTML = data[1];
                }
            }
            $('.gonder-spin').css('display', 'none');
            $('#profil_btn').css('display', 'block');
        }
    });

}

function islemUygula(islem, val){
    $.ajax({
        type: 'post',
        url: '/postislem',
        data:{islemid:islem, value:val},
        cache: false,
        success: function(html){
            {
                var data = html.split('|');
                if(html.startsWith('err'))
                {
                    iziToast.show({
                        title: '<i class="fas fa-times"></i>',
                        message: data[1],
                        color: 'red',
                        position: pos
                    });
                }
                else
                {
                    iziToast.show({
                        title: '<i class="fas fa-check"></i>',
                        message: data[0],
                        color: 'green',
                        position: pos
                    });
                    if(data[1])
                    {
                        document.getElementById(""+val+"").innerHTML = data[1];
                    }
                }
            }
        }
    });
}
