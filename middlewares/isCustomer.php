<?php

include_once getenv('ROOT_DIR') . '/classes/Session.php';

if (Session::getSession('userType') != "customer") {
	header("Location:/");
}

?>