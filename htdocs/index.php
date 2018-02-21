<html>
	<head>
		<title>CAMAGRU</title>
		<link rel="stylesheet" href="./css/index.css">
		<link rel="stylesheet" href="./css/photomodal.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="./js/menunav.js"></script>
		<!-- <script type="text/javascript" src="./js/index.js"></script> -->
		<meta charset="UTF-8">
	</head>
	<body>
	<?php

		require_once("menunav.php");
		session_start();
		// require_once("install.php");
		require_once('./database.php');
		include("./verification.php");
		$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
		// include("gallery_plus.php");
		// require_once("index.html");
		?>
		<div class="mainblockindex">
		<?php //IF YOU ARE CONNECTED ///
		if ($_SESSION['user']){
			$me = username($_SESSION['username'], $bd);
			?>
				<div id="menu" class="menu" style ="position: inherit;
				min-width: 150px;
				width: 12vw;
				background-color:#F8B8A2;
				margin-left: 2%;">
					<img src="<?php echo $me['avatar']; ?>" id="useravatar">
					<!-- <div id="useravatar" style=""></div> -->

				<h1><?php echo ($_SESSION['user']);?></h1>
				<p><?php echo ($_SESSION['mail']);?></p>
				<p>Membre since: <?php echo ($_SESSION['date_inscription']);?></p>
				<a href="accmodif.php">modifier</a>
				</div>
				<?php
					}
					else{
				?>
					<div id="menu"></div>
				<?php
					}
				?>

				<center>
				<div class="photoarea" id="photoarea">
					<center>
					<?php
					if (!$_GET['page'])
						{
							$current_page = 1;
							$_GET['page'] = 1;
						}
					else
						$current_page = $_GET['page'];


					if ($bd){
						/// MAX SIZE OF PAGE ///
							$rq = "SELECT COUNT('idpic') AS nbpic FROM gallery WHERE 1";
							$rs = $bd->prepare($rq);
							$rs->execute();
							$rt = $rs->fetch();
							$max_page = $rt['nbpic'];
						///

					$nbr = 0;
					$lim = (6 * ($current_page - 1));
					$req = "SELECT accountinfos.user, accountinfos.avatar , gallery.acces_path FROM gallery
							INNER JOIN accountinfos
							ON gallery.iduser = accountinfos.id
							ORDER BY post_date DESC LIMIT 6 OFFSET $lim";
					$res = $bd->prepare($req);
					$res->execute();
					while ($elem = $res->fetch(PDO::FETCH_ASSOC)){
							if ($elem){
								$nbr += 1;
								$link = preg_replace('/.*(?<=\/)/', '', $elem['acces_path']);
								?>

								<div class="mymodal" id="<?php echo $nbr ?>">
									<span class="close cursor" onclick="closeModal(<?php echo $nbr; ?>)">&times;</span>
									<div class="modalcontent">
										<div style="
										background-color: black;
										background-image:url('<?php echo ''.$elem['acces_path'] ; ?>');
										background-repeat : no-repeat;
										background-position: 50% 50%;
										background-size:100%;
										width:50em;
										height:100%;
										position: relative;
										display: inline-block;
										top: 0;
										left : 0;"
										></div>
										<div class="textphoto">
											<div class="infosmodal">
											<img src='<?php echo $elem['avatar'];?>' alt='<?php echo $elem['user'];?>.avatar' style="width:150px;height:150px;">
												<?php echo $who['user'] ;?>
												<br />

										</div>
											<div class="commmodal">
												Blah blah blah
											</div>
										</div>
									</div>
								</div>

									<div
									style="
									background-color: black;
									background-image:url('<?php echo ''.$elem['acces_path'] ; ?>');
									min-width:96px;
									width:10vw;
									min-height:96px;
									height:10vw;
									max-width:150px;
									max-height:150px;
									display:inline-block;
									background-repeat: no-repeat;
									background-position: 50% 50%;
									background-size:150%;
									position:relative;
									padding: 5%;
									margin-left:2%;
									margin-right:2%;
									margin-top:2%;"
									onclick="openModal(<?php echo $nbr; ?>);">
								</div>

								<!-- //REGARDER LE LIEN CI JOINT : https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_js_lightbox // -->

								<?php
								}
							}
							?>
							<script>
								function openModal(nbr){
									document.getElementById(nbr).style.display = "block";
								}
								function closeModal(nbr){
									document.getElementById(nbr).style.display = "none";
								}
							</script>

				<?php
					}
					?>

				</center>
				<!-- Pagination-->
				<br>
				<?php
					if ($current_page > 1){
				?>
				<a href="index.php?page=<?php echo($current_page - 1);?>">previous</a>
				<?php
				}
				?>
				<?php echo ($current_page); ?>
				<?php
					if ($current_page < $max_page / 6){
				?>
				<a href="index.php?page=<?php echo($current_page + 1); ?>">next</a>
				<?php
				}
				?>



				</div>
			</div>
		</center>


</body>
</html>
