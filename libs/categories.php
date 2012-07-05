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
				.secureVar($_POST['name']). "', '"
				.secureVar($_POST['position']). "')");
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
			name='" .secureVar($_POST['name']). "',
			position='" .secureVar($_POST['position']). "'
			WHERE id=" .secureVar($_POST['id']). "<br />";
 
	$db->exec("UPDATE galeres_categories SET 
			name='" .secureVar($_POST['name']). "',
			position='" .secureVar($_POST['position']). "'
			WHERE id=" .secureVar($_POST['id']) );
	}
}
//}}}

//{{{delCategory
function delCategory(PDO $db) {
	if (empty($_POST['id'])) {
		echo "You have to choose the category to delete.<br />\n";
	}
	else {
		$db->exec("DELETE FROM galeres_categories WHERE id=" .secureVar($_POST['id']));
	}
}
//}}}

//{{{getCategoriesName
function getCategoriesName(PDO $db) {
	return $db->query("SELECT id, name FROM galeres_categories")->fetchAll();
}
//}}}

//{{{displayCategory
function displayCategory($cat, PDO $db) {
	if (is_numeric($cat)) {
		$name_cat = $db->query("SELECT name FROM galeres_categories WHERE id = '" .secureVar($cat). "'")->fetchAll();
		$display = $db->query("SELECT * FROM galeres_problems WHERE id_category = '" .secureVar($cat). "' ORDER BY position, date DESC")->fetchAll();
		if (empty($display)) 
			displayAllCategories($db);
		else 
			viewCategory($name_cat, $display);
	}
}
//}}}	

//{{{displayAllCategories
function displayAllCategories(PDO $db) {
	$list = $db->query("SELECT id FROM galeres_categories ORDER BY position, name")->fetchAll();
	foreach($list as $element)
		displayCategory($element['id'], $db);
}
//}}}

