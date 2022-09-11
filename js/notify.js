	$(document).ready(function(){
		setInterval(function(){
		Notify(0);
		}, 5000);
		Notify(1);
	});
	
	function Notify(opt)
	{
		
		if(opt == 0)
		{
			$.ajax({
				url:"/notify",
				method:"POST",
				data: {act:0},
				success:function(data)
				{
					$('#not').html(data);
					if(data) Notify(1);
				}
			})
		}
		else if(opt == 1)
		{
			$.ajax({
				url:"/notify",
				method:"POST",
				data: {act:1},
				success:function(data)
				{
					var vars = data.split('|');

					if(vars[1])
					{
						$('#notifi-icerik').html(vars[1]);
					}

					if(vars[0] > 0)
					{					
						var divs = document.getElementsByClassName( 'bildirim_sayi' );

						[].slice.call( divs ).forEach(function ( div ) {
							div.innerHTML = vars[0];
							div.style.opacity = "1";
						});
					}
					else
					{
						var divs = document.getElementsByClassName( 'bildirim_sayi' );
						
						[].slice.call( divs ).forEach(function ( div ) {
							div.innerHTML = vars[0];
							div.style.opacity = "0";
						});
					}
				}
			})
		}
		else if(opt == 2)
		{
			$.ajax({
				url:"notify",
				method:"POST",
				data: {act:2},
				success:function(data)
				{
					
					var divs = document.getElementsByClassName( 'bildirim_sayi' );
					[].slice.call( divs ).forEach(function ( div ) {
						div.innerHTML = 0;
						div.style.opacity = "0";
					});
				}
			})
		}
	}