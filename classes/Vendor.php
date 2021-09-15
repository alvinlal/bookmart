<?php

include "../db/connection.php";

class Vendor {

	private $name;
	private $city;
	private $district;
	private $pincode;
	private $email;
	private $phno;

	public function __construct($name, $city, $district, $pincode, $email, $phno) {
		$this->name = $name;
		$this->city = $city;
		$this->district = $district;
		$this->pincode = $pincode;
		$this->email = $email;
		$this->phno = $phno;
	}

	public function validateInput() {
		$errors = [
			'name' => '',
			'city' => '',
			'district' => '',
			'pincode' => '',
			'email' => '',
			'phno' => '',
		];

		if (!preg_match('/^[a-zA-Z ]{1,60}$/', trim($this->name))) {
			$errors['name'] = "Invalid name";
		}
		if (!preg_match('/^[a-zA-Z ]{1,30}$/', trim($this->city))) {
			$errors['city'] = "Invalid city";
		}
		if (!preg_match('/^[a-zA-Z ]{1,30}$/', trim($this->district))) {
			$errors['district'] = "Invalid district";
		}
		if (!preg_match('/^[0-9]{6,6}$/', trim($this->pincode))) {
			$errors['pincode'] = "Invalid pincode";
		}
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Invalid email';
		}
		if (!preg_match('/^[0-9]{10,10}$/', trim($this->phno))) {
			$errors['phno'] = "Invalid Phone number";
		}

		return $errors;
	}

	public function add() {
		query('INSERT INTO tbl_Vendor(V_added_by,V_phno,V_email,V_name,V_city,V_district,V_pin) VALUES(?,?,?,?,?,?,?)',
			[$_SESSION['username'], $this->phno, trim($this->email), trim($this->name), trim($this->city), trim($this->district), trim($this->pincode)]
		);
	}

	public function update($id) {
		query('UPDATE tbl_Vendor SET V_name=?,V_city=?,V_district=?,V_pin=?,V_email=?,V_phno=? WHERE V_id=?',
			[trim($this->name), trim($this->city), trim($this->district), trim($this->pincode), trim($this->email), $this->phno, $id]);
	}
}

?>