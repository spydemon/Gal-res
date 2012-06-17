<?php
//The controler part
include ('functions.php');
//The view part
include ('views.php');

//Define use to know if functions are call in the index.php file or not.
define(ROOT_CALL, true);

//We remove magic quotes
//I need this script because I don't have access to the php.ini and pass by the .htaccess file causes a 500 error.
removeMagicQuotes();

//We check if config.php exist, or if it the first time that the application is running.
define(CONFIG_EXIST, check_config());

if (CONFIG_EXIST) {
	include ('config.php');
	$db = new PDO('mysql:host=' .BDD_HOSTNAME. ';dbname=' .BDD_BDDNAME, BDD_USERNAME, BDD_PASSWORD);

	//We fetch all datas in the admin database.
	$adminInfos = fetchAdmin($db);
}
else {
	//If database doesn't exist, we "hardcreate" the title and footer of the page.
	$adminInfos['title'] = 'Galère v1.0';
	$adminInfos['fooder'] = 'I hope I\'ll survive…';
}

viewDoctype($adminInfos['title']);
viewHeader($adminInfos['title']);
viewMenuNonAdmin();

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
