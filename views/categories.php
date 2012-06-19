<?php
include_once('views.php');

//{{{viewCreateCategory
function viewCreateCategory() {
	if (USER_ADMIN) {
		?>
			<fieldset>
				<legend>Creation of a new category.</legend>
				<form method="post" action="index.php">
					<table>
						<tr>
							<td><label for="name">Name :</label></td>
							<td><input type="text" name="name" id="name" /></td>
						</tr>
						<tr>
							<td><label for="position">Position :</label></td>
							<td><input type="text" name="position" id="position" value="0" size="3" /></td>
						</tr>
						<tr>
							<input type="hidden" name="type" value="adminCategories" />
							<input type="hidden" name="action" value="newOne" />
							<td colspan="2"><input type="submit" value="Create !" /></td>
						</tr>
					</table>
				</form>
			</fieldset>
		<?php
	}
}
//}}}
