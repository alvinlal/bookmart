<?php

include "../classes/Session.php";
Session::removeSession();
header("location:/");

?>