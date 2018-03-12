<div class="header">

	<!--    LEFT NAV MENU  !-->

	<div class="iconmenul iconm" id="homeicon">
		<a href="index.php" style="position:inherit;margin:0;padding:0;width:100%;"><img src="./other/icons8-home-50.png" alt="home" title="home" ></a>
	</div>
	<div class="iconmenul iconm" id="photoicon" style="display:inline-block;">
		<a href="camagru.php" style="position:inherit;margin:0;padding:0;width:100%;"><img src="./other/icons8-compact-camera-50.png" alt="cam" title="cam" ></a>
	</div>

	<!--    RIGHT NAV MENU  !-->
		<!--    if you are logout/login  !-->
	<?php
		session_start();
		if ($_SESSION['user'] == NULL){
		?>
			<div class="iconmenur iconm" id="loginicon">
				<a href="loginaccount.php" style="position:inherit;margin:0;padding:0;width:100%;"><img src="./other/icons8-login-50.png" alt="login" title="login" ></a>
			</div>
	 	<?php
		}
		else{
		?>
			<div class="iconmenur iconm" id="loginicon">
				<a href="logout.php" style="position:inherit;margin:0;padding:0;width:100%;"><img src="./other/icons8-shutdown-50.png" alt="logout" title="logout" ></a>
			</div>
		<?php
			}
		?>

	<div class="iconmenur iconm" id="searchicon">
		<a href="faq.php" style="position:inherit;margin:0;padding:0;width:100%;"><img src="./other/icons8-help-50.png" alt="faq" title="faq" ></a>

		<!-- <a href="mygallery.php" style="position:inherit;margin:0;padding:0;width:100%;"><img src="./other/icons8-photo-gallery-50.png" alt="myGallery" title="myGallery" ></a> -->
	</div>
	<div class="iconmenur iconm" id="faqicon">
		<?php
			if ($_SESSION['user'] != NULL){
					?>
					<a href="mygallery.php" style="position:inherit;margin:0;padding:0;width:100%;"><img src="./other/icons8-photo-gallery-50.png" alt="myGallery" title="myGallery" ></a>

		<?php
		}
		?>
	</div>
	<div class="iconmenur iconm" id="menuicon">
		<img src="./other/icons8-menu-50.png" alt="menu" title="" >
	</div>
	<a href="index.php" alt="index"><span>CAMAGRU</span></a>
</div>
