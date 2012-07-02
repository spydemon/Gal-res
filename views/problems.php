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
//}}}

//{{{viewDisplayModificationProblem
function viewDisplayModificationProblem($id, $title, $symptoms, $position, $solved) {
	if (USER_ADMIN && ROOT_CALL) {
		?>
			<fieldset>
				<legend>Modification of the problem: <?php echo $title; ?></legend>
				<table>
					<form method="post" action="index.php">
						<tr>
							<td><label for="title">Title:</label></td>
						   <td><input type="text" name="title" id="title" value="<?php echo $title ?>" /></td>
						</tr>
						<tr>
							<td><label for="position">Position:</label></td>
							<td><input type="text" name="position" id="position" value="<?php echo $position ?>" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="bigTextarea">Symptoms:</label></td>
						</tr>
						<tr>
							<td colspan="2"><textarea name="symptoms" id="bigTextarea"><?php echo $symptoms ?> </textarea></td>
						</tr>
						<tr>
							<td><label for="solved">Is the problem solved?</label></td>
							<td><input type="checkbox" name="solved" id="solved" <?php if($solved == 1) echo "checked=\"checked\""; ?> /></td>
						</tr>	
						<input type="hidden" name="id" value="<?php echo $id ?>" />
						<input type="hidden" name="type" value="modifProblem" />
						<tr>
							<td colspan="2"><input type="submit" value="Update problem" /></td>
						</tr>
					</form>
				</table>
			</fieldset>
		<?php
	}
}
//}}} 

//{{{viewProblem
function viewProblem($title, $symptoms, $solved, $date, $category_title, array $steps, $id) {
	if (ROOT_CALL) {
	?>
		<h1><?php echo $title; ?></h1>
		<table id="subtitleProblem"><tr>
			<td id="dateProblem">Last update: <strong><?php echo $date;?></strong></td>
			<td id="catProblem">In category: <strong><?php echo $category_title;?></strong></td>
		</tr></table>
		<p>
			<?php echo decodeVar($symptoms); ?>
		</p>
	<?php
	if ($solved) 
		echo "<table id=\"solved\"><tr><td><img alt=\"tick\" src=\"imgs/tick_big.png\" /></td><td style=\"vertical-align:middle;\">This problem was solved.</td></tr></table>\n";
	else
		echo "<table id=\"unsolved\"><tr><td><img alt=\"cross\" src=\"imgs/cross_big.png\" /></td><td style=\"vertical-align:middle;\">This problem isn't solved for the moment.</td></tr></table>\n";
	}	
}
//}}}
