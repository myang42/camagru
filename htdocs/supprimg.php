<?php
session_start();

function supprit($bd, $img, $where, $what){
	$suppr = "DELETE FROM $where
				WHERE $what= ". $img .";";
	$dosuppr = $bd->prepare($suppr);
	$dosuppr->execute();
}

if ($_SESSION['username'])
{
	require_once('./database.php');
	$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
	$img = $_POST['subsuppr'];

	if ($bd){
		$exists = "SELECT accountinfos.username,
							accountinfos.id,
							gallery.idpic,
							gallery.iduser
							FROM accountinfos
							LEFT JOIN gallery
							ON gallery.iduser = accountinfos.id
							WHERE gallery.idpic = ".$img.";";
		$doexists = $bd->prepare($exists);
		$doexists->execute();
		$check  = $doexists->fetch();

		if ($check['username'] != $_SESSION['username']){
			echo "<script type='text/javascript'>
			alert('An error has occurred, try it later...');
			window.location.href  = './index.php';
			</script>";

		}else{
			supprit($bd, $img, 'like_photos', 'like_photos.idpost');
			supprit($bd, $img, 'comm', 'comm.idpost');
			supprit($bd, $img, 'gallery', 'gallery.idpic');
		}
	}
	if ($_POST['pos'])
		header('Location: ./index.php?page='. $_POST['pos']);
	else
		header('Location: ./index.php');

}else{
	header('Location: ./loginaccount.php');
}
?>
