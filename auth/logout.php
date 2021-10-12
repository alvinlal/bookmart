<?php

include "../classes/Session.php";
include "../db/connection.php";

session_start();
$sessionId = session_id();
$pdo->query("DELETE FROM tbl_Session WHERE Session_id='{$sessionId}';");
Session::removeSession();
header("location:/bookmart");

?>