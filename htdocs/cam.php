<html>
	<head>
		<title>CAMAGRU</title>
		<link rel="stylesheet" href="./css/index.css">
		<link rel="stylesheet" href="./css/cam.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="./js/menunav.js"></script>
		<!-- <script type="text/javascript" src="./js/cam.js"></script> -->
		<meta charset="UTF-8">
	</head>
	<body>
	<?php
		// Include("exportfile.php");
		require_once("menunav.html");
		require_once("footer.html");
		require_once("cam.html");
		if (!file_exists('./photos')){
			mkdir('./photos');
		}
		function get_pict(){
			if ($_POST['dakor']){
				$path = $_POST['dakor'];
				if (preg_match('/data:image\/png;base64,(.*)/', $path, $m))
					$owm = $m[1];
				// echo "[".$owm."]\n";
				// header('Content-Type: image/png');
				// echo "<html><body><img src='data:image/png;base64,".$owm."'><br /></body></html>";
				return($owm);
			}
			return(NULL);
		}
		?>
			<!-- <form action="cam.php" method="post" > -->
				<canvas id="canvas" style="position:absolute; top: 12em; z-index:10;display:block;"></canvas>
				<button id="startbutton"></button>
				<button id="freeze" style="display:block;width:100px; height:50px;background-color:red;position:absolute;"></button>
				<input type="hidden" id="dakor" name="dakor">
				<script src="js/camera.js"></script>
				<!-- <input type="hidden" id="dakor" name="dakor">
			</form> -->
		</div>
			<!-- <canvas id="canvas" style="position:absolute; top: 12em; z-index:10;display:block;"></canvas> -->
			<?php
			// if ($_POST['dakor']){
			// 	echo "<img src='data:image/png;base64,".get_pict()."'>";
			// }
			?>
</body>
</html>
