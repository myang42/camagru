<?php
	session_start();
	require_once("database.php");
	$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$title = htmlspecialchars($_POST['title'], ENT_QUOTES | ENT_HTML5 );
	$_FILES['img']['name'];
	$_FILES['img']['type'];
	$_FILES['img']['tmp_name'];
	$_FILES['img']['error'] = 0;
	$desc = htmlspecialchars($_POST['descriptionfile'], ENT_QUOTES | ENT_HTML5 );

	if (exif_imagetype($_FILES['img']['tmp_name']) == IMAGETYPE_JPEG ||
	exif_imagetype($_FILES['img']['tmp_name']) == IMAGETYPE_PNG) {
	    $extensions = array('jpg', 'jpeg', 'png');
		if (!($_FILES['img']['name']) ||
			!(preg_match('/(.*)(?=\.(jpg|jpeg|png)$)/', $_FILES['img']['name'], $m)) ||
			!($title) ||
			strlen($desc) >= 254 || strlen($title) >= 26){
			$_FILES['img']['error'] += 1;
		}
			if ($_FILES['img']['error'] == 0){
				$path = md5(uniqid(rand(), true)).".".$m[2];
				if ($connect){
					if ($_SESSION['user']){
						$u = $_SESSION['user'];
						$req = "SELECT * FROM accountinfos WHERE user LIKE '".$u."'";
						$do = $connect->prepare($req);
						$do->execute();
						$res = $do->fetch(PDO::FETCH_ASSOC);
						if ($res){
							$id = $res['id'];
							$username = $res['username'];
						}
					}
					$acces_path = "./photos/".$username."/".$path;
					$req = "INSERT INTO gallery(iduser, title, acces_path, post_date, description)
					VALUES($id, '".$title."', '".$acces_path."', CURRENT_TIMESTAMP(), '" . $desc . "');";
					$act = $connect->prepare($req);
					$act->execute();
					$upload = move_uploaded_file($_FILES['img']['tmp_name'], $acces_path);
					}
				header ('Location: ./index.php');
			}
			else{
				if (strlen($desc) >= 254){
					echo "<script type='text/javascript'>
					alert('The description\'s field must be 253 characters max.');
					</script>";
				}
				else if (strlen($title) >= 26){
					echo "<script type='text/javascript'>
					alert('The title\'s field must be 25 characters max.');
					</script>";
				}
				else if (!$title){
					echo "<script type='text/javascript'>
					alert('A title is missing.');
					</script>";
				}
			}
		}
	else{
		echo "<script type='text/javascript'>
		alert('Only image type \".jpg\", \".jpeg\" or \".png\" are allowed.');
		</script>";
	}
}
?>
