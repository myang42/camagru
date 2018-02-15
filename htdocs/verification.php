<?php
function login(){
	$usr = $_POST['user'];
	$pwd = hash('whirlpool', $_POST['password']);

	require_once("database.php");
	$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
	if ($bd){
		$requete = "SELECT * FROM accountinfos WHERE user LIKE '".$usr."'";
		$act = $bd->prepare($requete);
		$act->execute();
		$res = $act->fetch(PDO::FETCH_ASSOC);
		if ($res != NULL){
			$requete = "SELECT password FROM accountinfos WHERE user LIKE '".$usr."'";
			$act = $bd->prepare($requete);
			$act->execute();
			$res2 = $act->fetch(PDO::FETCH_ASSOC);
			if ($res2['password'] == $pwd)
				return($res);
			}
		}
	return(0);
}

function create(){
	$usr = $_POST['user'];
	$password = hash('whirlpool', $_POST['password']);
	$mail = $_POST['mail'];


	require_once("database.php");
	$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
	if ($bd){
		$requete = "SELECT user FROM accountinfos WHERE user LIKE '".$usr."'";
		$act = $bd->prepare($requete);
		$act->execute();
		$res = $act->fetch(PDO::FETCH_ASSOC);
		if ($res)
			return(0);
		else{
			$requete = "INSERT INTO accountinfos (user, password, groupe, mail, date_inscription)
			SELECT '".$usr."','".$password."','member','".$mail."', CURRENT_DATE()";
			$act = $bd->prepare($requete);
			$do = $act->execute();
			// $requete = "INSERT INTO testgallery(iduser) SELECT id FROM accountinfos WHERE user='".$usr."'";
			// $act = $bd->prepare($requete);
			// $act->execute();
			if (!file_exists("./photos/".$usr)){
				mkdir("./photos/".$usr);
			}
			$requete = "SELECT * FROM accountinfos WHERE user LIKE '".$usr."'";
			$act = $bd->prepare($requete);
			$act->execute();
			$res = $act->fetch(PDO::FETCH_ASSOC);
			return($res);
		}
	}
	return(0);
}

?>
