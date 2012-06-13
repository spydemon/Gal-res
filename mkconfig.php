<?php
//We check if the config file don't still exit
if (file_exists('config.php'))
	exit(1);
 
//{{{We look if the user has still send the formular. In the $form_regiter, each byte represent one field.
$form_register = 0;
$form_register |= !empty($_POST['pseudo'])			<< 0;
$form_register |= !empty($_POST['psw1'])				<< 1;
$form_register |= !empty($_POST['psw2'])				<< 2;
$form_register |= !empty($_POST['address_bdd']) 	<< 3;
$form_register |= !empty($_POST['psw_bdd'])			<< 4;
$form_register |= !empty($_POST['username_bdd'])	<< 5;
$form_register |= !empty($_POST['address_bdd'])		<< 6;
//}}}

//{{{If all field of the formular aren't complete. We print the formular
if ($form_register != 0x7f) {
	echo "Hayoï! It seems that you haven't configure your installation for the moment. <br />\nWe'll make that now, together :-)<br /><br />\n";
	//If $form_register isn't egal to zero, it suposed that the formular was already send, but not with all the information.
	if ($form_register != 0)
		echo "<br /><br />Bro… You have to complete all fields.<br /><br />\n";
	echo "<form action='index.php' method='post'>\n";
	echo "\t<table>\n";
	echo "\t\t<tr><td><label for='pseudo'>Pseudonyme :</label>\t					</td><td>\t<input type='text' name='pseudo' id='pseudo' ";
		if ($form_register && 1<<0) echo "value='" .htmlentities($_POST['pseudo'], ENT_QUOTES). "'";
		echo "/>\t</td></tr>\n";
	echo "\t\t<tr><td><label for='psw1'>Password:</label>\t							</td><td>\t<input type='password' name='psw1' id='psw1' ";
		if ($form_register && 1<<1) echo "value='" .htmlentities($_POST['psw1'], ENT_QUOTES). "'";
		echo "/>\t</td></tr>\n";
	echo "\t\t<tr><td><label for='psw2'>Password (again):</label>\t\t\t			</td><td>\t<input type='password' name='psw2' id='psw2' ";
		if ($form_register && 1<<2) echo "value='" .htmlentities($_POST['psw2'], ENT_QUOTES). "'";
		echo "/>\t</td></tr>\n";
	echo "\t\t<tr><td><label for='name_bdd'>Name database:</label>\t\t\t			</td><td>\t<input type='text' name='name_bdd' id='name_bdd' ";
		if ($form_register && 1<<6) echo "value='" .htmlentities($_POST['name_bdd'], ENT_QUOTES). "'";
		echo "/>\t</td></tr>\n";
	echo "\t\t<tr><td><label for='address_bdd'>Address database:</label>\t\t\t	</td><td>\t<input type='text' name='address_bdd' id='address_bdd' ";
		if ($form_register && 1<<3) echo "value='" .htmlentities($_POST['address_bdd'], ENT_QUOTES). "'";
		echo "/>\t</td></tr>\n";
	echo "\t\t<tr><td><label for='username_bdd'>Username database:</label>\t\t\t</td><td>\t<input type='text' name='username_bdd' id='username_bdd' ";
		if ($form_register && 1<<5) echo "value='" .htmlentities($_POST['username_bdd'], ENT_QUOTES). "'";
		echo "/>\t</td></tr>\n";
	echo "\t\t<tr><td><label for='psw_bdd'>Password database:</label>\t\t\t\t	</td><td>\t<input type='text' name='psw_bdd' id='psw_bdd' ";
		if ($form_register && 1<<4) echo "value='" .htmlentities($_POST['psw_bdd'], ENT_QUOTES). "'";
		echo "/>\t</td></tr>\n";
	echo "\t\t<tr><td colspan='2'><input type='submit' value='Gooooo!' /></tr>\n";
	echo "\t</table>\n";
	echo "</form>\n";
}
//}}} 

