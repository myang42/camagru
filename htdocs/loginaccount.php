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
	require_once('./database.php');
	require_once("menunav.php");
	include("footer.html");
	if (!$_SESSION['username']){
?>

<div class="dataarea">
	<table>
	<tr><th>LOG IN</th>
		<th>CREATE A NEW ACCOUNT</th>
	</tr>
	<tr>
	<td>
	<div class="personnalinfos">
	<form action="login.php" method="post" name="formulaire" >
		<p>USERNAME: <input type="text" name="user" value="" ></p>
		<p>PASSWORD: <input name="password" value="" type="password"></p>
		<input type="submit" name="SUBMIT">
	</form>
</div>
</td><td>
	<div class="personnalinfos">
	<form action="create.php" method="post" name="formulaire" >
		<p>USERNAME: <input type="text" name="user" value="" type="password">
		<span style="font-size:.7em;">(under 12 characters)</span></p>
		<p>PASSWORD: <input name="password" value="" type="password">
		<span style="font-size:.7em;">(more than 6 characters. it needs uppercase, lowercase and number)</span></p>
		<p>CONFIRM PASSWORD: <input type="password" name="confirme" value=""></p>
		<p>EMAIL: <input type="text" name="mail" value=""></p>
		<input type="submit" name="SUBMIT">
	</form>
	</div>
</td></tr></table>

<?php
}else{
	header("Location: ./index.php");
}
?>


</body><html>
