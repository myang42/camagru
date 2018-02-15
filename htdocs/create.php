<?php
session_start();
include("./verification.php");

	function error(){
		$_SESSION['user'] = NULL;
	}

	if ($_POST['password'] && $_POST['user']){
		if (strlen($_POST['password']) >= 6 && strlen($_POST['user']) >= 6){
		$k = preg_match('/^(?=.*[a-z])(?=.*[0-9])(?=.*[A-Z])([\\w-\\.]+)$/', $_POST['password'], $m);
		if ($k){
				if (($who = create()) != 0){
					$_SESSION['user'] = $_POST['user'];
					$_SESSION['mail'] = $who['mail'];
					$_SESSION['password'] = $who['password'];
					$_SESSION['date_inscription'] = $who['date_inscription'];
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
