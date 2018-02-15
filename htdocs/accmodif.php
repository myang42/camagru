<?php
	session_start();
?>

<html><body>
	<form action="accmodifdata.php" method="post" name="formulaire" >
		MODIF
		<p>NEW PASSWORD: <input type="text" name="newpassword" value=""></p>
		<p>CONFIRM PASSWORD: <input type="text" name="confirmpass" value=""></p>
		<br />
		<p>EMAIL: <input type="text" name="newmail" value=""></p>
		<p>CONFIRM EMAIL: <input type="text" name="confirmmail" value=""></p>
		<input type="submit" name="SUBMIT">
	</form>
</body><html>
