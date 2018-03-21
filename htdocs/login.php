<?php
session_start();
include("./verification.php");
if (!$_SESSION['username'])
{
	if (($who = login()) != 0){
		mail('magapadie@gmail.com', 'BONJOUR_MOI', 'CONTENT');
		$_SESSION['user'] = $_POST['user'];
		$_SESSION['mail'] = $who['mail'];
		$_SESSION['password'] = $who['password'];
		$_SESSION['date_inscription'] = $who['date_inscription'];
		$_SESSION['username'] = $who['username'];
	}
}
header ('Location: ./index.php');

?>
