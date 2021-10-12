<?php

include_once dirname(__FILE__, 2) . '/classes/Session.php';

if (Session::getSession('username')) {
	if (Session::getSession('userType') == "admin" || Session::getSession('userType') == "staff") {
		header("Location:/bookmart/orders");
		exit();
	}
}

?>