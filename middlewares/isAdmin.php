<?php

include_once dirname(__FILE__, 2) . '/classes/Session.php';

if (Session::getSession('userType') != "admin") {
	header("Location:/bookmart");
	exit();
}

?>