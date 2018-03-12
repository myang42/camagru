<?php
	session_start();
	require_once('database.php');
	if ($_SESSION['username']){
	$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);

		$_FILES['img']['name'];
		$_FILES['img']['type'];
		$_FILES['img']['tmp_name'];
		$_FILES['img']['error'] = 0;

		if (exif_imagetype($_FILES['img']['tmp_name']) == IMAGETYPE_JPEG ||
			exif_imagetype($_FILES['img']['tmp_name']) == IMAGETYPE_PNG) {
			    $extensions = array('jpg', 'jpeg', 'png');
				if (!($_FILES['img']['name']) ||
				!(preg_match('/(.*)(?=\.(jpg|jpeg|png)$)/', $_FILES['img']['name'], $m))){
					$_FILES['img']['error'] += 1;
				}
				list($a, $b) =  getimagesize($_FILES['img']['tmp_name']);
				if ($a * $b <= 1600*1200){
					if ($_FILES['img']['error'] == 0){
						$path = "./other/tmp_saved/" . md5(uniqid(rand(), true)).".".$m[2];
						if ($connect){
							$req = 'SELECT photos_tmp.path_photo, accountinfos.username
									FROM photos_tmp
									INNER JOIN accountinfos
								    ON photos_tmp.username = accountinfos.username
									WHERE accountinfos.username = "'.$_SESSION["username"].'"';

							$do = $connect->prepare($req);
							$do->execute();
							$res = $do->fetch();
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
							$upload = move_uploaded_file($_FILES['img']['tmp_name'], $path );
							if ($upload){
								unlink($res['path_photo']);
								header('Location: ./customit.php');
							}
							else{
								echo "<script type='text/javascript'>
								alert('An error has occurred, try to upload your file later...');
								window.location.href  = './mygallery.php';
								</script>";
							}


					}
					else
					{
						echo "<script type='text/javascript'>
						alert('Only image type \".jpg\", \".jpeg\" or \".png\" are allowed.');
						window.location.href  = './mygallery.php';
						</script>";
					}
				}
			else
			{
				echo "<script type='text/javascript'>
				alert('Only image type \".jpg\", \".jpeg\" or \".png\" are allowed.');
				window.location.href  = './mygallery.php';
				</script>";
			}
			}
			else{
				echo "<script type='text/javascript'>
				alert('You image is too big. Max size is 1600*1200px.');
				window.location.href  = './mygallery.php';
				</script>";
			}

		}
		else{
		echo "<script type='text/javascript'>
		alert('Only image type \".jpg\", \".jpeg\" or \".png\" are allowed.');
		window.location.href  = './mygallery.php';
		</script>";
		}
	 }else{
	 		header("Location: ./loginaccount.php");
	 	}
		?>
