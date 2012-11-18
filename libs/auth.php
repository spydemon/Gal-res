<?php 
include_once('views/auth.php');

//{{{authentication
//Check if identity enter in the formular are ok.
function authentication(array $adminInfos, PDO $db) {
	if (CONFIG_EXIST) {
		if (	($_POST['pseudo'] == $adminInfos['pseudo']) &&
				(sha1($_POST['psw']) == $adminInfos['psw']) ) {
			//Log of the connexion
			logCon(TRUE);
			//If the user is logged now, we update the "connection string in the database".
			$string = updateIdString($db);
			//But also the last connection time and the user ip address.
			updateLastConnectionTimeAndIp($db);
			//We activate the session.
			$_SESSION[galeres] = $string;
		}
		else {
			//We log that the user failed the authentication
			logCon(FALSE);
		}
	}
}
//}}}

//{{{updateIdString
//Update the idstring value in the database for a new user connection.
function updateIdString(PDO $db) {
	$newId = sha1(mt_rand());
	$db->exec("UPDATE galeres_admin SET var_value = '" .$newId. "' WHERE var_name='idstring'");
	return $newId;
}
//}}}

//{{{ updateLastConnectionTime
function updateLastConnectionTimeAndIp(PDO $db) {
	$db->exec("UPDATE galeres_admin SET var_value = '" .time(). "' WHERE var_name='connection'");
	$db->exec("UPDATE galeres_admin SET var_value = '" .$_SERVER['SERVER_ADDR']. "' WHERE var_name='ip'");
}
//}}}

//{{{checkAdmin
//We check if the user is logged in
function checkAdmin(array $adminInfos) {
	if (!isset($_SESSION['galeres']))
		return false;
			
			//In a first time, we look if the connection string is adviable on user's browser.
	if (	($_SESSION['galeres'] == $adminInfos['idstring']) &&
			//After we check if the ip address is the same that at the login proccess (to avoid sessions stealing).
			($_SERVER['SERVER_ADDR'] == $adminInfos['ip']) &&
			//And finaly, we stay log in more that 2 hours (for limiting risks if we forgot to logout).
			(time() - $adminInfos['connection'] < 7200) )
		return true;
	else return false;
}
//}}}

//{{{logout
function logout(PDO $db) {
	//We remove only the idstring actually.
	$_SESSION['galere'] = '';
	$db->query("UPDATE galeres_admin SET var_value='' WHERE var_name='idstring'");
}
//}}}

//{{{log
function logCon($ok) {
	if ($ok) {
		$string = "Accepted password for " .htmlentities($_POST['pseudo']). " from {$_SERVER['REMOTE_ADDR']}";
		$log_level = LOG_INFO;
	}
	else {
		$string = "Authentication failure for " .htmlentities($_POST['pseudo']). " from {$_SERVER['REMOTE_ADDR']}";
		$log_level = LOG_NOTICE;
	}
	openlog('web-galeres('.$_SERVER['HTTP_HOST'].')',LOG_NDELAY|LOG_PID,LOG_AUTH);
	syslog($log_level, $string);
}

