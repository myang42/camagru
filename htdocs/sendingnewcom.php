<?php
session_start();
require_once('./database.php');

if ($_SESSION['username']){
	$quoted = trim(htmlspecialchars($_POST['commentaire'], ENT_QUOTES | ENT_HTML5));
	$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
		if($_POST['pict'] && $quoted != NULL && $bd){
			$compo = $_POST['pict'];

			$ifexists = "SELECT gallery.idpic, comm.idpost
							FROM gallery
			                LEFT JOIN comm
			                ON comm.idpost=gallery.idpic
			                WHERE gallery.idpic = ". $compo .";";
			$check = $bd->prepare($ifexists);
			$check->execute();
			$rescheck = $check->fetch(PDO::FETCH_ASSOC);
			print_r($rescheck);
			if ($rescheck['idpic']){
				$addcom = "INSERT INTO comm (iduser, idpost,content, post_date)
							VALUES ((SELECT accountinfos.id FROM accountinfos WHERE username='". $_SESSION['username'] ."'),
						 ". $compo . " , '". $quoted . "', CURRENT_TIMESTAMP); ";
				$addcomdo = $bd->prepare($addcom);
				$addcomdo->execute();
			}
		}
	if ($_POST['pos'])
		header("Location: ./index.php?page=" . $_POST['pos']);
	else
		header("Location: ./index.php");
}else{
	header("Location: ./loginaccount.php");
}


?>
