<?php
	session_start();
	require_once('database.php');
	if ($_SESSION['username']){
		$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
		if ($connect){


			function add_filter($connect, $file){
				$add = $_POST['filter_id'];
				$acces = $_POST['filter_name'];
				$req = "SELECT * FROM filters_table WHERE NOT path_img is NULL AND id=$add";
				$do2 = $connect->prepare($req);
				$do2->execute();
				$res = $do2->fetch(PDO::FETCH_ASSOC);
				if ($res['path_img'] != $acces || !$res['path_img']){
					echo '<script type="text/javascript">alert("ERROR : don\'t touch the HTML\'s datas if you want to continue.");
					window.location.href  = "./mygallery.php";
					</script>';
				}else{
					$customizedimg = imagecreatefrompng($file);
					list($w, $h) = getimagesize($file);
					list($oldw, $oldh) = getimagesize($acces);
					if ($add > 2){
						if ($w < $h){
						$nw = intval($w * 0.5);
						$nh = intval($nw * $oldh / $oldw);
						}else{
							$nh = intval($h * 0.5);
							$nw = intval($nh * $oldw / $oldh) ;

						}

						if($add < 6 && $add > 3){
							$posx = 0;
							$posy = $h - $nh;
						}
						else{
							$posx = $w - $nw;
							$posy = $h - $nh;
						}
					}
					else{
						$posx = 0;
						$posy = 0;
						$nw = $w;
						$nh = $h;
					}

					$curimg = imagecreatefrompng($acces);

					 //CREATION DE LA NOUVELLE IMAGE
					$newimg = imagecreatetruecolor($nw, $nh);
					imagealphablending($newimg, false);
					imagesavealpha($newimg, true);

					//IMPLEMENTATION DU FILTRE SUR LA BONNE TAILLE
					$trs = imagecolorallocatealpha($newimg, 255,255,255,127);
					imagefilledrectangle($newimg, 0, 0, $nw, $nh, $trs);
					imagecopyresampled($newimg, $curimg, 0,0,0,0, $nw, $nh, $oldw, $oldh);

					imagecopy($customizedimg, $newimg, $posx, $posy, 0, 0, $nw, $nh);

					unlink($file);
					imagepng($customizedimg, $file);
					imagedestroy($customizedimg);
				}
			}


			$req = 'SELECT photos_tmp.path_photo, accountinfos.username
					FROM photos_tmp
					INNER JOIN accountinfos
					ON photos_tmp.username = accountinfos.username
					WHERE accountinfos.username = "'.$_SESSION["username"].'"';

			$do = $connect->prepare($req);
			$do->execute();
			$res = $do->fetch();

			preg_match('/(?<=image\/png;base64,)(.*)/',$_POST['akor'], $file);
			$decoded = base64_decode($file[1]);
			$path = "./other/tmp_saved/" . md5(uniqid(rand(), true)).".png";
			if ($res['username'] == NULL){
				$set = 'INSERT INTO photos_tmp(username, path_photo)
						VALUES ("'.$_SESSION["username"].'", "' . $path . '") ;';
			}
			else{
				$set = 'UPDATE photos_tmp
						SET path_photo="' . $path . '"
						WHERE username="'.$_SESSION["username"].'";';

			}
			$do = $connect->prepare($set);
			$do->execute();
			if (file_put_contents($path, $decoded)){
				unlink($res['path_photo']);
				add_filter($connect, $path);
				header("Location: ./postimg.php");
			 }
		 }

	}else{
		header("Location: ./index.php");
	}
	?>
