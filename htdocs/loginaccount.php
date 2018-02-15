<?php
	require_once('install.php');
	$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
		if ($connect){
			echo "alert('connecté');";
		}
?>

<html><body>
	<form action="login.php" method="post" name="formulaire" >
		LOG IN
		<p>USERNAME: <input type="text" name="user" value=""></p>
		<p>PASSWORD: <input type="text" name="password" value=""></p>
		<input type="submit" name="SUBMIT">
	</form>
	<br>
	<form action="create.php" method="post" name="formulaire" >
		CREATE NEW ACCOUNT
		<p>USERNAME: <input type="text" name="user" value=""></p>
		<p>PASSWORD: <input type="text" name="password" value=""></p>
		<p>CONFIRM PASSWORD: <input type="text" name="confirme" value=""></p>
		<p>EMAIL: <input type="text" name="mail" value=""></p>
		<input type="submit" name="SUBMIT">
	</form>
</body><html>
