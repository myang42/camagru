<html>
	<head>
		<title>CAMAGRU</title>
		<link rel="stylesheet" href="./css/index.css">
		<link rel="stylesheet" href="./css/uploadfile.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="./js/menunav.js"></script>
		<meta charset="UTF-8">
	</head>
	<body>
<?php
	require_once("menunav.php");
?>
<div class="choice">
	<form method="post" action="./uploadfile.php" enctype="multipart/form-data">
		<label for="img">Selected file (JPG, JPEG or PNG):</label>
		<br><input type="file" name="img">
		<br>
		<br><label for="title">Image's title (max 26 characters)</label><br />
		<input type="text" name="title" value="">
		<br>
		<br><label for="descriptionfile">Image's description (max 254 characters)</label><br />
		<textarea id="textdescription" name="descriptionfile" value=""></textarea>
		<br>
		<input type="submit" name="submit" value="Submit">
	</form>
</div>
