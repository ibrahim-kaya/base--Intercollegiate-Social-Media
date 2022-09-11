<?php
		include_once('../func/config.php');
		include_once('../func/resize-class.php');
		
		function resizeImage($resourceType, $image_width, $image_height)
		{
			$resizeWidth = $image_width;
			$resizeHeight = $image_height;
			$imageLayer = imagecreatetruecolor($resizeWidth, $resizeHeight);
			imagecopyresampled($imageLayer, $resourceType, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $image_width, $image_height);
			return $imageLayer;
		}
		
		function image_fix_orientation($image, $filename) {
			if (method_exists($image, 'getImageProperty')) {
				$orientation = $image->getImageProperty('exif:Orientation');
			} else {
				 
				if (empty($filename)) {
					$filename = 'data://image/jpeg;base64,' . base64_encode($image->getImageBlob());
				}

				$exif = exif_read_data($filename);
				$orientation = isset($exif['Orientation']) ? $exif['Orientation'] : null;
			}

			if (!empty($orientation)) {
				switch ($orientation) {
					case 3:
						$image->rotateImage('#000000', 180);
						break;

					case 6:
						$image->rotateImage('#000000', 90);
						break;

					case 8:
						$image->rotateImage('#000000', -90);
						break;
				}
			}
		}		
		
		$file = $_FILES['file'];

		$fileName = $file['name'];
		$fileTmpName = $file['tmp_name'];
		$fileSize = $file['size'];
		$fileError = $file['error'];
		
		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));
		
		$allowed = array('jpg', 'jpeg', 'png');
		
		if(in_array($fileActualExt, $allowed))
		{
			if($fileError === 0)
			{
				if($fileSize < 3000000)
				{
					$sourceProps = getimagesize($fileTmpName);
					$fileType = $sourceProps[2];

					switch($fileType){
						case IMAGETYPE_JPEG:
						$dest = "../uploads/tmp/pp_".$_SESSION['ID'].".jpeg";
						break;
						case IMAGETYPE_GIF:
						$dest = "../uploads/tmp/pp_".$_SESSION['ID'].".gif";
						break;
						case IMAGETYPE_PNG:
						$dest = "../uploads/tmp/pp_".$_SESSION['ID'].".png";
						break;
					}
					
					move_uploaded_file($fileTmpName, $dest);
					
					$resizeObj = new resize($dest);

					$resizeObj -> resizeImage(200, 200, 'crop');
					
					$resizeObj -> saveImage("../uploads/pp_".$_SESSION['ID'].".jpeg");

					$filename = "pp_".$_SESSION['ID'].".jpeg";
					$filePath = "../uploads/pp_".$_SESSION['ID'].".jpeg";
					$exif = exif_read_data($filePath);
					if (!empty($exif['Orientation'])) {
						$imageResource = imagecreatefromjpeg($filePath); // provided that the image is jpeg. Use relevant function otherwise
						switch ($exif['Orientation']) {
							case 3:
							$image = imagerotate($imageResource, 180, 0);
							break;
							case 6:
							$image = imagerotate($imageResource, -90, 0);
							break;
							case 8:
							$image = imagerotate($imageResource, 90, 0);
							break;
							default:
							$image = $imageResource;
						} 
						imagejpeg($image, $filePath, 90);
					}
					
					$ppStr = '/uploads/pp_'.$_SESSION['ID'].'.jpeg';
					$uid = $_SESSION['ID'];
					$sonuc = mysqli_query($db, "UPDATE users SET profilePic='$ppStr' WHERE ID=$uid");
					if ($sonuc)
					echo 'succ';
					else {
					array_push($_SESSION['errors'], "Başaramadık. Bir sorun oluştu."); 
					echo 'err';
					}
				}
				else
				{
					array_push($_SESSION['errors'], "O ney gardaş! Çok büyük dosya."); 
					echo 'err';
				}
			} else {
				array_push($_SESSION['errors'], "Başaramadık! Bir hata oluştu."); 
				echo 'err';
			}
		}
		else
		{
			array_push($_SESSION['errors'], "Dosya türü geçersiz! jpg, jpeg ya da png olmalı."); 
			echo 'err';
		}
?>