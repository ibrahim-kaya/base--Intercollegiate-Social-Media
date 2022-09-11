function kaldir(hangisi)
{
    var baslik = [
        "Üniversite Bilgini Silelim Mi?",
        "Doğum Tarihi Bilgini Silelim Mi?"
    ];

    var soru = [
        "Profilinde hangi üniversitede okuduğun yazmayacak. Yapalım mı bunu?",
        "Profilinde doğum tarihin yazmayacak. Yapalım mı bunu?"
    ];


    iziToast.question({
        timeout: 0,
        close: false,
        closeOnEscape: true,
        overlay: true,
        displayMode: 'once',
        id: 'question',
        zindex: 999,
        layout: 2,
        titleLineHeight: '30',
        titleSize: '15',
        messageSize: '15',
        backgroundColor: '#EBEBFF',
        title: baslik[hangisi],
        message: soru[hangisi],
        position: 'center',
        buttons: [
            ['<button><b>Yap</b></button>', function (instance, toast) {

                instance.hide({ transitionOut: 'fadeOut' }, toast, 'evet');

            }, true],
            ['<button>Vazgeçtim</button>', function (instance, toast) {

                instance.hide({ transitionOut: 'fadeOut' }, toast, 'hayir');

            }],
        ],
        onClosed: function(instance, toast, closedBy){
            if(closedBy === 'evet')
            {
                $.ajax({
                    type: 'POST',
                    url: '/bilgisil',
                    data: {birisi:hangisi},
                    success: function(response) {
                        location.reload(); ;
                    }
                });
            }
        }
    });
}


$(document).ready(function(){


    $('#pp_degistir').on('change', function(){
        $('#image_demo').croppie('destroy');
        document.getElementById("sel-header").setAttribute("select","0");

        let $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square' //circle
            },
            boundary: {
                width: 250,
                height: 250
            }
        });

        const reader = new FileReader();
        reader.onload = function (event) {
            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
        }
		
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
    });

    $('#cover_degistir').on('change', function(){
        $('#image_demo').croppie('destroy');
        document.getElementById("sel-header").setAttribute("select","1");

        let $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 250,
                height: 86,
                type: 'square' //circle
            },
            boundary: {
                width: 350,
                height: 150
            }
        });

        const reader = new FileReader();
        reader.onload = function (event) {
            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
    });

    $('.crop_image').click(function(event){
        $(".prof-spin").show();
        $(".btn-success").hide();
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'original'
        }).then(function(response){
            $.ajax({
                url:"../func/upload_pp.php",
                type: "POST",
                data:{"image": response,"type":document.getElementById("sel-header").getAttribute("select")},
                success:function(data)
                {
                    $('#uploadimageModal').modal('hide');
                    $('#uploaded_image').html(data);
                }
            });
        })
    });
});