<?php
include_once('libs/categories.php');
include_once('views/steps.php');

//{{{createNewStep
function createNewStep($id, PDO $db) {
	if (USER_ADMIN) {
		displayProblem($id, $db);
		//If $ POST is empty, we display the formular for the user.
		if (empty($_POST['id'])) {
			$problemSolved = $db->query("SELECT solved FROM galeres_problems WHERE id=" .secureVar($id))->fetch();
			//We check if the problem exist
			if (!empty($problemSolved))
				viewNewStep($id, $problemSolved['solved']);
		}
		//If $_POST is with something, we process the formular. 
		else {
			//In the first time, we check if the id of the problem exist.
			$exist =  $db->query("SELECT * FROM galeres_problems WHERE id=" .secureVar($id));
			if (!empty($exist)) {
				//We create the step.
				$stepUseful = ($_POST['stepUseful'] == "on") ? 1 : NULL;
				$db->query("INSERT INTO galeres_steps (action, reaction, useful, id_problem) VALUES (
					'" .secureVar($_POST['action']). "', 
					'" .secureVar($_POST['reaction']). "', 
					'" .$stepUseful. "', 
					'" .secureVar($id). "')");
				//We update the state of the problem.
				$problemSolved = ($_POST['problemSolved'] == "on") ? 1 : NULL;
				$db->query("UPDATE galeres_problems SET solved='" .$problemSolved. "' WHERE id=" .secureVar($id));
			}
		}
	}
}
//}}}
