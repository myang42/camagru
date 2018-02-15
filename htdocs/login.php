<?php
session_start();
include("./verification.php");
if (($who = login()) != 0){
	$_SESSION['user'] = $_POST['user'];
	$_SESSION['mail'] = $who['mail'];
	$_SESSION['password'] = $who['password'];
	$_SESSION['date_inscription'] = $who['date_inscription'];
}
else{
	$_SESSION['user'] = NULL;
	$_SESSION['mail'] = NULL;
	$_SESSION['date'] = NULL;
}
header ('Location: ./index.php');

?>
