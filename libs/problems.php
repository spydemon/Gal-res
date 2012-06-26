<?php
include_once("views/problems.php");
include_once("libs/categories.php");

//{{{manageProblems
function manageProblems(PDO $db) {
	if (USER_ADMIN) {
		$categoriesList = getCategoriesName($db);
		viewCreateProblem($db, $categoriesList);

		switch($_GET['action']) {
			case "newOne" :
				createNewProblem($db);
				break;
		}
	}
}
//}}}

//{{{createNewProblem
function createNewProblem(PDO $db) {
	if (USER_ADMIN) {
		if(!is_numeric($_POST['position']) || !is_numeric($_POST['category']) || empty($_POST['symptoms']) || empty($_POST['name'])) {
			echo "You have to insert valid values in all fields.<br />\n";
		}
		else {
			$solved = ($_POST['solved'] == "on") ? 1 : 0;
			try {
			$db->query("INSERT INTO galeres_problems (title, symptoms, position, solved, id_category) VALUES ('"
			// echo "INSERT INTO galeres_problems (title, symptoms, position, solved, id_category) VALUES ('"
				.htmlentities($_POST['name'], ENT_QUOTES). "', '"
				.htmlentities($_POST['symptoms'], ENT_QUOTES). "', '"
				.htmlentities($_POST['position'], ENT_QUOTES). "', '"
				.$solved. "' , '"
				.htmlentities($_POST['category'], ENT_QUOTES). "')");
		}
			catch (Exception $e) {
				echo "Exception : <br />";
				$e->getMessage();
			}
		}
	}
}
