<html>
	<head>
		<title>CAMAGRU</title>
		<link rel="stylesheet" href="./css/index.css">
		<link rel="stylesheet" href="./css/gallery.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="./js/menunav.js"></script>
		<meta charset="UTF-8">
	</head>
	<body>
	<?php

		require_once("menunav.php");
		include("footer.html");
		session_start();
		require_once('./database.php');
		$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
		if ($bd){
			if($_GET['user']){
				if (!$_GET['page'])
					{
						$current_page = 1;
						$_GET['page'] = 1;
					}
				else
					$current_page = $_GET['page'];
				$lim = (6 * ($current_page - 1));
				// / MAX SIZE OF PAGE ///
				$rq = "SELECT COUNT('idpic') AS nbpic
						FROM gallery
						WHERE gallery.iduser=(SELECT id FROM accountinfos WHERE user='". $_GET['user']."');";
				$rs = $bd->prepare($rq);
				$rs->execute();
				$rt = $rs->fetch();
				$max_page = $rt['nbpic'];
			?>
				<div class="mainblockgallery">
					<center>
					<div class="galleryarea">
						<center id="table_gallery">

							<table><tr>

				<?php
				$who = $_GET['user'];
				$req = "SELECT	gallery.acces_path,
								gallery.title,
						        gallery.description,
						        gallery.iduser,
						        gallery.post_date,
						        gallery.idpic,
						        accountinfos.id,
						        accountinfos.user
						FROM gallery
						LEFT JOIN accountinfos
						ON accountinfos.id = gallery.iduser
						WHERE accountinfos.user = '".$who ."'
						ORDER BY gallery.post_date ASC
						LIMIT 6 OFFSET $lim;";
				$doreq = $bd->prepare($req);
				$doreq->execute();



				if ($current_page > 1){
					?>
					<td><a href="gallery.php?user=<?php echo $_GET['user'] ;?>&page=<?php echo($current_page - 1); ?>">
						<div type="submit" class="Nextgallery"
								style="background-image:url('./other/icons8-flèche-gauche-50.png');"></div></a>
					</td>
					<?php
				}
				while ($elem = $doreq->fetch(PDO::FETCH_ASSOC)){
					if ($elem){
								$link = preg_replace('/.*(?<=\/)/', '', $elem['acces_path']);
								?>
									<!-- //DISPLAY MINI-IMAGES -->
									<td><button
									style="background-image:url('<?php echo ''.$elem['acces_path'] ; ?>');"
									class="minipostgallery"
									onclick="Select('photo_s',
									 				'<?php echo $elem["acces_path"]; ?>',
													'<?php echo htmlspecialchars($elem["title"], ENT_QUOTES | ENT_HTML5);?>',
													'<?php echo htmlspecialchars($elem["description"], ENT_QUOTES| ENT_IGNORE | ENT_HTML5);?>' );"></button></td>
									<!-- //END OF DISPLAY -->
							<!-- // -->
								<?php
									$last = $elem['acces_path'];
									$lastt = $elem['title'];
									$lastd = $elem['description'];
									$id = $elem['id'];
									$name = $elem['user'];
							}
						}
						if ($current_page < $max_page / 6){
							?>
						<td><a href="gallery.php?user=<?php echo $_GET['user'];?>&page=<?php echo($current_page + 1); ?>">
							<div type="submit" class="Nextgallery"
									style="background-image:url('./other/icons8-flèche-droite-50.png');"></div></a>
						</td>
						<?php
						}
						?>
					</tr></table>
					</center>

						<!-- //Display Selected Photo -->
						<?php
							if ($last){
								?>
						<div id="photo_s" class="photo_sc" style="background-image:url('<?php echo $last; ?>')"></div>

						<div class="infophoto">
							<div id="titt"><?php echo $lastt;?></div>
							<div id="texxt"><?php echo $lastd;?></div>
							<?php
						if($_SESSION['user'] == $name){
							?>
						<form method="post" action="supprimg.php">
							<input style="background-image:url('./other/icons8-supprimer-limage-50.png');"
									class="delfromgallery"
									value=""
									type="submit"
									id="DEL_">
						</form>
						<?php
						}
						?>
						</div>
						<?php
						}
						?>

						</div></center></div>
						<script>
							function Select(id, path, titl,desc){
								document.getElementById(id).style.backgroundImage = 'url('+path+')';
								document.getElementById('titt').innerHTML = titl;
								document.getElementById('texxt').innerHTML = desc;
							}

						</script>
					<?php
					}

			}else{
				header ("Location: ./index.php");
			}

		?>
</body></html>
