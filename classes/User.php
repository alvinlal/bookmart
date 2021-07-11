<?php

include "../db/connection.php";

class User {
	private $email;
	private $password;
	private $userType;

	function __construct(String $email, String $password) {
		$this->email = $email;
		$this->password = $password;
	}

	public function validateLoginInput() {
		$errors = [
			'email' => '',
			'password' => '',
			'invalidCredentials' => '',
		];

		if (empty(trim($this->email))) {
			$errors['email'] = 'Please enter an email';
		} else {
			$emailExists = selectOne('SELECT Username,User_type FROM tbl_Login WHERE Username=:email;', ['email' => $this->email]);
			if (!$emailExists) {
				$errors['invalidCredentials'] = 'Incorrect credentials';
			} else {
				$this->userType = $emailExists['User_type'];
			}

			if (empty($this->password)) {
				$errors['password'] = 'Please enter a password';
			} else if (!$errors['invalidCredentials'] && !$errors['email']) {
				$row = selectOne('SELECT Password FROM tbl_Login WHERE Username=:email;', ['email' => $this->email]);
				if (!password_verify($this->password, $row['Password'])) {
					$errors['invalidCredentials'] = 'Incorrect credentials';
				}
			}

		}
		return $errors;
	}

	public function getUserType() {
		return $this->userType;
	}

}