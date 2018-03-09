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
	$usr = htmlspecialchars($_POST['user'], ENT_QUOTES | ENT_HTML5);
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
			$username = md5(uniqid(rand(), true));
			$requete = "INSERT INTO accountinfos (user, password, groupe, mail, date_inscription, username, avatar)
						VALUES ('".$usr."','".$password."','member','".$mail."', CURRENT_DATE, '". $username."', './other/member.png')";
					echo $requete;

			$act = $bd->prepare($requete);
			$do = $act->execute();
			if (!file_exists("./photos/".$username)){
				mkdir("./photos/".$username);
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

function username($username, $bd){

		$requete = "SELECT * FROM accountinfos WHERE username='".$username."'";
		$act = $bd->prepare($requete);
		$act->execute();
		$res = $act->fetch(PDO::FETCH_ASSOC);
		if ($res != NULL){
			return($res);
		}
		return(NULL);
}

function whoisit(){
	$req = "SELECT accountinfos.user, accountinfos.avatar FROM gallery
			INNER JOIN accountinfos
			ON gallery.iduser = accountinfos.id";
}

?>
