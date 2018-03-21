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
				<a href="./accmodif.php">modifier</a>
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
					$req = "SELECT gallery.idpic, accountinfos.user,
					accountinfos.username, accountinfos.avatar ,
					gallery.acces_path , gallery.description, gallery.post_date,
					gallery.modif_date, gallery.title
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

								<!-- //start modal -->
								<div class="mymodal" id="<?php echo $nbr ?>">
									<div class="modalcontent">
									<span class="close cursor" onclick="closeModal(<?php echo $nbr; ?>)">&times;</span>

										<div class="photocontent">
										<div style="
										background-color: black;
										background-image:url('<?php echo ''.$elem['acces_path'] ; ?>');
										background-repeat : no-repeat;
										background-position: 50% 50%;
										background-size: contain;
										height:100%;
										width:100%;">
											</div>
											</div>
										<div class="textphoto">
											<div class="infosmodal">
											<div style="background-color: black;
											background-image:url('<?php echo $elem['avatar'] ; ?>');
											background-repeat : no-repeat;
											background-position: 50% 50%;
											background-size:100%;
											height: 10vw;
											width: 10vw;
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
											<span style='font-size:1em; padding-left:2%;float:left;word-wrap: break-word;'><b>" . $elem['title']."</b></span>
											<br / ><br />
											<span style='padding: 1%;
														word-wrap: break-word;'>\"" . $elem['description'] . "\"</span></p>";
											?>
										</div>
											<!-- Ajout d'un LIKE / suppression -->
											<?php
												if ($_SESSION['username']){
													if ($_SESSION['username'] != $elem['username']){
														$doulik = "SELECT like_photos.iduser, like_photos.idpost, accountinfos.username, accountinfos.id FROM like_photos
																	INNER JOIN accountinfos
																	ON accountinfos.id = like_photos.iduser
																	WHERE accountinfos.username='" . $_SESSION['username']."'
																	AND like_photos.idpost=".$elem['idpic'].";";
															$dodoulik = $bd->prepare($doulik);
															$dodoulik->execute();
															$reslik = $dodoulik->fetch(PDO::FETCH_ASSOC);
														?>
															<form action="addlike.php" method="post">
																<input type="hidden" value=<?php echo $current_page; ?> name="pos">
																<button name="sublike" type="submit" value="<?php echo $elem['idpic']; ?>"
																	title="LIKE PHOTO"
																	class="likbut"
																	style="
																	<?php
																		if ($reslik['idpost']){
																			?>
																			background-image:url('./other/icons8-facebook-like-50.png');
																			<?php
																		}else{
																			?>
																			background-image:url('./other/icons8-facebook-like-50_.png');
																			<?php
																		}
																	?>"></button>
															</form>
														<?php
													}else if ($_SESSION['username'] == $elem['username']){
														?>
														<form action="supprimg.php" method="post">
															<input type="hidden" value=<?php echo $current_page; ?> name="pos">
															<button name="subsuppr" type="submit" value="<?php echo $elem['idpic']; ?>" class="likbut"
																style="background-image:url('./other/icons8-supprimer-limage-50.png');"
																title="DELETE PHOTO"></button>
														</form>
												<?php
													}
												}
											?>
										<br />
												<!-- Ajouter un Commentaire START-->

											<div class="commmodal">
												<?php
												if ($_SESSION['username']){
													?>
												<form  method="post" action="./sendingnewcom.php">
													<textarea value="" name="commentaire" style="margin:0;
																								padding:5%;
																								width:100%;
																								height:100px;
																								resize: none;
																								border-radius: 10px;
																								border-color: #E79A7D"></textarea>
													<input type="hidden" name="pos" value="<?php echo $current_page;?>">
													<button type="submit" name="pict" value="<?php echo $elem['idpic']; ?>" class="commbut"
															style="background-image:url('./other/icons8-envoyer-64.png');">
													</button>
												</form>
												<?php
											}
											?>
												<!-- Ajouter un Commentaire END-->

												<!-- Afficher les commentaires START-->
												<div style="width:100%; height:295px;overflow:auto">
												<table style="width:100%;">
												<?php
													$comreq = "SELECT comm.content, comm.post_date, accountinfos.user, comm.iduser, accountinfos.id
																FROM gallery
																INNER JOIN comm
																ON gallery.idpic = comm.idpost
																LEFT JOIN accountinfos
																ON accountinfos.id = comm.iduser
																WHERE comm.idpost = ". $elem['idpic']."
																ORDER BY post_date DESC;";
													$commdo = $bd->prepare($comreq);
													$commdo->execute();
													while($commcont = $commdo->fetch(PDO::FETCH_ASSOC)){
														?>
															<tr><th><?php 	echo "<span style='float:left;color:#FFAA7C;'>" . $commcont['user']."</span>";
																			echo "<span style='float:right;font-size:0.6em; color:#ababab;'>";
																			echo $commcont['post_date']."</span><br />";
																			echo "<p style='padding-left: 5%;
																				    margin: 0;'>" . $commcont['content'] . "</p>"; ?></th></tr>
														<?php
													}
												?>
											</table></div>
											<!-- Afficher les commentaires END-->

											</div>
										</div>
											<!-- //end of modal -->

									</div>
								</div>


									<div
									style="background-image:url('<?php echo ''.$elem['acces_path'] ; ?>');"
									class="minipost"
									onclick="openModal(<?php echo $nbr;?> );">
									<!-- <a href=""
										onclick="function(){


										}"
										class="linktopost">
									</a> -->

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
