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
					echo "\t\t\t\t\t\t\t<li><a href='index.php?action=viewPb&amp;pb=" .$problem['id']. "' id='" .$type[$problem['solved'] == 1]. "'>" .$problem['title']. "</a></li>";	
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
