<?php
	// The file
	$filename = './other/filters/frame_filter2.png';
	$src = './other/tmp_saved/montagne.jpg';

	$infos = getimagesize($src);
	$type = $infos['mime'];

	switch($type){
		case 'image/jpeg':
			$createfrom = 'imagecreatefromjpeg';
			break;

		case 'image/png' :
			$createfrom = 'imagecreatefrompng';
			break;
	}

	// $customizedimg = imagecreatefromjpeg($src);
	$customizedimg = $createfrom($src);
	list($widthsrc, $heightsrc) = getimagesize($src);

	//RESIZE FILTERS IF NEEDED
		list($width, $height) = getimagesize($filename);
		$curimg = imagecreatefrompng($filename);
		$nw = $width  * ($widthsrc / $width);
		$nh = $height * ($heightsrc / $height);
		$newimg = imagecreatetruecolor($nw, $nh);
		imagealphablending($newimg, false);
		imagesavealpha($newimg, true);
		$trs = imagecolorallocatealpha($newimg, 255,255,255,127);
		imagefilledrectangle($newimg, 0, 0, $nw, $nh, $trs);
		imagecopyresampled($newimg, $curimg, 0,0,0,0, $nw, $nh, $width, $height);
	//


	// imagepng($newimg);

	// list($widthsrc, $heightsrc) = getimagesize($src);
	// echo $widthsrc." <> " .$heightsrc;
	imagecopy($customizedimg, $newimg, 0,0,0,0, $nw, $nh);

	header('Content-Type: image/jpeg');
	imagepng($customizedimg);
	imagedestroy($customizedimg);
	?>
