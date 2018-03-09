<html>
	<head>
		<title>CAMAGRU</title>
		<link rel="stylesheet" href="./css/index.css">
		<link rel="stylesheet" href="./css/cam.css">
		<link rel="stylesheet" href="./css/yourimg.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="./js/menunav.js"></script>
		<!-- <script type="text/javascript" src="./js/cam.js"></script> -->
		<meta charset="UTF-8">
	</head>
	<body>
<?php
	session_start();

	require_once("menunav.php");
	require_once("footer.html");
	require_once('database.php');
	$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);

	function resize_if($w, $h,$res, $save){
		$file = $res['path_photo'];
		$infos = getimagesize($file);
		$type = $infos['mime'];

		if ($w >= $h){
			$nw = 1420;
			$nh = intval((1420 * $h) / $w);
		}
		else{
			$nw = intval((700 * $w) / $h);
			$nh = 700;
		}
		if ($type == 'image/png'){
				$newimg = imagecreatetruecolor($nw, $nh);
				imagealphablending($newimg, false);
				imagesavealpha($newimg, true);
				$trs = imagecolorallocatealpha($newimg, 255,255,255,127);
				imagefilledrectangle($newimg, 0, 0, $nw, $nh, $trs);
				$curimg = imagecreatefrompng($file);
				imagecopyresampled($newimg, $curimg, 0, 0, 0, 0, $nw, $nh, $w, $h);

				if ($save == true){
					unlink($file);
					imagepng($newimg, $file);
				}
				else
					imagepng($newimg, null);
				}
			else{
				$newimg = imagecreatetruecolor($nw, $nh);
				$curimg = imagecreatefromjpeg($file);
				imagecopyresized($newimg, $curimg, 0, 0, 0, 0, $nw, $nh, $w, $h);
				if ($save == true){
						unlink($file);
						imagejpeg($newimg, $file);
					}
				else
					imagejpeg($newimg, null);
			}
	}

	if ($connect){
		$req = "SELECT path_photo FROM photos_tmp
				WHERE username='".$_SESSION['username']."'";
		$do = $connect->prepare($req);
		$do->execute();
		$res = $do->fetch(PDO::FETCH_ASSOC);

		if ((list($w, $h) = getimagesize($res['path_photo'])) && ($w > 1420 || $h > 700)){
			resize_if($w, $h, $res, true);
			list($w, $h) = getimagesize($res['path_photo']);

		}

			$requete = "SELECT * FROM filters_table WHERE NOT path_img is NULL";
			$do2 = $connect->prepare($requete);
			$do2->execute();
			$nbr = 1;
		?>
		<div class="takepic">

			<div class="yourimg" style="position:relative;
										width: <?php echo $w;?>;
										height: <?php echo $h;?>">
			<img id="myimg" style="position:absolute;
									max-width: 1420px;
									max-height: 700px;"
							src="<?php echo $res['path_photo'];?>">

				<img id="filteroncanvas" alt="filterselected" src="./other/filters/frame_filter.png" style="position: absolute;
																										    bottom: 0;
																										    right: 0;
																										    width: 100%;
																										    height: 100%;">


			</div>
			<div style="position:relative; top:4em;">
			<div class="filters">
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

				<script>
					function displayselected(name, id){
						var canvas = document.getElementById('filteroncanvas');
						var myimg = document.getElementById('myimg');
						var filid = document.getElementById('filter_id');
						var filna = document.getElementById('filter_na');
							if (id > 2){
								if (myimg.clientWidth < myimg.clientHeight){
								canvas.style.width= "50%";
								canvas.style.height= "auto";
								}else{
									canvas.style.width= "auto";
									canvas.style.height= "50%";
								}
								if (id > 3 && id < 6){
									canvas.style.left = "0";
									canvas.style.right = "auto";
								}
								else{
									canvas.style.left = "auto";
									canvas.style.right = "0";
								}
							}
							else{
								canvas.style.width = "100%";
								canvas.style.height = "100%";
							}
							canvas.src = name;
							filid.value = id;
							filna.value = name;
						}
				</script>
			</div>
			<div class="submitarea"><center>
			<form method="POST" action="addfilter.php">
				<input type="hidden" name="photo" value="<?php echo $res['path_photo'];?>">
				<input id="filter_id" type="hidden" name="filter_id" value="1">
				<input id="filter_na" type="hidden" name="filter_name" value="./other/filters/frame_filter.png">
				<input type="submit" name="subfilter" value="Add another filter">
			</form>
			<form method="POST" action="submitfinalphoto.php">
				<input type="hidden" name="photo" value="<?php echo $res['path_photo'];?>">
				<input id="filter_id" type="hidden" name="filter_id" value="1">
				<input id="filter_na" type="hidden" name="filter_name" value="./other/filters/frame_filter.png">
				<input type="submit" name="subfinal" value="Submit">
			</form>
		</center></div>
	</div>
		<?php
	}
?>
</div>
</body>
</html>
