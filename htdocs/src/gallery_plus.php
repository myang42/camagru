<?php
// require_once("./database.php");
// $bd = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);

	function count_max_page(){
		if($bd){
		$r = "SELECT count('idpic') AS nbridpic FROM gallery WHERE 1";
		$do = $bd->prepare($r);
		$nb = $do->execute();
		if ($nb)
			return($nb);
	}
	return(1);
}
    // 
	// function aff_img(){
	// 	if ($bd){
	// 	$req = "SELECT * FROM gallery ORDER BY post_date LIMIT 4";
	// 	$res = $bd->prepare($req);
	// 	$res->execute();
	// 	$max_page =
	// 	while ($elem = $res->fetch(PDO::FETCH_ASSOC)){
	// 		echo $elem['title']."\n<br />";
	// 		// print_r($elem);
	// 	}
    //
	// 	}
	// }
