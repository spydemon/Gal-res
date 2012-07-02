<?php
//{{{viewNewStep
function viewNewStep($id, $solved) {
	if (ROOT_CALL) {
		?>
			<fieldset id="newStep">
			<legend>Add a new step</legend>
			<form method="post" action="index.php#newStep">
				<table>
					<tr>
						<td><label for="action">Action performed:</label></td>
						<td><textarea name="action" id="action"></textarea></td>
					<tr>
					</tr>
						<td><label for="reaction">Reaction produced:</label></td>
						<td><textarea name="reaction" id="reaction"></textarea></td>
					</tr>
					<tr>
						<td><label for="stepUseful">Was the step useful?</label></td>
					  	<td><input type="checkbox" name="stepUseful" id="stepUseful" /></td>
					</tr>
					<tr>
						<td><label for="problemSolved">Is problem solved?</label></td>
						<td><input type="checkbox" name="problemSolved" id="problemSolved" <?php if ($solved) echo "checked=\"checked\""; ?> /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Create new step" /></td>
					</tr>
				</table>
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="type" value="newStep" />
			</form>
			</fieldset>
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

//{{{viewStep
function viewStep ($action, $reaction, $useful, $number) {
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
			<?php echo $action; ?>
		</p>
		<div class="<?php echo $cool;?>Step">
			Reaction produced
		</div>
		<p>
			<?php echo $reaction; ?>
		</p>
	<?php
	//}}}
}
//}}}
