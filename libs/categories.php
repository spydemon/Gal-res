<?php 
include_once('views/categories.php');

//{{{manageCategories
function manageCategories(PDO $db) {
	if (USER_ADMIN) {
		//If the user only wants to show the content.
		if ($_POST['action'] == "newOne") {
			addCategory($db);
		}
		elseif ($_POST['action'] == "modifOne") {
			modifCategory($db);
		}
		elseif ($_POST['action'] == "delOne") {
			delCategory($db);
		}

		//We show the formular for adding one category.
		viewCreateCategory();

		//We show all existantes category
		$categories = $db->query("SELECT * FROM galeres_categories")->fetchAll();
		viewModifCategories($categories);
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

//{{{modifCategory
function modifCategory(PDO $db) {
	if (empty($_POST['name']) || !is_numeric($_POST['id']) || !is_numeric($_POST['position'])) {
		echo "You have to complete all fields with valids values<br />\n";
	}
	else {
	echo "UPDATE galeres_categories SET 
			name='" .htmlentities($_POST['name'], ENT_QUOTES). "',
			position='" .htmlentities($_POST['position'], ENT_QUOTES). "'
			WHERE id=" .htmlentities($_POST['id'], ENT_QUOTES). "<br />";
 
	$db->exec("UPDATE galeres_categories SET 
			name='" .htmlentities($_POST['name'], ENT_QUOTES). "',
			position='" .htmlentities($_POST['position'], ENT_QUOTES). "'
			WHERE id=" .htmlentities($_POST['id'], ENT_QUOTES) );
	}
}
//}}}

//{{{delCategory
function delCategory(PDO $db) {
	if (empty($_POST['id'])) {
		echo "You have to choose the category to delete.<br />\n";
	}
	else {
		$db->exec("DELETE FROM galeres_categories WHERE id=" .htmlentities($_POST['id'], ENT_QUOTES));
	}
}
//}}}

//{{{getCategoriesName
function getCategoriesName(PDO $db) {
	return $db->query("SELECT id, name FROM galeres_categories")->fetchAll();
}
