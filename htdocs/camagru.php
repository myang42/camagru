<html>
	<head>
		<title>CAMAGRU</title>
		<link rel="stylesheet" href="./css/index.css">
		<link rel="stylesheet" href="./css/cam.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="./js/menunav.js"></script>
		<!-- <script type="text/javascript" src="./js/camera.js"></script> -->
		<meta charset="UTF-8">
	</head>
	<body>
<?php
	session_start();
	require_once("menunav.php");
	require_once("footer.html");
	require_once('database.php');
	if ($_SESSION['username']){
		$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
		$w = 1420;
		$h = 700;
		$requete = "SELECT * FROM filters_table WHERE NOT path_img is NULL";
		$do2 = $connect->prepare($requete);
		$do2->execute();
		$nbr = 1;
?>
	<div class="takepic">
		<div class="yourcam">
			<canvas id="canvas"></canvas>
			<video id="video"></video>
			<img id="filteroncanvas" alt="filterselected" src="./other/filters/frame_filter.png" style="position: absolute;
																										bottom: 0;
																										right: 0;
																										width: 100%;
																										height: 100%;">
		</div>
		<div style="position:relative; top:4em;">
		<div class="filters" id="addfilid">
			<table id= "table">
				<tr>
				<?php
					while ($res2 = $do2->fetch(PDO::FETCH_ASSOC)){
						$acces = $res2['path_img'];
						$id = $res2['id'];
				?>
				<td><button value="<?php echo $res2['path_img'];?>" id="filter_<?php echo $nbr;?>"
					style="width:100%; height:100%;position:inherit;display:inline-block;" onclick="displayselected('<?php echo $acces;?>', '<?php echo $id; ?>')"></button></td>
				<?php
				$nbr += 1;
				}
				?>
				</tr>
			</table>
			</div>
<center>
			<button id="startbutton" disabled readonly>Take picture</button>
			<button id="restart">Take another picture</button>
			<form method="post" action="uploadcam.php">
				<input type="hidden" id="dakor" name="akor" value="">
				<input id="filter_id" type="hidden" name="filter_id" value="1" >
				<input id="filter_na" type="hidden" name="filter_name" value="./other/filters/frame_filter.png">
				<input type="submit" name="Submit" value="submit" id="sub" >
			</form>
</center>
			</div>



	<script>
		var streaming = false;
		var dakor = document.querySelector('#dakor');
		var video	= document.querySelector('#video');
		var canvas	 = document.getElementById('canvas');
		var startbutton	= document.querySelector('#startbutton');

		var width = video.clientWidth;
		var height = video.clientHeight;


		navigator.getMedia = (navigator.getUserMedia ||
		navigator.webkitGetUserMedia || navigator.mozGetUserMedia ||
		navigator.msGetUserMedia); //Get the Webcam

		navigator.getMedia(
			{
				video : true, // video on
				sound : false //audio off
			},
			function(stream){ //on success
				if(navigator.mozGetUserMedia){
					video.mozSrcObject = stream;
				} else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
			},
			function(error){ //if fail
				console.log("An error occured : " + error)
				return;
			}
		)


			video.addEventListener('canplay', function(ev){
				if (!streaming) {
					height = video.videoHeight / (video.videoWidth/width);
					video.setAttribute('width', width);
					video.setAttribute('height', height);
					canvas.setAttribute('width', width);
					canvas.setAttribute('height', height);
					streaming = true;
					document.getElementById('startbutton').disabled = false;
				}
			}, false);

			function takepicture() {
				canvas.width = width;
				canvas.height = height;
				canvas.getContext('2d').drawImage(video, 0, 0, width, height);
				var data = canvas.toDataURL('image/png');
				dakor.value = data;
				// console.log(data);
				// photo.setAttribute('src', data);
			}

			startbutton.addEventListener('click', function(ev){
				takepicture();
				ev.preventDefault();
				canvas.style.display = "block";
				video.style.display= "none";
				document.getElementById('restart').style.display = "inline-block";
				startbutton.style.display = "none";
				document.getElementById('sub').style.display = "inline-block";
				document.getElementById('addfilid').style.display = "none";
			}, false);

			restart.addEventListener('click',function(ev){
				canvas.style.display = "none";
				video.style.display = "block";
				document.getElementById('restart').style.display = "none";
				document.getElementById('sub').style.display = "none";
				startbutton.style.display = "block";
				document.getElementById('addfilid').style.display = "block";
			},false);

			function displayselected(name, id){
				var fcanvas = document.getElementById('filteroncanvas');
				var myimg = document.getElementById('video');
				var filid = document.getElementById('filter_id');
				var filna = document.getElementById('filter_na');

					if (id > 2){
						if (myimg.clientWidth < myimg.clientHeight){
						fcanvas.style.width= "50%";
						fcanvas.style.height= "auto";
						}else{
							fcanvas.style.width= "auto";
							fcanvas.style.height= "50%";
						}
						if (id > 3 && id < 6){
							fcanvas.style.left = "0";
							fcanvas.style.right = "auto";
						}
						else{
							fcanvas.style.left = "auto";
							fcanvas.style.right = "0";
						}
					}
					else{
						fcanvas.style.width = "100%";
						fcanvas.style.height = "100%";
					}
					fcanvas.src = name;
					filid.value = id;
					filna.value = name;

				}

	</script>


<?php
	}else{
		header("Location: ./loginaccount.php");
	}
?>
</body></html>
