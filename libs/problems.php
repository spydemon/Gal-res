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
			$solved = (isset($_POST['solved'])) ? 1 : NULL;
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
//}}}

//{{{getProblems
function getProblems(PDO $db) {
	return $db->query("SELECT * FROM galeres_problems ORDER BY position, date")->fetchAll();
}
//}}}

//{{{modifProblem
function modifProblem($id, PDO $db) {
	if (USER_ADMIN) {
		//If we want to display the modification formular.
		if (is_numeric($id) && empty($_POST)) {
			$data = $db->query("SELECT * FROM galeres_problems WHERE id = '" .htmlentities($id, ENT_QUOTES). "'")->fetch();
			viewDisplayModificationProblem($data['id'], $data['title'], $data['symptoms'], $data['position'], $data['solved']);
		}
		//If user want to send the formular and apply modifications to the problem.
		elseif (!empty($_POST)) {
			if (empty($_POST['title']) || !is_numeric($_POST['position']) || empty($_POST['symptoms'])) {
				echo "You have to write valid datas in fields. <br />";
			}
			else {
				$db->query("UPDATE galeres_problems SET 
						title='" .htmlentities($_POST['title'], ENT_QUOTES). "', 
						position='" .htmlentities($_POST['position'], ENT_QUOTES). "', 
						symptoms='" .htmlentities($_POST['symptoms'], ENT_QUOTES). "',
						solved='" .(($_POST['solved'] == "on") ? 1 : 0). "'
						WHERE id=" .htmlentities($_POST['id'], ENT_QUOTES));
				//Now we display the problem that we modify.
			}
		}
	}
}
//}}}
