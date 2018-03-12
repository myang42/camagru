<?php
	session_start();
	require_once("database.php");
	include("verification.php");
	if ($_SESSION['usermame']){

	$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);

	function changeinfos($bd, $new, $needed, $val){
		$new = htmlspecialchars($new, ENT_QUOTES | ENT_HTML5 );
		if ($bd){
			if ($val == true){
				$check = "SELECT ".$needed." FROM accountinfos WHERE " . $needed . "='".$new."'";
				$do = $bd->prepare($check);
				$do->execute();
				$res = $do->fetch(PDO::FETCH_ASSOC);
			}
			else
				$res = false;
			if (!$res){
				$usr = username($_SESSION['username'], $bd);
				$req = "UPDATE accountinfos SET ". $needed ."='".$new."' WHERE username='".$usr['username']."'";
				$act = $bd->prepare($req);
				$act->execute();
				$_SESSION[$needed] = $new;
				return(true);
			}
		}
		return(false);
	}

	$pass = hash('whirlpool',$_POST['newpassword']);
	if (($_POST['newmail'] && $_POST['confirmmail']) ||
	 ($_POST['newlog'] && $_POST['newlog'] != $_SESSION['user']) ||
	  ($_POST['newpassword'] )) {
		$error['newlog'] = 0;
		$error['newpass'] = 0;
		$error['newmail'] = 0;
		if ($_POST['newmail'] && $_POST['newmail'] != $_SESSION['mail'] && $_POST['newmail'] == $_POST['confirmmail']){
			if (changeinfos($bd, $_POST['newmail'], 'mail', true) == false){
				$error['newmail'] = 1;
			}
		}
		else if ($_POST['confirmmail'] && $_POST['newmail'] && $_POST['newmail'] == $_SESSION['mail']){
			$error['newmail'] = 1;
		}
		else if ($_POST['newmail'] && $_POST['confirmmail'] && $_POST['newmail'] != $_POST['confirmmail']){
			$error['newmail'] = 2;
		}
		if ($_POST['newlog'] && $_POST['newlog'] != $_SESSION['user']){
			if (strlen($_POST['newlog']) >= 13){
				$error['newlog'] = 2;
			}
			else if (trim($_POST['newlog']) == NULL){
				$error['newlog'] = 3;
			}
			else{
				if (changeinfos($bd, $_POST['newlog'], 'user', true) == false){
					$error['newlog'] = 1;
				}
			}
		}
		if ($_SESSION['password'] == $pass){
			$error['newpass'] = 2;
		}
		else if ($_POST['newpassword'] && $_SESSION['password'] != $pass){

			if ($_POST['confirmpass'] != NULL && $_POST['newpassword'] != $_POST['confirmpass']){
				$error['newpass'] = 3;
			}
			else if ($_POST['confirmpass'] != NULL && $_POST['newpassword'] == $_POST['confirmpass'])
			{
				$k = preg_match('/^(?=.*[a-z])(?=.*[0-9])(?=.*[A-Z])([\w\-\.]+)$/', $_POST['newpassword'], $m);
				if (strlen($_POST['newpassword']) >= 6 && $k){
					if (changeinfos($bd, $pass, 'password', false) == false){
						$error['newpass'] = 1;
					}
				}
				else
					$error['newpass'] = -1;
			}
			else if ($_POST['newpassword'] != NULL && $_POST['confirmpass'] == NULL){
				 $error['newpass'] = 3;
			}
		}
		else if ($_POST['confirmpass'] &&
		$_POST['newpassword'] == $_POST['confirmpass'] &&
		$pass == $_SESSION['password']){
				$error['newpass'] = 2;
		}
		else if ($_POST['newpassword'] != NULL && !$_POST['confirmpass']){
			 $error['newpass'] = 3;
		}
		if ($error['newlog'] == 0 && $error['newpass'] == 0 && $error['newmail'] == 0){
			echo "<script type='text/javascript'>
			alert('All informations are now updated.');
			window.location.href='./accmodif.php';
			</script>";
		}
	}
	else{
		if (isset($_POST['sub1'])){
			$error['newlog'] = 1;
			$error['newpass'] = 1;
			$error['newmail'] = 1;
		}
	}
}else{
	header("Location: ./loginaccount.php");
}
?>