//{{{If the formular are complete, we can start the configuration stuff
else {
	//We check the password
	if ($_POST['psw1'] != $_POST['psw2']) {
		echo "Oooops… You made a mistake with your password: it's not the same in the two fields. <br />\n";
		echo "I advise you to click on the “precedent” button to see again the formular and to rewrite it. <br />\n";
	}

	else {
		//In a first time we secure all POST datas.
		foreach ($_POST as $key => $value)
			$_SPOST[$key] = htmlentities($value, ENT_QUOTES);

		//After, we'll check if we can access to the database.
		try {
			$datas = new PDO('mysql:host=' .$_SPOST['address_bdd']. ';dbname=' .$_SPOST['name_bdd'], $_SPOST['username_bdd'], $_SPOST['psw_bdd']); 
			echo "Connection to the database seems fine. <br />\n";

			//{{{And create all things that we need in the db.
			$create_admin_base = "CREATE TABLE galeres_admin (					var_name		MEDIUMTEXT		NOT NULL,
																								var_value	MEDIUMTEXT		NOT NULL														) ENGINE = INNODB; ";

			$create_categories_base = "CREATE TABLE galeres_categories (	id				INT 				NOT NULL	PRIMARY KEY AUTO_INCREMENT,
																								name			MEDIUMTEXT		NOT NULL,
																								position		INT																				) ENGINE = INNODB ;";

			$create_problems_base = "CREATE TABLE galeres_problems (			id 			INT				NOT NULL	PRIMARY KEY	AUTO_INCREMENT,
																								title			MEDIUMTEXT		NOT NULL, 
																								symptoms		MEDIUMTEXT		NOT NULL,
																								date			TIMESTAMP(8), 
																								position 	INT,
																								solved		BIT,
																								id_category	INT				NOT NULL,
																								FOREIGN KEY (id_category) REFERENCES galeres_categories(id)						) ENGINE = INNODB ;";

			$create_steps_base = "CREATE TABLE galeres_steps (					action		MEDIUMTEXT		NOT NULL,
																								reaction		MEDIUMTEXT		NOT NULL,
																								date			TIMESTAMP(8),
																								useful		BIT,
																								id_problem	INT				NOT NULL,
																								FOREIGN KEY (id_problem) REFERENCES galeres_problems(id)							) ENGINE = INNODB ;";

			$datas->exec($create_admin_base);
			$datas->exec($create_categories_base);
			$datas->exec($create_problems_base);
			$datas->exec($create_steps_base);

			//We already add somes entries in galeres_admin
			$entries = array('pseudo', 'psw', 'title', 'fooder', 'idstring', 'ip', 'connection', 'piwik');
			foreach ($entries as $entry)
				$datas->exec('INSERT INTO galeres_admin (var_name) VALUES ("' .$entry. '")');

			//}}} 

			//{{{Now, we create the file with database connections info.
			$config[0] = "<?php\n";
			$config[1] = "const BDD_HOSTNAME = " . $_SPOST['name_bdd'] . "\n";
			$config[2] = "const BDD_USERNAME = " . $_SPOST['username_bdd'] . "\n";
			$config[3] = "const BDD_PASSWORD = " . $_SPOST['psw_bdd'] . "\n";
			$config[4] = "?>\n";

			$file = fopen('config.php', 'w');

			foreach ($config as $line)
				fwrite($file, $line);

			fclose($file);
			chmod('config.php', 004);
			//}}}

			//And finaly, we update data in the database.
			//$insertion = $datas->prepare('INSERT INTO galeres_admin (pseudo, psw) VALUES (:pseudo, :psw)');
			$insertion = $datas->prepare('UPDATE galeres_admin SET var_value=:pseudo WHERE var_name="pseudo"');
			$insertion->execute(array(	'pseudo' => $_SPOST['pseudo']));
			$insertion = $datas->prepare('UPDATE galeres_admin SET var_value=:psw WHERE var_name="psw"');
			$insertion->execute(array( 'psw'		=> sha1($_SPOST['psw1'])));
		}

		catch (Exception $e) {
			echo "Oooops… The connection to the database seems impossible. Check connections parameters. <br />\n";
			echo $e->getMessage();
		}
	}

}
//}}}
