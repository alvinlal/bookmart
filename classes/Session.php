<?php

class Session {

	public static function setSession(string $key, $value) {
		if (!isset($_SESSION)) {
			session_start();
		}
		$_SESSION[$key] = $value;
	}
	public static function getSession(string $key) {
		if (!isset($_SESSION)) {
			session_start();
		}
		return $_SESSION[$key] ?? false;
	}
	public static function removeSession() {
		session_start();
		session_regenerate_id(true);
		session_unset();
		session_destroy();
	}
}