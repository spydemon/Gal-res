<?php
include_once('views.php');

//{{{Menu non-admin view
function viewMenuNonAdmin() {
	//We only print something if the call comes form the index.php file
	if (ROOT_CALL) {
		?>
			<tr>
				<td id='nav'>
		<?php
		//We wrote the authentication formular only if config already exist.
		if (CONFIG_EXIST) {
		?>
					<form method="post" action="index.php">
						<input type="text" name="pseudo" />
						<input type="password" name="psw" />
						<input type="hidden" name="type" value="auth" />
						<input type="submit" value="Admin acces" style="display:none;" />
					</form>
		<?php
		}
	}
}
//}}}

//{{{Menu admin view
function viewMenuAdmin() {
	if (ROOT_CALL && USER_ADMIN) {
		?>
			<tr>
				<td id='nav'>
					<h1><a href="index.php?type=adminCategories">Gestion categories</a></h1>
					<h1><a href="index.php?type=adminProblems">Gestion problems</a></h1>
					<form method="post" action="index.php">
						<input type="hidden" name="type" value="logout" />
						<input type="submit" value="Logout" />
					</form>
		<?php
	}
}
//}}}
