<?php
	session_start();

	function error_pwd($type){
		if ($type == 1){
			echo "<script type='text/javascript'>
			alert('Your New Password Needs at least One UpperCase, One LowerCase, One Number.');
			window.location.href='./accmodif.php';
			</script>";
		}
		else if ($type == 2){
			echo "<script type='text/javascript'>
			alert('Your New Password Needs to have at least 6 characters');
			window.location.href='./accmodif.php';
			</script>";
		}
		else{
			echo "<script type='text/javascript'>
			alert('Your New Password and the Confirmed one Are NOT the same.');
			window.location.href='./accmodif.php';
			</script>";
		}
	}

	function error_mail(){
		echo "<script type='text/javascript'>
		alert('WRONG EMAIL');
		window.location.href='./accmodif.php';
		</script>";
	}

	function changepwd(){
		$newpwd = $_POST['newpassword'];
		$usr = $_SESSION['user'];
		require_once("database.php");
		$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
		if ($bd){
			$req = "UPDATE accountinfos SET password='".$newpwd."' WHERE user='".$usr."'";
			$act = $bd->prepare($req);
			$act->execute();
		}
	}

	function changemail(){
		$newpwd = $_POST['newmail'];
		$usr = $_SESSION['user'];
		require_once("database.php");
		$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
		if ($bd){
			$req = "UPDATE accountinfos SET mail='".$newpwd."' WHERE user='".$usr."'";
			$act = $bd->prepare($req);
			$act->execute();
		}
		header ('Location: ./accmodif.php');
	}

	if ($_POST['newpassword'] && $_POST['confirmpass']){
		if ($_POST['newpassword'] == $_POST['confirmpass']){
			if (strlen($_POST['newpassword']) >= 6){
				$k = preg_match('/^(?=.*[a-z])(?=.*[0-9])(?=.*[A-Z])([\\w-\\.]+)$/', $_POST['newpassword']);
				if ($k)
					changepwd();
				else
					error_pwd(1);
			}
			else
				error_pwd(2);
		}
		else
	 		error_pwd(3);

	}

	if (isset($_POST['newmail'])){
		if ($_POST['newmail'] === $_POST['confirmmail']){
			changemail();
		}
		else
			error_mail();
	}
	// header ('Location: ./accmodif.php');
?>