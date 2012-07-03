<?php
//{{{viewNewStep
function viewNewStep($id, $solved) {
	if (ROOT_CALL && USER_ADMIN) {
		?>
			<fieldset id="newStep">
				<legend>Add a new step</legend>
		<?php
			viewStepFormular("newStep", $solved, $id);
		?>
			</fieldset>
		<?php
	}
}
//}}}

//{{{viewModificationStep
function viewModificationStep ($type, $problemSolved, $id, $action, $reaction, $useful) {
	if (ROOT_CALL && USER_ADIM) {
		?>
			<fieldset>
				<legend>Modification of a step</legend>
		<?php
			viewStepFormular($type, $problemSolved, $id, $action, $reaction, $useful);
	}
}
//}}}

//{{{viewStepFormular
function viewStepFormular($type, $problemSolved, $id, $action = NULL, $reaction = NULL, $useful = NULL) {
	if (ROOT_CALL && USER_ADMIN) {
		switch ($type) {
			case "newStep" :
				$submitText = "Create new step";
				break;
			case "modificationStep" :
				$submitText = "Update step";
				//The delete checkbox
				$specificField = "<tr>\n\t<td>\n\t\t<label for=\"deleteStep\">Delete the step?</label>\n\t</td>\n\t<td>\n\t\t<input type=\"checkbox\" name=\"deleteStep\" id=\"deleteStep\" />\n\t</td>\n</tr>\n";
				break;
		}

		?>
				<form method="post" action="index.php">
					<table>
						<tr>
							<td><label for="action">Action performed:</label></td>
							<td><textarea name="action" id="action"><?php echo $action; ?></textarea></td>
						<tr>
						</tr>
							<td><label for="reaction">Reaction produced:</label></td>
							<td><textarea name="reaction" id="reaction"><?php echo $reaction; ?></textarea></td>
						</tr>
						<tr>
							<td><label for="stepUseful">Was the step useful?</label></td>
							<td><input type="checkbox" name="stepUseful" id="stepUseful" <?php if($useful) echo "checked=\"checked\""; ?> /></td>
						</tr>
						<tr>
							<td><label for="problemSolved">Is problem solved?</label></td>
							<td><input type="checkbox" name="problemSolved" id="problemSolved" <?php if ($problemSolved) echo "checked=\"checked\""; ?> /></td>
						</tr>
						<?php echo $specificField; ?>
						<tr>
							<td colspan="2"><input type="submit" value="<?php echo $submitText; ?>" /></td>
						</tr>
					</table>
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
					<input type="hidden" name="type" value="<?php echo $type ?>" />
				</form>
		<?php
	}
}
//}}}

//{{{viewAddStepButton
function viewAddStepButton($id) {
	//If user is admin, he can add a new step to the problem.
	if (USER_ADMIN)
		echo "<div class=\"newStep\"><a href=\"index.php?type=newStep&amp;id=" .$id. "#newStep\">Add a new step</a></div>\n";
}
//}}}

//{{{viewStep
function viewStep ($action, $reaction, $useful, $number, $id) {
	$cool = ($useful == 1) ? "useful" : "useless";

	//{{{First, we display the header.
	if ($cool == "useful") { 
		?>
		<div class="headerUsefulStep">
			<table id="mainTable"><tr>
				<td id="left">
					#<?php echo $number; ?>
				</td>
				<td id="right">
					<table style="display:inline;"><tr>
						<td>
							<img alt="tick" src="imgs/tick_small.png" />
						</td><td style="vertical-align: middle;">
							This step was useful.
						</td>
					</tr></table>
				</td>
			</tr></table>
		</div>
		<?php
	}
	else {
		?>
		<div class="headerUselessStep">
			<table id="mainTable"><tr>
				<td id="left">
					#<?php echo $number; ?>
				</td>
				<td id="right">
					<table style="display:inline;"><tr>
						<td>
							<img alt="cross" src="imgs/cross_small.png" />
						</td><td style="vertical-align: middle;">
							This step was useless.
						</td>
					</tr></table>
				</td>
			</tr></table>
		</div>
		<?php
	}
	//}}}	 

	//{{{After, we display the "real" content. 
	?>
		<p>
			<?php echo decodeVar($action); ?>
		</p>
		<div class="<?php echo $cool;?>Step">
			Reaction produced
		</div>
		<p>
			<?php echo decodeVar($reaction); ?>
		</p>
	<?php
	if (USER_ADMIN) {
	?>
		<div class="modificationStep">
			<a href="index.php?type=modificationStep&amp;id=<?php echo $id; ?>">Modification</a>
		</div>
	<?php
	}
	//}}}
}
//}}}
