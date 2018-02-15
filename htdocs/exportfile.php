<?php
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
	get_pict();
		header("Location: cam.php");
?>
