<?php


$db = new mysqli('localhost', 'root', '', 'daisy');


if (isset($_POST["ticket"])) {
	$user = $db->query("SELECT * FROM USERS WHERE TICKET = '" . $_POST["ticket"] . "';");

	if ($user->num_rows <= 0) {
		exit;
	}

	$a = $user->fetch_assoc();
	if ($a['ROLEFLAGS'] == "393230") {
		$q = $db->query("UPDATE USERS SET ISBANNED = 1 WHERE ID = " . $_POST["id"] . ";");
	}
}
