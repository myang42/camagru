<?php
	session_start();
	if ($_SESSION['user'] != NULL){
		$_SESSION['user'] = NULL;
		session_destroy();
	}
	header ("Location: ./index.php");
?>
