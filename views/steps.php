<?php
//{{{viewNewStep
function viewNewStep($id) {
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
						<td><input type="checkbox" name="problemSolved" id="problemSolved" /></td>
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
