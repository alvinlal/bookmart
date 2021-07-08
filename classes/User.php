<?php

include "../db/connection.php";

class User {
	private $email;
	private $password;
	private $confirmPassword;

	function __construct(String $email, String $password, String $confirmPassword) {
		$this->email = $email;
		$this->password = $password;
		$this->confirmPassword = $confirmPassword;
	}

	public function validateSignUpInput(): array{
		// errors array
		$errors = [
			'email' => '',
			'password' => [],
			'confirmPassword' => '',
		];
		// check for valid email
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Please enter a valid email';
		}
		// check for valid password
		if (empty($this->password)) {
			array_push($errors['password'], "Password is required");
		} else {
			if (!preg_match('/^[a-zA-Z0-9]+$/', $this->password)) {
				array_push($errors['password'], "Password must contain only letters and numbers");
			}
			if (strlen($this->password) < 6) {
				array_push($errors['password'], "Password must contain atleast six characters");
			}
		}
		// check if password and confirmpassword is same
		if (sizeof($errors['password']) == 0 && $this->password != $this->confirmPassword) {
			$errors['confirmPassword'] = "Passwords don't match";
		}
		// check if account already exists
		if (!$errors['email']) {
			$emailExists = exists('SELECT Username FROM tbl_Login WHERE Username = ?', [$this->email]);
			if ($emailExists) {
				$errors['email'] = 'Account already exists please login';
				foreach ($errors as $key => $value) {
					$key != 'email' && $errors[$key] = '';
				}
			}
		}

		return $errors;
	}

	public function signup() {
		return insert('INSERT INTO tbl_Login (Username,User_type,Password) VALUES(:Username,:User_type,:Password)', [
			'Username' => trim($this->email),
			'User_type' => "customer",
			'Password' => password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 10]),
		]);
	}
}