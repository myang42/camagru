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
				NOT NULL DEFAULT "visitor", password VARCHAR(254) NOT NULL, groupe ENUM("admin", "member", "visitor")
				NOT NULL, mail VARCHAR(254), date_inscription DATE NOT NULL, avatar VARCHAR(254) NOT NULL DEFAULT "./other/member.png", username VARCHAR(33) NOT NULL)';
		$do = $connect->prepare($requete);
		$do->execute();

	// <-- CREATION DE LA GALLERIE -->
		$requete3 = "CREATE TABLE IF NOT EXISTS gallery(
					iduser INT NOT NULL,
					idpic INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
					title VARCHAR(26) NOT NULL DEFAULT 'photo',
					description VARCHAR(254),
					acces_path VARCHAR(254) NOT NULL, post_date DATETIME NOT NULL,
					modif_date DATETIME)";
		$do = $connect->prepare($requete3);
		$do->execute();

	// <--INSERTION DE L ADMINISTRATEUR-->
		$mdp = hash('whirlpool', '0000Abcd');
		$username = md5(uniqid(rand(), true));

		$req = 'SELECT user FROM accountinfos WHERE user = "admin"';
		$do = $connect->prepare($req);
		$do->execute();
		$res = $do->fetch(PDO::FETCH_ASSOC);
		if (!$res){
			$requete2 = 'INSERT INTO accountinfos(user,password,groupe, mail, date_inscription, username)
			VALUES ("admin", "' . $mdp . '", "admin", "user@user.com", CURRENT_DATE, "'. $username .'")';
			$do = $connect->prepare($requete2);
			$do->execute();
			if (!file_exists("./photos/" . $username)){
				mkdir("./photos/" . $username);
			}
		}
		// <-- CREATION DE LA DATABASE POUR COMMENTAIREs -->
		$req = 'CREATE TABLE IF NOT EXISTS comm(
    						id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         	iduser INT NOT NULL,
                           	idpost INT NOT NULL,
                           	content VARCHAR(254),
                           	post_date DATETIME NOT NULL);';
		$do = $connect->prepare($req);
		$do->execute();

		// <-- CREATION DE LA DATABASE POUR LES PHOTOS_TEMPORAIRE -->
		$req = 'CREATE TABLE IF NOT EXISTS photos_tmp(
							id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
							username VARCHAR(254) NOT NULL,
							path_photo VARCHAR(254) DEFAULT NULL
				);';
		$do = $connect->prepare($req);
		$do->execute();


		// <-- CREATION DE LA DATABASE POUR LIKEs -->
		$req = 'CREATE TABLE IF NOT EXISTS like_photos(
							id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
							iduser VARCHAR(33) DEFAULT NULL,
							idpost INT DEFAUlT NULL
		);';
		$do = $connect->prepare($req);
		$do->execute();

		// <-- CREATE TMP_SAVE -->
		if (!file_exists("./other/tmp_saved")){
			mkdir("./photos/tmp_saved");
		}

		// <--CREATION DE LA DATABASE POUR LES FILTRES-->//
		$req = 'CREATE TABLE IF NOT EXISTS filters_table(
							id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
							path_img VARCHAR(254) DEFAULT null
		);';
		$do = $connect->prepare($req);
		$do->execute();
		$req = 'SELECT * FROM filters_table';
		$do = $connect->prepare($req);
		$do->execute();
		$res = $do->fetch(PDO::FETCH_ASSOC);
		if (!$res){
			$req2 = "INSERT INTO filters_table(path_img)
					VALUES ('./other/filters/frame_filter.png'),
						('./other/filters/frame_filter2.png'),
						('./other/filters/Gunter.png'),
						('./other/filters/hellokitty.png'),
						('./other/filters/herbi.png'),
						('./other/filters/tortank.png'),
						('./other/filters/sala.png'),
						('./other/filters/starkhouse.png'),
						('./other/filters/randm.png');";
			$do = $connect->prepare($req2);
			$do->execute();
		}
	}
?>
