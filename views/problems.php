<?php
include_once('views.php');

//{{{viewCreateProblem
function viewCreateProblem(PDO $db, array $categoriesList) {
	if (USER_ADMIN) {
		?>
		<fieldset>
			<legend>Create a new problem</legend>
			<form method="post" action="index.php?type=adminProblems&amp;action=newOne">
				<table>
					<tr>
						<td><label for="name">Name :</label></td>
						<td><input type="text" name="name" id="name" /></td>
					</tr>
					<tr>
						<td><label for="position">Position :</label></td>
						<td><input type="text" name="position" id="position" size="3" value="0" /></td>
					</tr>
					<tr>
						<td><label for="category">Category :</label></td>
						<td>
		<?php
			viewCategoriesOption($categoriesList);
		?>
						</td>
					</tr>
					<tr><td colspan="2">Symptoms</td></tr>
					<tr><td colspan="3"><textarea name="symptoms" id="bigTextarea"></textarea></td></tr>
					<tr>
						<td><label for="solved">Problem solved?</label></td>
						<td><input type="checkbox" name="solved" id="solved" /></td>
					</tr>
					<tr><td colspan="2"><input type="submit" value="Create the problem" /></td></tr>
				</table>
			</form>
		</fieldset>
		<?php
	}
}
//}}}

//{{{viewCategoriesOption
function viewCategoriesOption(array $list) {
	echo "<select name='category' id='category'>\n";
	foreach($list as $category) {
		echo "\t<option value='" .$category['id']. "'>". $category['name']. "</option>\n";
	}
	echo "</select>\n";
}	
