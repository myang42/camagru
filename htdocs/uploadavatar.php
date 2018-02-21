<?php
session_start();
require_once("database.php");
$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);

$title = $_POST['title'];
$_FILES['img']['name'];
$_FILES['img']['type'];
$_FILES['img']['tmp_name'];
$_FILES['img']['error'] = 0;

$extensions = array('jpg', 'jpeg', 'png');
if (!($_FILES['img']['name']) ||
	!(preg_match('/(.*)(?=\.(jpg|jpeg|png)$)/', $_FILES['img']['name'], $m))){
	$_FILES['img']['error'] += 1;
}
	if ($_FILES['img']['error'] > 0){
		$error = "Error";
	}
	else{
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
			$upload = move_uploaded_file($_FILES['img']['tmp_name'], $acces_path);
			}
			$req = "UPDATE accountinfos SET avatar='".$acces_path."' WHERE username='".$username."'";
			$act = $connect->prepare($req);
			$act->execute();
	}
	header ('Location: ./index.php');
?>
