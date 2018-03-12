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
		include("footer.html");
		session_start();
		require_once('install.php');
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

				<h1 style="font-size:100%;word-wrap: break-word;"><?php echo ($_SESSION['user']);?></h1>
				<p style="word-wrap: break-word;"><?php echo ($_SESSION['mail']);?></p>
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
					$req = "SELECT gallery.idpic, accountinfos.user, accountinfos.avatar , gallery.acces_path , gallery.description, gallery.post_date, gallery.modif_date, gallery.title
							FROM gallery
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
									<div class="modalcontent">
									<span class="close cursor" onclick="closeModal(<?php echo $nbr; ?>)">&times;</span>

										<div class="photocontent">
										<div style="
										background-color: black;
										background-image:url('<?php echo ''.$elem['acces_path'] ; ?>');
										background-repeat : no-repeat;
										background-position: 50% 50%;
										height:100%;
										width:100%;"
										></div>
										</div>
										<div class="textphoto">
											<div class="infosmodal">
											<div style="background-color: black;
											background-image:url('<?php echo $elem['avatar'] ; ?>');
											background-repeat : no-repeat;
											background-position: 50% 50%;
											background-size:100%;
											height:150px;
											width:150px;
											float:left"></div>
											<?php
											echo "<span style='float:left;color:E58331; padding-left:2%'><b>" .$elem['user']. "</b></span>";
											echo "<span style='float:right;font-size:0.8em; color:#ababab;'>";
											if ($elem['modif_date'] == NULL)
												echo $elem['post_date'] . "</span>";
											else
												echo $elem['modif_date'] . "</span>";
											echo "<br />";
											echo "<p style='float:right; width:60%;margin:0;'>
											<span style='font-size:1.7em; padding-left:2%;float:left;'><b>" . $elem['title']."</b></span>
											<br / >
											<span style='float:left;padding:1%;'>\"" . $elem['description'] . "\"</span></p>";
											?>
										</div>
										<br />
												<!-- Ajouter un Commentaire START-->

											<div class="commmodal">
												<?php
												if ($_SESSION['username']){
													?>
												<form  method="post" action="./sendingnewcom.php">
													<textarea value="" name="commentaire" style="margin:0;
																								padding:0;
																								width:100%;
																								height:150px;
																								resize: none;
																								border-radius: 10px;
																								border-color: #E79A7D"></textarea>
													<input type="hidden" name="photoid" value="<?php echo $elem['idpic']; ?>">
													<input type="submit" name="submitcom" value="Submit">
												</form>
												<?php
											}
											?>
												<!-- Ajouter un Commentaire END-->

												<!-- Afficher les commentaires START-->
												<div style="width:100%; height:295px;overflow:auto">
												<table style="width:100%;">
												<?php
													$comreq = "SELECT comm.content, comm.post_date, accountinfos.user, accountinfos.avatar
																FROM gallery
																INNER JOIN comm
																ON gallery.idpic = comm.idpost
																INNER JOIN accountinfos
																ON accountinfos.id = gallery.iduser
																WHERE comm.idpost = ". $elem['idpic']."
																ORDER BY post_date DESC;";
													$commdo = $bd->prepare($comreq);
													$commdo->execute();
													while($commcont = $commdo->fetch(PDO::FETCH_ASSOC)){
														?>
															<tr><th><?php echo $commcont['content']; ?></th></tr>
														<?php
													}
												?>
											</table></div>
											<!-- Afficher les commentaires END-->

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



				</div>
				<div class="pagination">
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
