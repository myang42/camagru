<html>
	<head>
		<title>CAMAGRU</title>
		<link rel="stylesheet" href="./css/index.css">
		<link rel="stylesheet" href="./css/cam.css">
		<link rel="stylesheet" href="./css/uploadfile.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="./js/menunav.js"></script>
		<meta charset="UTF-8">
	</head>
	<body>

<?php
	require_once("menunav.php");
	require_once("footer.html");
	session_start();
	require_once('database.php');
	if ($_SESSION['username']){
	$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);

	// <-- ON POST LA PHOTO SI TOUT EST EN REGLE -->
	if ($_SERVER['REQUEST_METHOD'] == 'POST' ){
		$title = htmlspecialchars($_POST['title'], ENT_QUOTES | ENT_HTML5 );
		$desc = htmlspecialchars($_POST['descriptionfile'], ENT_QUOTES | ENT_HTML5 );
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
		else{
			if($connect && $_SESSION['user']){
				$u = $_SESSION['user'];
				$requser = "SELECT accountinfos.username, accountinfos.id, photos_tmp.path_photo
							FROM accountinfos
							INNER JOIN photos_tmp
							ON photos_tmp.username=accountinfos.username
							WHERE user LIKE '".$u."'";
				$douser = $connect->prepare($requser);
				$douser->execute();
				$resuser = $douser->fetch(PDO::FETCH_ASSOC);
				if ($resuser){
					preg_match('/\/([^\/]*)\.(\w*)$/', $resuser['path_photo'], $m);
					echo $m[1]."\t".$m[2];
					$id = $resuser['id'];
					$username = $resuser['username'];
					$acces_path = "./photos/".$username."/".$m[1].".".$m[2];
					$reqinsert = "INSERT INTO gallery(iduser, title, acces_path, post_date, description)
					VALUES($id, '".$title."', '".$acces_path."', CURRENT_TIMESTAMP(), '" . $desc . "');";
					$actinsert = $connect->prepare($reqinsert);
					$actinsert->execute();
					$upload = rename($resuser['path_photo'], $acces_path);
					}
				header ('Location: ./index.php');
				}
			}
		}


?>

<?php
	if($connect){
		$req = "SELECT * FROM photos_tmp
				WHERE username='".$_SESSION['username']."'";
		$do = $connect->prepare($req);
		$do->execute();
		$res = $do->fetch(PDO::FETCH_ASSOC);
		if (file_exists($res['path_photo'])){
?>

<div class="bfrpst" >
	<div class="previewarea" style="background-image:url('<?php echo $res['path_photo'] ; ?>');
	<?php
		$size = getimagesize($res['path_photo']);
		echo 'min-width:'.$size[0].'px;';
	?>
	">
	</div>
	<div class="choice_">
		<form method="post" action="">
			<br><label for="title">Image's title (max 26 characters)</label><br />
			<input type="text" name="title" value="">
			<br>
			<br><label for="descriptionfile">Image's description (max 254 characters)</label><br />
			<textarea id="textdescription" name="descriptionfile" value=""></textarea>
			<br>
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>
</div>
<?php
	}else
		header("Location: ./mygallery.php");
		}
	}
	else
		header("Location: ./loginaccount.php");
	?>
</body></html>
