<?php
	session_start();
	require_once('database.php');
	if ($_SESSION['username']){
		$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
		if ($connect){
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
			$do = $connect->prepare($req);
			$do->execute();
			// if (file_put_contents($path, $decoded)){
			// 	unlink($res['path_photo']);
			// 	header('Location: ./customit.php');
			//  }
		 }

	}else{
		header("Location: ./index.php");
	}
	?>
