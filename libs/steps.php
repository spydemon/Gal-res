<?php
include_once('libs/categories.php');
include_once('views/steps.php');

//{{{createNewStep
function createNewStep($id, PDO $db) {
	if (USER_ADMIN) {
		displayProblem($id, $db);
		//If $ POST is empty, we display the formular for the user.
		if (empty($_POST['id'])) {
			viewNewStep($id);
		}
		//If $_POST is with something, we process the formular. 
		else {
			echo "Dans fonction <br />";
			//In the first time, we check if the id of the problem exist.
			if($db->exec("SELECT * FROM galeres_problems WHERE id=" .secureVar($id))) {
				echo "Traitement requette sql. <br />";
				$stepUseful = ($POST['stepUseful'] == "on") ? 1 : NULL;
				$db->query("INSERT INTO galeres_steps (action, reaction, useful, id_problem) VALUES (
					'" .secureVar($_POST['action']). "', 
					'" .secureVar($_POST['reaction']). "', 
					'" .secureVar($id). "', 
					'" .$stepUseful. "')");
			}
		}
	}
}
//}}}
