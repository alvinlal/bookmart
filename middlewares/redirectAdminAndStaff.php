<?php

include_once getenv('ROOT_DIR') . '/classes/Session.php';

if (Session::getSession('username')) {
	if (Session::getSession('userType') == "admin" || Session::getSession('userType') == "staff") {
		header("Location:/orders");
		exit();
	}
}

?>