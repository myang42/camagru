<html>
	<head>
		<title>CAMAGRU</title>
		<link rel="stylesheet" href="./css/index.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="./js/menunav.js"></script>
		<style>
			/* modal background */
			.modal{
				display:none;
				position: fixed;
				z-index:1;
				padding-top:100px;
				left:0;
				top:0;
				width:100%;
				height:100%;
				overflow:auto;
				background-color:rgb(0,0,0);
				background-color:rgba(0,0,0,.4);
			}

			.modalcontent{
				background-color:#fefefe;
				margin:auto;
				padding:20px;
				border: 1px solid #888;
				width:80%;
			}

			.close{
				color:#aaaaaa;
				float:right;
				font-size: 28px;
				font-weight: bold;
			}


			.close:hover, .close:focus{
				color: #000;
				text-decoration: none;
				cursor:pointer;
			}
		</style>
		<!-- <script type="text/javascript" src="./js/index.js"></script> -->
		<meta charset="UTF-8">
	</head>
	<body>
<?php
	require_once("menunav.php");
	session_start();
	require_once('./database.php');
?>
	<button id="custombutton" style="position:absolute;top:6em;">Test</button>
	<div id="modalid" class="modal">
		<div class="modalcontent">
		<span class="close">&times;</span><br />
		<?php
			echo '<img src="./photos/' . $_GET['camuser'] . '/' . $_GET['post'] . '" alt="'. $_GET['post'] .'">';
		?>
		</div>
	</div>

	<script>
		var modal = document.getElementById('modalid');
		var button = document.getElementById('custombutton');
		var toclose = document.getElementsByClassName('close')[0];

		button.onclick = function(){
			modal.style.display = "block";
		}

		toclose.onclick = function() {
			modal.style.display = "none";
		}

		window.onclick = function(event){
			if (event.target == modal){
				modal.style.display = "none";
			}
		}

	</script>

</body>
</html>
