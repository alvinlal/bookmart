<?php

include_once getenv('ROOT_DIR') . '/classes/Session.php';

if (Session::getSession('username')) {
	if (Session::getSession('userType') == "admin") {
		header("Location:/admin");
		exit();
	} else if (Session::getSession('userType') == "staff") {
		header("Location:/staff");
		exit();
	}
}

?>