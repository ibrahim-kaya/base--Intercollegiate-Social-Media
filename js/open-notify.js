var box  = document.getElementById('box');
var down = false;


function toggleNotifi(){
	if (down) {
		box.style.height  = '0px';
		box.style.opacity = '0';
		down = false;
		$('#bildirim_ico').html('<i class="fas fa-bell"></i>');
		$('.mobile_bildirim_btn').css('background-color', 'transparent');

	}else {
		box.style.height  = '510px';
		box.style.opacity = '1';
		down = true;
		Notify(2);
		$('#bildirim_ico').html('<i class="fas fa-times"></i>');
		$('.mobile_bildirim_btn').css('background-color', '#F6B3B8');
	}
}

function toggleSearchBox(){
	var sbox  = document.getElementById('arama-kutusu');
	if (sbox.offsetWidth > 0) {
		sbox.style.width  = '0px';
	}else {
		sbox.style.width  = '280px';
	}
}