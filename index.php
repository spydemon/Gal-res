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
else {
	include('config.php');
	$config_exist = true;
}

//Autoloader of classes
function chargeClass($name) {
	require 'libs/' .$name. '.class.php';
}
spl_autoload_register(chargeClass);

//$page = new Page();
echo "<DOCTYPE html>\n";
echo "<html>\n";
echo "\t<head>\n";
echo "\t\t<title>" .$title_page. "</title>\n";
echo "\t\t<meta charset='UTF-8' />\n";
echo "\t\t<link rel='stylesheet' href='style.css' />\n";
echo "\t</head>\n";

echo "\t<body>\n";
echo "\t<table id='body'>\n";
echo "\t\t<tr>\n\t\t\t<td colspan='2'>\n";
echo "\t\t\t\t<header>\n";
echo "\t\t\t\t\tThe header of the page.\n";
echo "\t\t\t\t</header>\n";
echo "\t\t\t</td>\n\t\t</tr>\n\t\t<tr>\n\t\t\t<td id='nav'>\n";
echo "\t\t\t\t<nav>\n";
echo "\t\t\t\t\t<h1><a href='#'>Category 1</a></h1>\n";
echo "\t\t\t\t\t\t<ul><li>On thing</li><li><a href='#'>A other one</a></li><li>And a last.</li></ul>\n";
echo "\t\t\t\t\t<h1>Category 2</h1>\n";
echo "\t\t\t\t\t\t<ul><li>Arflala…</li><li>The big problem yeah, a really big actually.</li></ul>\n";
echo "\t\t\t\t</nav>\n";
echo "\t\t\t</td>\n\t\t\t<td>\n";
echo "\t\t\t\t<section>\n";

// BODY OF THE PAGE //
//If config.php doesn't exit, we create it.
if (!$config_exist)
	include('mkconfig.php');

echo "\t\t\t\t</section>\n";
echo "\t\t\t</td>\n\t\t</tr>\n\t\t<tr>\n\t\t\t<td>\n\t\t\t</td>\n";
echo "\t\t\t<td>\n";
echo "\t\t\t\t<footer>\n";
echo "\t\t\t\t\t<em>Super fooder.</em>\n";
echo "\t\t\t\t</footer>\n";
echo "\t\t\t</td>\n\t\t</tr>\n</table>\n";

echo "\t</body>\n";
echo "</html>\n";
