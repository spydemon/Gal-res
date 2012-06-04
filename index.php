<?php
//We remove magic quotes
//I need this script because I don't have access to the php.ini and pass by the .htaccess file causes a 500 error.
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

//Verification if config.php exists. If the file doesn't exist, we have to create it and to create the database also
if (!file_exists('config.php')) {
	$title_page = 'Galère v1.0';
	$config_exist = false;
}
else
	$config_exist = true;

echo "<DOCTYPE html>\n";
echo "<html>\n";
echo "\t<head>\n";
echo "\t\t<title>" .$title_page. "</title>\n";
echo "\t\t<meta charset='UTF-8' />\n";
echo "\t</head>\n";
echo "\t<body>\n";
// BODY OF THE PAGE //
//If config.php doesn't exit, we create it.
if (!$config_exist)
	include('mkconfig.php');
echo "\t</body>\n";
echo "</html>\n";
