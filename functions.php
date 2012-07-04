<?php

//{{{removeMagicQuotes
function removeMagicQuotes() {
	if (get_magic_quotes_gpc()) {
		 $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
		 while (list($key, $val) = each($process)) {
			  foreach ($val as $k => $v) {
					unset($process[$key][$k]);
					if (is_array($v)) {
						 $process[$key][stripslashes($k)] = $v;
						 $process[] = &$process[$key][stripslashes($k)];
					} else {
						 $process[$key][stripslashes($k)] = stripslashes($v);
					}
			  }
		 }
		 unset($process);
	}
}
//}}}

//{{{fetchAdmin
//This function is used for catching all entries in galere_admin bdd.
function fetchAdmin(PDO $db) {
	$list = array();
	$datas = $db->query("SELECT * FROM galeres_admin");
  	while ($data = $datas->fetch(PDO::FETCH_ASSOC)) {
		$list[$data['var_name']] = $data['var_value'];
	}
	return $list;
}
//}}}

//{{{check_config
function check_config() {
	//Verification if config.php exists. If the file doesn't exist, we have to create it and to create the database also
	if (!file_exists('config.php')) {
		return false;
	}
	else {
		return true;
	}
}
//}}}

//{{{secureVar
function secureVar($var) {
	return htmlentities($var, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
//}}}

//{{{decodeVar
function decodeVar ($var) {
	return html_entity_decode($var, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
//}}}

//{{{administration
function administration (PDO $db) {
	if (USER_ADMIN) {
		//Update values if a formular was already sent.
		if (!empty($_POST)) {
			//Modification of the password.
			if (!empty($_POST['psw1'])) {
				if ($_POST['psw1'] == $_POST['psw2']) 
					$db->query("UPDATE galeres_admin SET var_value='" .sha1($_POST['psw1']). "' WHERE var_name='psw'");
				else 
					echo "<p><b>Warning: the password wasn't change because strings written in both fields are different.</b></p>\n";
			}
			//Modification of others values.
			//First, we check if the pseudo isn't empty
			if (!empty($_POST['pseudo'])) {
				$modifValues = array('pseudo', 'title', 'fooder', 'piwik');
				foreach ($modifValues as $value)
					$db->query("UPDATE galeres_admin SET var_value='" .secureVar($_POST[$value]). "' WHERE var_name='" .$value. "'");
			}
			else {
				echo "<p><b>You can't have a empty pseudo.</b></p>\n";
			}
		}

		//The formular
		$adminData = $db->query("SELECT * FROM galeres_admin")->fetchAll();
		$modifData = array('pseudo', 'title', 'fooder', 'piwik');
		foreach ($adminData as $data) {
			if (in_array($data['var_name'], $modifData))
				$valuesData[$data['var_name']] = $data['var_value'];
		}
		viewAdministrationFormular($valuesData['pseudo'], $valuesData['title'], $valuesData['fooder'], $valuesData['piwik']);
	}
}
//}}}

//{{{displayFooter
function displayFooter (PDO $db) {
	$footer = $db->query("SELECT var_value FROM galeres_admin WHERE var_name='fooder'")->fetch();
	viewFooter($footer['var_value']);

	//We only add the analytic traker if the user is not the admin. So we track only visitors.
	if (!USER_ADMIN) {
		$piwik = $db->query("SELECT var_value FROM galeres_admin WHERE var_name='piwik'")->fetch();
		echo decodeVar($piwik['var_value']);
	}
}
//}}}
