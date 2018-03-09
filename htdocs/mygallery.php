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
	// include('uploadimg.php')
?>
	<div class="choice">
		<center>
		<div id="selectfile" style="display : none;
									width: 600px;
									height: 500px;">
			<form method="post" enctype="multipart/form-data" action= "uploadimg.php" style="position: relative;
																							background-color: rgba(255,255,255,.8);
																							padding: 6em;
																							border: dotted #E79A7D 2px;">
			<label for="img">Selected file (JPG, JPEG or PNG):</label>
			<br><input type="file" name="img">
			<br><input type="submit" name="submit" value="Submit">
			</from>

			<a href="mygallery.php" alt="revenir"><p>Back</p></a>
		</div>
		<div id="selectmode" style="display=block">
			<ul>
				<li><a href="cam.php" style="width:100%;height:100%;display:block">Take picture</a></li>
				<li>
					<a href="#" style="width:100%;height:100%;display:block" onclick="displayselectfile()">Upload an image</a>
				</li>
			</ul>
		</div>
		</center>
	</div>

	<script>
		function displayselectfile(){
			var form = document.getElementById('selectfile');
			var type = document.getElementById('selectmode');
			form.style.display = "block";
			type.style.display = "none";
		}
	</script>
