<?php
session_start();
include("./verification.php");

	function error(){
		echo "<script type='text/javascript'>
		alert('ERROR: You must follow the rules.');
		window.location.href='./index.php';
		</script>";
		$_SESSION['user'] = NULL;
	}

	if ($_POST['password'] && $_POST['user']){
		if (strlen($_POST['password']) >= 6 && strlen($_POST['user']) <= 12){
		$k = preg_match('/^(?=.*[a-z])(?=.*[0-9])(?=.*[A-Z])([\w\-\.]+)$/', $_POST['password'], $m);
		if ($k){
				if (($who = create()) != 0){
					$_SESSION['user'] = $_POST['user'];
					$_SESSION['mail'] = $who['mail'];
					$_SESSION['password'] = $who['password'];
					$_SESSION['date_inscription'] = $who['date_inscription'];
					$_SESSION['username'] = $who['username'];
				}
				else
					error();
			}
		}
		else
			error();
	}
	else
		error();
	header("Location: ./index.php");

?>
