<?php
//{{{Doctype
function viewDoctype($title) {
	//We only print something if the call comes from the index.php file
	if(ROOT_CALL) { 
		?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title> <?php echo $title ?> </title>
		<link rel='stylesheet' href='style.css' />
	</head>
		<?php
	}
}
//}}}

//{{{Header
function viewHeader($title) { 
	//We only print something if the call comes from the index.php file
	if (ROOT_CALL) {
		?>
	<body>
		<table id='body'>
			<tr>
				<td colspan='2'>
					<header>
						<?php echo $title ?>
					</header>
				</td>
			</tr>
		<?php
	}
}
//}}}

//{{{viewMenu
function viewMenu(array $categories, array $problems) {
	if (ROOT_CALL) {
		//This variable is used to determine if the problem has to be with the "solved" color or "unsolved" one.
		$type = array("unsolved", "solved");

		echo "\t\t\t\t<nav>\n";
		foreach($categories as $category) {
			echo "\t\t\t\t\t<h1><a href='index.php?type=viewCat&amp;cat=" .$category['id']. "'>" .$category['name']. "</a></h1>\n";	
			echo "\t\t\t\t\t\t<ul>\n";
			foreach($problems as $problem) {
				if ($problem['id_category'] == $category['id'])
					echo "\t\t\t\t\t\t\t<li><a href='index.php?type=viewPb&amp;pb=" .$problem['id']. "' id='" .$type[$problem['solved'] == 1]. "'>" .$problem['title']. "</a></li>";	
			}
			echo "\t\t\t\t\t\t</ul>\n";
		}
		echo "\t\t\t\t</nav>\n";
		echo "\t\t\t\t</td>\n";
		echo "\t\t\t\t<td>\n";
		echo "\t\t\t\t<section>\n";
	}
}
//}}}

//{{{viewAdministrationFormular
function viewAdministrationFormular ($pseudo, $title, $footer, $piwik) {
	if (USER_ADMIN) {
		?>
			<fieldset>
				<legend>Administration</legend>
				<form method="post" action="index.php?type=admin">
					<table>
						<tr>
							<td><label for="pseudo">Pseudo:</label></td>
							<td><input type="text" name="pseudo" id="pseudo" value="<?php echo $pseudo; ?>" /></td>
						</tr>
						<tr>
							<td><label for="psw1">New password:</label></td>
							<td><input type="password" name="psw1" id="psw1" /></td>
						</tr>
						<tr>
							<td><label for="psw2">Again:</label></td>
							<td><input type="password" name="psw2" id="psw2" /></td>
						</tr>
						<tr>
							<td colspan="2"><em>Keep this fields empty if you don't want to change the password.</em></td>
						</tr>
						<tr>
							<td><label for="title">Title:</label></td>
							<td><input type="text" name="title" id="title" value="<?php echo $title; ?>" /></td>
						</tr>
						<tr>
							<td><label for="fooder">Footer:</label></td>
							<td><input type="text" name="fooder" id="fooder" value="<?php echo $footer; ?>" /></td>
						</tr>
						<tr>
							<td><label for="piwik">Piwik:</label></td>
							<td><textarea id="piwik" name="piwik"><?php echo $piwik; ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2"><em>Note: I make ads for Piwiki because it's a free software, but you can use whatever you want for analytic system like Google Analytic.</em></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="Update" /></td>
						</tr>
					</table>
				</form>
			</fieldset>
		<?php
	}
}
//}}}
