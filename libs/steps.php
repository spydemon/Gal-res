<?php
include_once('libs/categories.php');
include_once('views/steps.php');

//{{{createNewStep
function createNewStep($id, PDO $db) {
	if (USER_ADMIN) {
		if (is_numeric($id)) {
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
}
//}}}

//{{{modificationStep
function modificationStep($id, PDO $db) {
	if (is_numeric($id)) {
		//If $_POST is empty, we display the formular
		if (empty($_POST['id'])) {
				$defaultValues = $db->query("SELECT * FROM galeres_steps WHERE id=" .secureVar($id))->fetch();
				//We check if the step with this id exist
				if (!empty($defaultValues)) {
					$problemInfo = $db->query("SELECT * FROM galeres_problems WHERE id=" .secureVar($defaultValues['id_problem']));
					viewModificationStep("modificationStep", $probleInfo['solved'], $id, $defaultValues['action'], $defaultValues['reaction'], $defaultValues['useful']);
				}
		}
		
		//Update of the database
		else {
			$problemData = $db->query("SELECT * FROM galeres_problems WHERE id=(SELECT id_problem FROM galeres_steps WHERE id=" .secureVar($id). ")")->fetch();

			//We check if the step id is linked to a problem
			if ($problemData) {
				//Delete of the step
				if ($_POST['deleteStep'] == "on")
					$db->query("DELETE FROM galeres_steps WHERE id=" .secureVar($id));
				//Modification of the step
				else {
					$stepUseful = ($_POST['stepUseful'] == "on") ? 1 : NULL;
					$problemSolved = ($_POST['problemSolved'] == "on") ? 1 : NULL;
					$db->query("UPDATE galeres_steps SET 
							action = '" .secureVar($_POST['action']). "', 
							reaction = '" .secureVar($_POST['reaction']). "', 
							useful = '" .$stepUseful. "'
							WHERE id = " .secureVar($id));
					$db->query("UPDATE galeres_problems SET 
						  solved = '" .$problemSolved. "'
					  		WHERE id = " .secureVar($problemData['id']));
				}		
				displayProblem($problemData['id'], $db);
			}
		}
	}
}
//}}}
