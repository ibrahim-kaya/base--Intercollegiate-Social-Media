	window.onscroll = function() {moveHeader()};

	const navbar = document.getElementById("head-bar");
	const wrapper = document.getElementById("content-wrap");
	const sticky = navbar.offsetTop;

	const modal = document.getElementById("myModal");
	const modalid = document.getElementById("modalid");
	const span = document.getElementsByClassName("modal_kapat")[0];
	const m_id = document.getElementById("c_area");

	function moveHeader() {
	  if (window.pageYOffset >= sticky) {
		navbar.classList.add("sticky")
		wrapper.style.paddingTop = "60px";
	  } else {
		navbar.classList.remove("sticky");
		wrapper.style.paddingTop = "0";
	  }
	}

	function myownfunc(val){
		modalAc();
		$('#m_kapat').html("<span><i class='fas fa-angle-left'></i> Yorumlar</span>");
			$.ajax({
				type: 'post',
				url: '/func/yorumcek.php',
				data:{gonderi:val},
				cache: false,
				success: function(html){
					if(html === "err")
					{
						let ht = `<?php include('../func/errors.php'); ?>`;
						$('#err_div').html(ht);
					}
					else
					{
						m_id.innerHTML = html;
					}
				}
			});
		return false;
	}

	span.onclick = function() {
		modalKapat();
	}

	modal.onclick = function(event) {
	  if (event.target === modal) {
		  modalKapat();
	  }
	}

	function UrlCikar(url) {
		let hostname;
		if (url.indexOf("//") > -1) {
			hostname = url.split('/')[2];
		}
		else {
			hostname = url.split('/')[0];
		}
		hostname = hostname.split(':')[0];
		hostname = hostname.split('?')[0];

		return hostname;
	}

	function back()
	{
		if(document.referrer && UrlCikar(document.referrer) === window.location.hostname && document.referrer !== window.location.href)
		{
			window.location.href = document.referrer;
		}
		else
		{
			window.location.href = "http://" + window.location.hostname;
		}
	}