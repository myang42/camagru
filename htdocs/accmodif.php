<?php
	session_start();
?>

<html><body>
	<form action="accmodifdata.php" method="post" name="formulaire" >
		MODIF
		<p>NEW LOGIN: <input type="text" name="newlog" value=""></p>
		<br />
		<p>NEW PASSWORD: <input type="text" name="newpassword" value=""></p>
		<p>CONFIRM PASSWORD: <input type="text" name="confirmpass" value=""></p>
		<br />
		<p>EMAIL: <input type="text" name="newmail" value=""></p>
		<p>CONFIRM EMAIL: <input type="text" name="confirmmail" value=""></p>
		<input type="submit" name="SUBMIT">
	</form>
	<form method="post" action="./uploadavatar.php" enctype="multipart/form-data">
		<label for="img">Selected file (JPG, JPEG or PNG):</label>
		<br><input type="file" name="img">
		<input type="submit" name="submit" value="Submit">
	</form>
</body><html>
