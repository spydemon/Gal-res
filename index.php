<?php
session_start();

//The controler part
include_once('functions.php');
include_once('libs/auth.php');
include_once('libs/categories.php');
include_once('libs/problems.php');

//The view part
include_once ('views.php');

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

	//We check if the user is logged in.
	define(USER_ADMIN, checkAdmin($adminInfos));
}
else {
	//If database doesn't exist, we "hardcreate" the title and footer of the page.
	$adminInfos['title'] = 'Galèâre v1.0';
	$adminInfos['fooder'] = 'I hope I\'ll survive…';
}

viewDoctype($adminInfos['title']);
viewHeader($adminInfos['title']);

//We print the login formular, or the admin pannel.
if (USER_ADMIN) {
	viewMenuAdmin();
}
else {
	viewMenuNonAdmin();
}
//And after categories list.
$categoriesList = $db->query("SELECT * FROM galeres_categories ORDER BY position, name")->fetchAll();
$problemList = getProblems($db);

viewMenu($categoriesList, $problemList);

// BODY OF THE PAGE //
//If config.php doesn't exit, we create it.
if (!CONFIG_EXIST)
	include('mkconfig.php');
else {
	//We catch the kind of page to display (by POST or GET variable).
	if (!empty($_POST['type'])) $type = $_POST['type'];
	else if (!empty($_GET['type'])) $type = $_GET['type'];

	switch ($type) {
		case "admin" :
			break;
		case "adminCategories" :
			//If the admin want to add or manage categories
			manageCategories($db);
			break;
		case "adminProblems" :
			manageProblems($db);
			break;
		case "auth" :
			//If we send the authentication formular.
			authentication($adminInfos, $db);
			break;
		case "logout" :
			//If we want to logout.
			logout($db);
			break;
		case "viewCat" :
			//If user want to see all problems advaiable in one single category.
			displayCategory($_GET['cat'], $db);
			break;
		case "modifProblem" :
			//If user is the admin and want to modify a category.
			modifProblem($_GET['id'], $db);
			break;
		default :
			//If nothing has to be display, we display the list of all problems.
			displayAllCategories($db);
	}
}

echo "\t\t\t\t</section>\n";
echo "\t\t\t</td>\n\t\t</tr>\n\t\t<tr>\n\t\t\t<td>\n\t\t\t</td>\n";
echo "\t\t\t<td>\n";
echo "\t\t\t\t<footer>\n";
echo "\t\t\t\t\t<em>Super fooder.</em>\n";
echo "\t\t\t\t</footer>\n";
echo "\t\t\t</td>\n\t\t</tr>\n</table>\n";

echo "\t</body>\n";
echo "</html>\n";
