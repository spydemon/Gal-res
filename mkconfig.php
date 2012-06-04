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
//}}}

//{{{If all field of the formular aren't complete. We print the formular
if ($form_register != 0x3f) {
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
	echo "\t\t<tr><td><label for='address_bdd'>Address database:</label>\t\t\t	</td><td>\t<input type='text' name='address_bdd' id='address_bdd' ";
		if ($form_register && 1<<3) echo "value='" .htmlentities($_POST['address_bdd'], ENT_QUOTES). "'";
		echo "/>\t</td></tr>\n";
	echo "\t\t<tr><td><label for='username_bdd'>Username database:</label>\t\t\t</td><td>\t<input type='text' name='username_bdd' id='username_bdd' ";
		if ($form_register && 1<<5) echo "value='" .htmlentities($_POST['form_register'], ENT_QUOTES). "'";
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
		//In a first time, we check if we can access to the database.
	}

}
//}}}
