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
			//echo "INSERT INTO galeres_problems (title, symptoms, position, solved, id_category) VALUES ('"
				.secureVar($_POST['name']). "', '"
				.secureVar($_POST['symptoms']). "', '"
				.secureVar($_POST['position']). "', '"
				.$solved. "' , '"
				.secureVar($_POST['category']). "')");
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
	return $db->query("SELECT * FROM galeres_problems ORDER BY position, date DESC")->fetchAll();
}
//}}}

//{{{modifProblem
function modifProblem($id, PDO $db) {
	if (USER_ADMIN) {
		//If we want to display the modification formular.
		if (is_numeric($id) && empty($_POST)) {
			$data = $db->query("SELECT * FROM galeres_problems WHERE id = '" .secureVar($id). "'")->fetch();
			viewDisplayModificationProblem($data['id'], $data['title'], $data['symptoms'], $data['position'], $data['solved']);
		}
		//If user want to send the formular and apply modifications to the problem.
		elseif (!empty($_POST)) {
			if (empty($_POST['title']) || !is_numeric($_POST['position']) || empty($_POST['symptoms'])) {
				echo "You have to write valid datas in fields. <br />";
			}
			else {
				$db->query("UPDATE galeres_problems SET 
						title='" .secureVar($_POST['title']). "', 
						position='" .secureVar($_POST['position']). "', 
						symptoms='" .secureVar($_POST['symptoms']). "',
						solved='" .(($_POST['solved'] == "on") ? 1 : 0). "'
						WHERE id=" .secureVar($_POST['id']));
				//Now we display the problem that we modify.
			}
		}
	}
}
//}}}

//{{{displayProblem
function displayProblem($id, PDO $db) {
	if (is_numeric($id)) {
		$pbInfo = $db->query("SELECT * FROM galeres_problems WHERE id=" .secureVar($id))->fetch();
		//We check if the user hasn't put a crazy value in $id.
		if (!empty($pbInfo)) {
			$catInfo = $db->query("SELECT name FROM galeres_categories WHERE id=" .$pbInfo['id_category'])->fetch();
			$stepsInfo = $db->query("SELECT * FROM galeres_steps WHERE id_problem=" .secureVar($id). " ORDER BY date")->fetchAll();
			
			//We display the name and symptoms of the problem
			viewProblem($pbInfo['title'], $pbInfo['symptoms'], $pbInfo['solved'], $pbInfo['date'], $catInfo['name'], $stepsInfo, $pbInfo['id']);

			//We display all steps done for solving the problems.
			$steps = $db->query("SELECT * FROM galeres_steps WHERE id_problem=" .secureVar($id). " ORDER BY date")->fetchAll();
			$i = 0;
			foreach($steps as $step) {
				$i += 1;
				//We check if user wants to see all steps or only useful ones.
				if ((isset($_GET['onlyUseful']) && $step['useful']) || (!isset($_GET['onlyUseful'])))
					viewStep($step['action'], $step['reaction'], $step['useful'], $i, $step['id']);
			}
			//The "add step" button
			viewAddStepButton($id);
		}
	}
}
//}}}
