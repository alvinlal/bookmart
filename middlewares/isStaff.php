<?php

include_once dirname(__FILE__, 2) . '/classes/Session.php';

if (Session::getSession('userType') != "staff") {
	header("Location:/bookmart");
	exit();
}

?>