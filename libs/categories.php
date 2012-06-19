<?php 
include_once('views/categories.php');

//{{{manageCategories
function manageCategories(PDO $db) {
	if (USER_ADMIN) {
		//If the user only wants to show the content.
		if ($_POST['action'] == "newOne") {
			addCategory($db);
		}

		//We show the formular for adding one category.
		viewCreateCategory();
	}
}
//}}}


//{{{addCategory
function addCategory(PDO $db) {
	if (empty($_POST['name']) || (!is_numeric($_POST['position']))) {
		echo "You have to complete all fields<br />\n";
	}
	else {
		$db->exec("INSERT INTO galeres_categories (name, position) VALUES ('"
				.htmlentities($_POST['name'], ENT_QUOTES). "', '"
				.htmlentities($_POST['position'], ENT_QUOTES). "')");
	}
}
//}}}
