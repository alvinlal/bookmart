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
			$emailExists = selectOne('SELECT Username,User_type FROM tbl_Login WHERE Username=:email AND User_status=:status;', ['email' => $this->email, 'status' => "active"]);
			if (!$emailExists) {
				$errors['invalidCredentials'] = 'Incorrect credentials';
			} else {
				$this->userType = $emailExists['User_type'];
			}

			if (empty($this->password)) {
				$errors['password'] = 'Please enter a password';
			} else if (!$errors['invalidCredentials'] && !$errors['email']) {
				$row = selectOne('SELECT Password,User_status FROM tbl_Login WHERE Username=:email;', ['email' => $this->email]);
				if ($row['User_status'] == "deleted") {
					$errors['invalidCredentials'] = 'Incorrect credentials';
				} else if (!password_verify($this->password, $row['Password'])) {
					$errors['invalidCredentials'] = 'Incorrect credentials';
				}

			}

		}
		return $errors;
	}

	public function getUserType() {
		return $this->userType;
	}

	public function addSessionToDb() {
		query('INSERT INTO tbl_Session VALUES(?,?)', [$this->email, session_id()]);
	}

}