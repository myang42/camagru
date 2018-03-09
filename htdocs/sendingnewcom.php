<?php

session_start();
require_once('./database.php');

$quoted = htmlspecialchars($_POST['commentaire'], ENT_QUOTES | ENT_HTML5);
$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
	if(isset($_POST['submitcom']) && $quoted != NULL && $_SESSION['username']){

		$addcom = "INSERT INTO comm (iduser, idpost,content, post_date)
					VALUES ((SELECT accountinfos.id FROM accountinfos WHERE username='". $_SESSION['username'] ."'),
				 ". $_POST['photoid'] . " , '". $quoted . "', CURRENT_TIMESTAMP); ";
	$addcomdo = $bd->prepare($addcom);
	$addcomdo->execute();
}
header("Location: ./index.php")
?>
