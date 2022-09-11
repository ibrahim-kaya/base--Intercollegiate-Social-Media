$(document).ready(function() {
    var text_max = 250;

    $(document).on("keyup", "#entry_area", function() {
        //$('#entry_area').keyup(function() {
        var text_length = $('#entry_area').val().length;
        var text_remaining = text_max - text_length;
        var elem = document.getElementById("text_progress");
        var perc = (text_length / 250) * 100;

        $('#textarea_feedback').html('<i class="remaining" style="color: #999">' + text_remaining + ' karakter kaldı.</i>');
        document.getElementById("home_sbtn").disabled = false;
        if(text_length == 0) { $('#textarea_feedback').html(''); document.getElementById("home_sbtn").disabled = true; }

        elem.style.width = perc + "%";

        if(text_remaining < 11){
            elem.style.backgroundColor = "#FF0000"
        }else{
            elem.style.backgroundColor = "#7e93b2"
        }
    });

    $(document).on("keyup", "#comment_area", function() {
        var text_length = $('#comment_area').val().length;
        var text_remaining = text_max - text_length;
        var elem = document.getElementById("c_text_progress");
        var perc = (text_length / 250) * 100;

        $('#commentarea_feedback').html('<i class="remaining" style="color: #999">' + text_remaining + ' karakter kaldı.</i>');
        document.getElementById("comm_sbtn").disabled = false;
        if(text_length == 0) { $('#commentarea_feedback').html(''); document.getElementById("comm_sbtn").disabled = true; }

        elem.style.width = perc + "%";

        if(text_remaining < 11){
            elem.style.backgroundColor = "#FF0000"
        }else{
            elem.style.backgroundColor = "#7e93b2"
        }
    });


    $(document).on("click", ".gonderButonu", function() {
        //$('#comm_sbtn').prop('disabled', true);
        $(".gonder-spin").first().show();
        $(".gonderButonu").first().hide();
    });

});

function chk(page, val){
    var post_str;
    if(page == "uni")
    {
        post_str = document.getElementById("entry_area").value;
        if(post_str)
        {
            $.ajax({
                type: 'post',
                url: '/send',
                data:{entry:post_str, from:page, uni_id:val},
                cache: false,
                success: function(html){
                    if(html == "err")
                    {
                        var ht = `<?php include('../func/errors.php'); ?>`;
                        $('#err_div').html(ht);
                    }
                    else
                    {
                        window.location.href = "";
                    }
                }
            });
        }
        else
        {
				var ht = `<?php array_push($_SESSION['errors'], "Bir şey yazmamışsın?"); include('../func/errors.php'); ?>`;
				$('#err_div').html(ht);
			}
		}
		else if(page == "comment")
		{
			post_str = document.getElementById("comment_area").value;
			if(post_str)
			{
				$.ajax({
					type: 'post',
					url: '/send',
					data:{entry:post_str, from:page, post_id:val},
					cache: false,
					success: function(html){
						if(html == "err")
						{
							var ht = `<?php include('../func/errors.php'); ?>`;
							$('#c_err_div').html(ht);
						}
						else
						{
                            if(document.body.id == "yorumlar")
                            {
                                window.location.href = "";
                            }
                            else
                            {
                                $('#yorumlar_' + val).html(html + " yorum");
                                myownfunc(val);
                            }
						}
					}
				});
			}
			else
			{
				var ht = `<?php array_push($_SESSION['errors'], "Bir şey yazmamışsın?"); include('../func/errors.php'); ?>`;
				$('#c_err_div').html(ht);
			}
		}

		return false;
	}

function post_load(req)
{
    var bodyId = document.body.id;
    var limit = 7;
    var start = 0;
    var action = 'inactive';

    function load_posts(limit, start)
    {
        $.ajax({
            url:"/loadposts",
            method:"POST",
            data:{limit:limit, start:start, req:req},
            cache:false,
            success:function(data)
            {
                $('#load_data').append(data);

                if(!data.length)
                {
                    action = 'active';
                    $('#load_data_message').html('');
                    if(document.getElementById('load_data').innerHTML === '')
                    {
                        if(bodyId === "anasayfa")
                        {
                            $('#load_data_message').html("<div style='margin-top: 10px; text-align: center;'><img src='/images/yok-ki.png'> <p style='color: #999; padding: 0 10px'>Takip ettiğiniz üniversitelerden veya kişilerden bir paylaşım olmamış şu ana kadar.<br><br>Daha fazla paylaşım görmek için diğer üniversiteleri keşfedebilirsin.<br><br><a href=\"#\" title=\"Üniversiteler\" class=\"home_reg-btn\" style=\"color: #eee; background-color: #167DBD;\">Hadi keşfedelim.</a></p></div>");
                        }
                        else
                        {
                            $('#load_data_message').html("<div style='margin-top: 10px; text-align: center;'><img src='/images/yok-ki.png'> <p style='color: #999;'>Buralara kimse yazmamış.</p></div>");
                        }

                    }
                }
                else
                {
                    action = "inactive";
                }
            }
        });
    }

    if(action === 'inactive')
    {
        action = 'active';
        load_posts(limit, start);
    }
    $(window).scroll(function(){
        if(document.body.id.startsWith('profil') && document.getElementsByClassName("posts")[0].style.opacity === '0')
        {
            return;
        }

        if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action === 'inactive')
        {
            action = 'active';
            start = start + limit;
            $('#load_data_message').html("<div class='spinner'><div class='rect1'></div>  <div class='rect2'></div>  <div class='rect3'></div>  <div class='rect4'></div>  <div class='rect5'></div></div>");
            setTimeout(function(){
                load_posts(limit, start);
            }, 1000);
        }
    });
}

function comment_load(req)
{

    var limit = 7;
    var start = 0;
    var action = 'inactive';

    function load_comments(limit, start)
    {
        $.ajax({
            url:"/loadcmts",
            method:"POST",
            data:{limit:limit, start:start, req:req},
            cache:false,
            success:function(data)
            {
                $('#load_c_data').append(data);

                if(!data.length)
                {
                    action = 'active';
                    $('#load_c_data_message').html('');
                    if(document.getElementById('load_c_data').innerHTML === '')
                    {
                            $('#load_c_data_message').html("<div style='margin-top: 10px; text-align: center;'><img src='/images/yok-ki.png'> <p style='color: #999;'>Buralara kimse yazmamış.</p></div>");
                    }
                }
                else
                {
                    action = "inactive";
                }
            }
        });
    }

    if(action === 'inactive')
    {
        action = 'active';
        load_comments(limit, start);
    }
    $(window).scroll(function(){
        if(document.body.id.startsWith('profil') && document.getElementsByClassName("posts")[1].style.opacity === '0')
        {
            return;
        }
        if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action === 'inactive')
        {
            action = 'active';
            start = start + limit;
            $('#load_c_data_message').html("<div class='spinner'><div class='rect1'></div>  <div class='rect2'></div>  <div class='rect3'></div>  <div class='rect4'></div>  <div class='rect5'></div></div>");
            setTimeout(function(){
                load_comments(limit, start);
            }, 1000);
        }
    });
}