let tabHeader = document.getElementsByClassName("tab-baslik")[0];
let tabIndicator = document.getElementsByClassName("tab-indicator")[0];
let tabsPane = tabHeader.getElementsByTagName("div");
let sayfalar = document.getElementsByClassName("posts");

const pp = document.getElementById("profil-resmi");
const cover = document.getElementById("kapak-resmi");

for(let i=0;i<tabsPane.length;i++){
    tabsPane[i].addEventListener("click",function(){
        tabHeader.getElementsByClassName("aktif")[0].classList.remove("aktif");
        tabsPane[i].classList.add("aktif");
        tabIndicator.style.left = `calc(calc(100% / 2) * ${i})`;

        for(let a=0;a<sayfalar.length;a++){
            if(sayfalar[a].style.opacity !== '0')
            {
                sayfalar[a].style.opacity = '0';
                setTimeout(function(){
                    sayfalar[a].style.height = "0";
                    sayfalar[i].style.height = 'auto';
                    sayfalar[i].style.opacity = '1';
                }, 400);
            }

        }
    });
}

pp.onclick = function(event) {
    $('#m_kapat').html("<span style='float: right;'><i class='fas fa-times'></i></span>");
    modalAc();
    modalid.style.maxWidth = 'max-content';
    m_id.innerHTML = `
    <div style="text-align: center; overflow: hidden;">
       <img src="` + ppic + `" style="max-width: 100%; height: auto;"/>
    </div>
    `;
}

cover.onclick = function(event) {
    $('#m_kapat').html("<span style='float: right;'><i class='fas fa-times'></i></span>");
    modalAc();
    modalid.style.maxWidth = 'max-content';
    m_id.innerHTML = `
    <div style="text-align: center; overflow: hidden;">
       <img src="` + cpic + `" style="max-width: 100%; height: auto;"/>
    </div>
    `;
}