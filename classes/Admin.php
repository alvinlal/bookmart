<?php

include "../db/connection.php";

class Admin {

	private $name;
	private $password;
	private $confirmpassword;

	public function __construct($name, $password = '', $confirmpassword = '') {
		$this->name = $name;
		$this->password = $password;
		$this->confirmpassword = $confirmpassword;
	}

	public function validateInput() {
		$errors = [
			'name' => '',
			'confirmpassword' => '',
		];

		if (!preg_match('/^[a-zA-Z ]{1,60}$/', trim($this->name))) {
			$errors['name'] = "Invalid name";
		}
		if (strlen($this->password) > 0) {

			if ($this->password != $this->confirmpassword) {
				$errors['confirmpassword'] = "Passwords don't match";
			}
		}

		return $errors;
	}

	public function update() {
		if (strlen($this->password) > 0) {
			global $pdo;
			$pdo->beginTransaction();
			try {
				query('UPDATE tbl_Login SET Password=? WHERE Username=?', [password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 10]), $_SESSION['username']]);

				query('UPDATE tbl_Admin SET Name=? WHERE Username=?', [trim($this->name), $_SESSION['username']]);
				$pdo->commit();
			} catch (PDOException $e) {
				$pdo->rollBack();
				throw $e;
			}
		} else {
			query('UPDATE tbl_Admin SET Name=? WHERE Username=?', [trim($this->name), $_SESSION['username']]);
		}
	}
}

?>