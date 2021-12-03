<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$username = isset($_GET['username']) ? $_GET['username'] : -1;

$details = selectOne('SELECT User_status FROM tbl_Login WHERE Username=?', [$username]);

if ($details) {
	$newStatus = $details['User_status'] == "active" ? "inactive" : "active";
	query("UPDATE tbl_Login SET User_status='{$newStatus}' WHERE Username='{$username}'");
	if ($newStatus != "active") {
		$sessions = select("SELECT Session_id from tbl_Session WHERE Username='{$username}'");
		foreach ($sessions as $session) {
			$file = session_save_path() . "/sess_" . $session['Session_id'];
			unlink($file);
		}
		query("DELETE FROM tbl_Session WHERE Username='{$username}'");
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
} else {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}

?>