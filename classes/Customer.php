<?php

include "../db/connection.php";

class Customer {
	private $email;
	private $password;
	private $confirmPassword;
	private $userType;
	private $firstname;
	private $lastname;
	private $housename;
	private $city;
	private $district;
	private $pincode;
	private $phno;

	function __construct($data) {
		$this->email = $data['email'] ?? '';
		$this->password = $data['password'] ?? '';
		$this->confirmPassword = $data['confirmpassword'] ?? '';
		$this->firstname = $data['firstname'] ?? '';
		$this->lastname = $data['lastname'] ?? '';
		$this->housename = $data['housename'] ?? '';
		$this->city = $data['city'] ?? '';
		$this->district = $data['district'] ?? '';
		$this->pincode = $data['pincode'] ?? '';
		$this->phno = $data['phno'] ?? '';
		$this->userType = "customer";
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
			if (!preg_match('/^[a-zA-Z0-9!@#$%^&*]+$/', $this->password)) {
				array_push($errors['password'], "Password must contain only letters, numbers and special characters");
			}
			if (strlen($this->password) < 6) {
				array_push($errors['password'], "Password must contain atleast six characters");
			}
			if (strlen($this->password) > 60) {
				array_push($errors['password'], "Password must contain atmost 60 characters");
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
		return query('INSERT INTO tbl_Login (Username,User_type,Password) VALUES(:Username,:User_type,:Password)', [
			'Username' => trim($this->email),
			'User_type' => "customer",
			'Password' => password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 10]),
		]);
	}

	public function validateDetails() {
		$errors = [
			'firstname' => '',
			'lastname' => '',
			'housename' => '',
			'city' => '',
			'district' => '',
			'pincode' => '',
			'phno' => '',
		];

		if (!preg_match('/^[a-zA-Z ]{1,30}$/', trim($this->firstname))) {
			$errors['firstname'] = "Invalid firstname";
		}
		if (!preg_match('/^[a-zA-Z ]{1,30}$/', trim($this->lastname))) {
			$errors['lastname'] = "Invalid lastname";
		}
		if (!preg_match('/^[a-zA-Z0-9 ]{1,30}$/', trim($this->housename))) {
			$errors['housename'] = "Invalid housename";
		}
		if (!preg_match('/^[a-zA-Z]{1,30}$/', trim($this->city))) {
			$errors['city'] = "Invalid city";
		}
		if (!preg_match('/^[a-zA-Z]{1,30}$/', trim($this->district))) {
			$errors['district'] = "Invalid district";
		}
		if (!preg_match('/^[0-9]{6,6}$/', trim($this->pincode))) {
			$errors['pincode'] = "Invalid pincode";
		}
		if (!preg_match('/^[0-9]{10,10}$/', trim($this->phno))) {
			$errors['phno'] = "Invalid Phone number";
		}

		return $errors;
	}

	public function updateDetails($alreadyExists) {
		try {
			if ($alreadyExists) {
				query("UPDATE tbl_Customer SET C_fname=?,C_lname=?,C_housename=?,C_city=?,C_district=?,C_pin=?,C_phno=? WHERE Username='{$_SESSION['username']}';", [
					trim($this->firstname), trim($this->lastname), trim($this->housename), trim($this->city), trim($this->district), (int) (trim($this->pincode)), (int) trim($this->phno),
				]);
				return true;
			}
			query('INSERT INTO tbl_Customer(Username,C_fname,C_lname,C_housename,C_city,C_district,C_pin,C_phno) VALUES (?,?,?,?,?,?,?,?)', [
				$_SESSION['username'], trim($this->firstname), trim($this->lastname), trim($this->housename), trim($this->city), trim($this->district), (int) (trim($this->pincode)), (int) trim($this->phno),
			]);
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	public static function currentDetails() {
		try {
			$details = selectOne('SELECT * FROM tbl_Customer WHERE Username=?', [$_SESSION['username']]);
			return $details;

		} catch (PDOException $e) {
			// set $this->error here
		}
	}

	public function getUserType() {
		return $this->userType;
	}

}