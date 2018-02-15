<html>
	<head>
		<title>CAMAGRU</title>
		<link rel="stylesheet" href="./css/index.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="./js/menunav.js"></script>
		<!-- <script type="text/javascript" src="./js/index.js"></script> -->
		<meta charset="UTF-8">
	</head>
	<body>
	<?php
		session_start();
		require_once("menunav.php");
		// require_once("install.php");
		require_once('./database.php');





		// include("gallery_plus.php");
		// require_once("index.html");
		?>
		<div class="mainblockindex">
		<?php //IF YOU ARE CONNECTED ///
		if ($_SESSION['user']){
			?>

				<div id="menu" class="menu">
					<!-- <img src="" id="useravatar"> -->
					<div id="useravatar" style=""></div>

				<h1><?php echo ($_SESSION['user']);?></h1>
				<p><?php echo ($_SESSION['mail']);?></p>
				<p>Membre since: <?php echo ($_SESSION['date_inscription']);?></p>
				<a href="accmodif.php">modifier</a>
				</div>

				<?php
					}
				?>


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

					$bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
					if ($bd){
						/// MAX SIZE OF PAGE ///
							$rq = "SELECT COUNT('idpic') AS nbpic FROM gallery WHERE 1";
							$rs = $bd->prepare($rq);
							$rs->execute();
							$rt = $rs->fetch();
							$max_page = $rt['nbpic'];
						///

					$lim = (6 * ($current_page - 1));
					$req = "SELECT * FROM gallery ORDER BY post_date ASC LIMIT 6 OFFSET $lim";
					$res = $bd->prepare($req);
					$res->execute();
					while ($elem = $res->fetch(PDO::FETCH_ASSOC)){
							if ($elem){
								?>

									<div
									style="
									background-color: black;
									background-image:url('<?php echo './photos'.$elem['acces_path'] ; ?>');
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
									margin-top:2%;
									"></div>

								<?php
								}
							}
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


</body>
</html>
