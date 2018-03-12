<html>
	<head>
		<title>CAMAGRU</title>
		<link rel="stylesheet" href="./css/index.css">
		<link rel="stylesheet" href="./css/account.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="./js/menunav.js"></script>
		<meta charset="UTF-8">
	</head>
	<body>
<?php
	session_start();
	$error = array('newlog' => 0, 'newmail' => 0, 'newpass' => 0);
	include('accmodifdata.php');
	require_once("menunav.php");
	include("footer.html");
	if ($_SESSION['username']){
?>

<div class="dataarea">
	<table><td>
	<div class="personnalinfos">
	<form action="accmodif.php" method="post" name="formulaire" >
		<p>NEW LOGIN: <input type="text" name="newlog" value="<?php echo $_SESSION['user'];?>">
		<?php
			if ($error['newlog'] == 1){
				 echo "<br><span style='color:red; font-size:.8em;'>This login is already used.</span>";
			}
			else if ($error['newlog'] == 2){
				 echo "<br><span style='color:red; font-size:.8em;'>Lenght must be under 12 characters</span>";
			}
			else if ($error['newlog'] == 3){
				 echo "<br><span style='color:red; font-size:.8em;'>Empty field</span>";
			}
		?>
		</p>
		<br />
		<p>NEW PASSWORD: <input type="password" name="newpassword" value="">
		<?php
			if ($error['newpass'] == 2){
				 echo "<br><span style='color:red; font-size:.8em;'>If you want to change your current password, you should use another one...</span>";
			}
			else if ($error['newpass'] == 1){
				echo "<br><span style='color:red; font-size:.8em;'>This field is empty</span>";
			}
			else if ($error['newpass'] < 0){
				echo "<br><span style='color:red; font-size:.8em;'>Password needs to have at least 6 characters, 1 uppercase, 1 lowercase and 1 number</span>";
			}
		?>
		</p>
		<p>CONFIRM PASSWORD: <input type="password" name="confirmpass" value="">
			<?php
				if ($error['newpass'] > 2){
					 echo "<br><span style='color:red; font-size:.8em;'>The confirmation and the new one are not the same.</span>";
				}
			?>
			</p>
		<br />
		<p>EMAIL: <input type="text" name="newmail" value="<?php echo $_SESSION['mail'];?>">
			<?php
				if ($error['newmail'] == 1){
					 echo "<br><span style='color:red; font-size:.8em;'>This e-mail is aleady used.</span>";
				}
			?>
			</p>
		<p>CONFIRM EMAIL: <input type="text" name="confirmmail" value="">
			<?php
				if ($error['newmail'] == 2){
					 echo "<br><span style='color:red; font-size:.8em;'>The confirmation and the new one are not the same.</span>";
				}
			?>
			</p>
		<input type="submit" name="sub1" value="submit">
	</form>
</div>
</td><td>
	<div class="personnalphoto">
	<form method="post" action="./uploadavatar.php" enctype="multipart/form-data">
		<label for="img">Selected file (JPG, JPEG or PNG):</label>
		<br><input type="file" name="img">
		<br><br><input type="submit" name="sub2" value="submit">
	</form>
</div>
</td>
</table>
</div>

<?php
}else{
	header("Location: ./loginaccount.php");
}
?>

</body><html>
