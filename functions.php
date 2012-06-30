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
