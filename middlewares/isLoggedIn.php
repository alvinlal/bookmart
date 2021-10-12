<?php

include_once dirname(__FILE__, 2) . '/classes/Session.php';

if (Session::getSession('username')) {
	header("Location:/bookmart");
	exit();
}

?>