<?php

include "../db/connection.php";

class Staff {

	private $fname;
	private $lname;
	private $housename;
	private $city;
	private $district;
	private $pincode;
	private $email;
	private $phno;
	private $doj;
	private $password;

	public function __construct($fname, $lname, $housename, $city, $district, $pincode, $email, $phno, $doj) {
		$this->fname = $fname;
		$this->lname = $lname;
		$this->housename = $housename;
		$this->city = $city;
		$this->district = $district;
		$this->pincode = $pincode;
		$this->email = $email;
		$this->phno = $phno;
		$this->doj = $doj;

	}

	public function validateInput() {
		$errors = [
			'fname' => '',
			'lname' => '',
			'housename' => '',
			'city' => '',
			'district' => '',
			'pin' => '',
			'email' => '',
			'phno' => '',
			'password' => [],
			'confirmpassword' => '',
			'doj' => '',
		];

		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Invalid email';
		}

		if (!$errors['email']) {
			$emailExists = exists('SELECT Username FROM tbl_Login WHERE Username = ?', [$this->email]);
			if ($emailExists) {
				$errors['email'] = 'Email already exists';
				return $errors;
			}
		}

		if (!preg_match('/^[a-zA-Z ]{1,60}$/', trim($this->fname))) {
			$errors['fname'] = "Invalid first name";
		}
		if (!preg_match('/^[a-zA-Z ]{1,60}$/', trim($this->lname))) {
			$errors['lname'] = "Invalid last name";
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

	public function generatePassword() {
		$password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*"), 0, 8);
		$this->password = $password;
		return $password;
	}

	public function add() {
		global $pdo;
		$this->generatePassword();
		$pdo->beginTransaction();
		try {
			query('INSERT INTO tbl_Login(Username,User_type,password) VALUES(?,?,?)', [$this->email, "staff", password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 10])]);

			query('INSERT INTO tbl_Staff(Username,S_fname,S_lname,S_housename,S_city,S_district,S_pin,S_phno,S_doj) VALUES(?,?,?,?,?,?,?,?,?)',
				[$this->email, $this->fname, $this->lname, $this->housename, $this->city, $this->district, $this->pincode, $this->phno, $this->doj]
			);
			$pdo->commit();
		} catch (PDOException $e) {
			$pdo->rollBack();
			throw $e;
		}
	}

	public function update($id) {
		query('UPDATE tbl_Vendor SET V_name=?,V_city=?,V_district=?,V_pin=?,V_email=?,V_phno=? WHERE V_id=?',
			[$this->name, $this->city, $this->district, $this->pincode, $this->email, $this->phno, $id]);
	}

	public function getPassword() {
		return $this->password;
	}
}

?>