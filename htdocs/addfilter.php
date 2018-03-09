<?php
	session_start();
	require_once('database.php');
	$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);

	$file = $_POST['photo'];
	$add = $_POST['filter_id'];
	$acces = $_POST['filter_name'];

			// <-- SECURE -->
		$req = "SELECT * FROM filters_table WHERE NOT path_img is NULL AND id=$add";
		$do2 = $connect->prepare($req);
		$do2->execute();
		$res = $do2->fetch(PDO::FETCH_ASSOC);
		if ($res['path_img'] != $acces || !$res['path_img']){
			echo '<script type="text/javascript">alert("ERROR : don\'t touch the HTML\'s datas if you want to continue.");
			window.location.href  = "./customit.php";
			</script>';
		}
		else{
	$infos = getimagesize($file);
	$type = $infos['mime'];

	switch($type){
		case 'image/jpeg':
						$createfrom = 'imagecreatefromjpeg';
						break;
		case 'image/png':
						$createfrom = 'imagecreatefrompng';
						break;
	}

	$customizedimg = $createfrom($file);

	echo $file."<br />".$acces;
	list($w, $h) = getimagesize($file);
	list($oldw, $oldh) = getimagesize($acces);
	if ($add > 2){
		if ($oldw >= $oldh){
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
    //
	// header('Content-Type: image/png');
	unlink($file);
	if ($type == 'image/jpeg')
		imagejpeg($customizedimg, $file);
	else
		imagepng($customizedimg, $file);
	imagedestroy($customizedimg);
	header("Location: ./customit.php");
	}

?>
