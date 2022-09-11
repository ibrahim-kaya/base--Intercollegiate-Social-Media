<?php if(isset($_SESSION['ID'])) {
	$result_uni = mysqli_query($db, "SELECT * FROM categories");
	
	?>
	
	<link
	  rel="stylesheet"
	  href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css"
	/>
	<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
	
	<div data-simplebar class="uni_list" style="background-color: #D8EEEF; border-radius: 0 0 10px 10px; overflow: auto; width: 300px; max-height: 500px; float: right; margin: 50px 15px 0 0;" >
	<div style="font-size: 22px; padding: 15px 0 15px 0; background-image: linear-gradient(to top, rgba(211, 237, 238,0.8), rgb(211, 237, 238));border-bottom: #C7DAE5 1px solid;"><p style="margin: 0; margin-left: 15px;">Üniversiteler</p></div>
	<?php
	while($uni_row = mysqli_fetch_array($result_uni))
	{ 
	?>
	<a href="/uni/<?php echo $uni_row['ID']; ?>"><div class="uni_li"><img src="<?php echo $uni_row['pic']; ?>"> <p><?php echo $uni_row['name']; ?></p></div></a>
	<?php } ?>
	</div>
<?php } else { ?>
    <p>şimdi üye ol</p>
<?php } ?>
