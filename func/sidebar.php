	<?php if(isset($_SESSION['ID'])) { ?>
	
	<script>
      $(document).ready(function(){
        $('.cikis-yap').click(function(){
            modalAc();
            document.getElementById("m_kapat").style.display = "none";
            modal.style.textAlign = "center";
            m_id.innerHTML = document.getElementById('cikisModal').innerHTML;
			closeSlideMenu();
		  });
      });
	  function btn1_click(){
          modalKapat();
        }
        function btn2_click(){
          window.location.href = "/action?act=logout";
        }
    </script>

	
	<div id="menu" class="nav">
	<div style="width: 250px;">
		<a href="javascript:void(0)" class="close" onclick="closeSlideMenu()">
		<i class="fas fa-times" style="color: #7E0008; width: 20px; height: 20px; background-color: #C5E7E8; box-shadow: 0px 0px 12px 0px rgba(0,0,0,0.42); border-radius: 50%; padding: 5px;"></i>
		</a>
		<div class="sidebar-header">
		<img src="<?php echo $_SESSION['coverPic'] ?>" onerror="this.src='/images/cover.png'" style="pointer-events: none; position: absolute; width: 250px; height: 86px; z-index: -1; background-color: #C5E7E8;">
		<div style="text-align: center; padding-top: 50px;">
			<a href="/p/<?php echo $_SESSION['uname']; ?>" style="text-decoration: none;"> <img src="<?php echo $_SESSION['profilePic'] ?>" height = "64px" width = "64px" style="border-radius: 50%; vertical-align: middle; -webkit-box-shadow: 0px 0px 12px 0px rgba(0,0,0,0.42); box-shadow: 0px 0px 12px 0px rgba(0,0,0,0.42); background-color: #C5E7E8;" onerror="this.src='/images/avatar.png';"> </a>
		</div>
		<div class="sidebar-profil-wrapper">
			
			<div class="sidebar-profil-username-box">
				<a href="/p/<?php echo $_SESSION['uname']; ?>" style="text-decoration: none;"><p class="profil-yazi">Profil</p></a>
				<a href="/p/<?php echo $_SESSION['uname']; ?>" style="text-decoration: none;"><p class="username">@<?php echo $_SESSION['uname']; ?></p></a>
			</div>
		</div>

		</div>
		<div class="sidebar-items" style="margin-top: 120px;">
			<a href="/anasayfa"><i class="fas fa-home"></i> Anasayfa</a>
			<a href="javascript:void(0)" onclick="showUniList()" id="sidenav_uni"><i class="fas fa-university"></i> Üniversiteler</a>
			<a href="javascript:void(0)" class="cikis-yap"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
		</div>
	</div>
	</div>
	
	
	<script id="cikisModal" type="text/html">
		<div class="popup_box">
		  <i id="unlem" class="far fa-question-circle"></i>
		  <h1>Daha karpuz kesecektik?!</h1>
		  <label>Çıkıp gitmek istediğine emin misin?</label>
		  <div class="btns">
			<a href="javascript:void(0)" class="btn1" onclick="btn1_click()">Vazgeçtim</a>
			<a href="javascript:void(0)" class="btn2" onclick="btn2_click()">Çıkar Beni Burdan</a>
		  </div>
		</div>
	</script>

        <script>
            function showUniList(){
                modalAc();

                $('#m_kapat').html("<span><i class='fas fa-angle-left'></i> Geri</span>");
                $.ajax({
                    type: 'post',
                    url: '/unilist',
                    cache: false,
                    success: function(html){
                        m_id.innerHTML = html;
                    }
                });
                closeSlideMenu();
                return false;
            }

        </script>
	
	<?php } else { ?>
	
		<div id="menu" class="nav">
		<div style="width: 250px; overflow: hidden;">
			<div class="sidebar-items">
				<a href="javascript:void(0)" class="close" onclick="closeSlideMenu()">
				<i class="fas fa-times"></i>
				</a>
				<a href="/turnike/uyeol"><i class="fas fa-user-plus"></i> Üye Ol</a>
				<p></p>
				<a href="/anasayfa"><i class="fas fa-home"></i> Anasayfa</a>
			</div>
		</div>
	</div>
	
	<?php }?>