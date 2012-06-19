<?php
//{{{Doctype
function viewDoctype($title) {
	//We only print something if the call comes from the index.php file
	if(ROOT_CALL) { 
		?>
<DOCTYPE html>
<html>
	<head>
		<title> <?php echo $title ?> </title>
		<meta charset='UTF-8' />
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
function viewMenu() {
	if (ROOT_CALL) {
		echo "\t\t\t\t<nav>\n";
		echo "\t\t\t\t\t<h1><a href='#'>Category 1</a></h1>\n";
		echo "\t\t\t\t\t\t<ul><li>On thing</li><li><a href='#'>A other one</a></li><li>And a last.</li></ul>\n";
		echo "\t\t\t\t\t<h1>Category 2</h1>\n";
		echo "\t\t\t\t\t\t<ul><li>Arflala…</li><li>The big problem yeah, a really big actually.</li></ul>\n";
		echo "\t\t\t\t</nav>\n";
		echo "\t\t\t</td>\n\t\t\t<td>\n";
		echo "\t\t\t\t<section>\n";
	}
}
//}}}
