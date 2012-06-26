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

//{{{viewModifCategories
function viewModifCategories(array $categoriesList) {
	?>
		<fieldset>
			<legend>Modification of a existing category</legend>
			<table>
				<tr>
					<th>Name</th>
					<th>Position</th>
				</tr>
	<?php
		foreach($categoriesList as $category) {
	?>
				<tr>
					<form method="post" action="index.php">
						<td><input type="text" name="name" value="<?php echo $category['name'] ?>" /></td>
					   <td><input type="text" name="position" value="<?php echo $category['position'] ?>" size="3" /></td>
						<input type="hidden"	name="type" value="adminCategories" />
					   <input type="hidden" name="action" value="modifOne" />
						<input type="hidden" name="id" value="<?php echo $category['id'] ?>" />
						<td><input type="submit" value="Modification" /></td>
					</form>
					<form method="post" action="index.php">
						<input type="hidden" name="type" value="adminCategories" />
						<input type="hidden" name="action" value="delOne" />
						<input type="hidden" name="id" value="<?php echo $category['id'] ?>" />
						<td><input type="submit" value="Delete" /></td>
					</form>
				</tr>
	<?php
		}
	?>
			</table>
		</fieldset>
	<?php
}
//}}}
