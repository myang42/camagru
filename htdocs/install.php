<?php
	require_once("database.php");

	$bd = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
	$requete = "CREATE DATABASE IF NOT EXISTS cam DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
	$bd->prepare($requete)->execute();


// <-- CREATION DE LA LISTE DES UTILISATEURS -->
	$connect = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
	if ($connect){
		$requete = 'CREATE TABLE IF NOT EXISTS accountinfos
				(id INT PRIMARY KEY AUTO_INCREMENT NOT NULL, user VARCHAR(12)
				NOT NULL DEFAULT "visiteur", password VARCHAR(254) NOT NULL, groupe ENUM("admin", "member", "visitor")
				NOT NULL, mail VARCHAR(254), date_inscription DATE NOT NULL)';
		$do = $connect->prepare($requete);
		$do->execute();

	// <-- CREATION DE LA GALLERIE -->
		$requete3 = "CREATE TABLE IF NOT EXISTS gallery(
					username VARCHAR(12) NOT NULL,
					iduser INT NOT NULL,
					idpic INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
					title VARCHAR(26) NOT NULL DEFAULT 'photo',
					description VARCHAR(254),
					tags VARCHAR(254),
					acces_path VARCHAR(254) NOT NULL, post_date DATE NOT NULL,
					modif_date DATE)";
		$do = $connect->prepare($requete3);
		$do->execute();

	// <--INSERTION DE L ADMINISTRATEUR-->
		$mdp = hash('whirlpool', '0000Abcd');
		$req = 'SELECT user FROM accountinfos WHERE user = "admin"';
		$do = $connect->prepare($req);
		$do->execute();
		$res = $do->fetch(PDO::FETCH_ASSOC);
		if (!$res){
			$requete2 = 'INSERT INTO accountinfos(user,password,groupe, mail, date_inscription)
			VALUES ("admin", "' . $mdp . '", "admin", "user@user.com", CURRENT_DATE)';
			$do = $connect->prepare($requete2);
			$do->execute();
		}
		if (!file_exists("./photos/visitors")){
			mkdir("./photos/visitors");
	}
	}
?>