<?php

include_once "../db/connection.php";
include_once "../classes/Session.php";

class Card {
	private $cardno;
	private $cardname;
	private $cardcvv;
	private $expirydate;

	function __construct($cardno, $cardname, $cardcvv, $expirydate) {
		$this->cardno = $cardno;
		$this->cardname = $cardname;
		$this->cardcvv = $cardcvv;
		$this->expirydate = $expirydate;
	}

	public function validateDetails() {
		$errors = [
			'cardno' => '',
			'cardname' => '',
			'cardcvv' => '',
			'expirydate' => '',
		];

		if (!preg_match('/^[0-9]{16,16}$/', trim($this->cardno))) {
			$errors['cardno'] = "Invalid card number";
		}
		if (!preg_match('/^[a-zA-Z ]{1,60}$/', trim($this->cardname))) {
			$errors['cardname'] = "Invalid name";
		}
		if (!preg_match('/^[0-9]{3,3}$/', trim($this->cardcvv))) {
			$errors['cardcvv'] = "Invalid cvv";
		}
		$givenDate = new DateTime($this->expirydate);
		$now = new DateTime();
		if ($givenDate < $now) {
			$errors['expirydate'] = 'Invalid date';
		}

		return $errors;
	}

	public function updateDetails($alreadyExists) {
		try {
			if ($alreadyExists) {
				query("UPDATE tbl_Card SET Card_no=?,Card_cvv=?,Card_name=?,Expiry_date=? WHERE Username='{$_SESSION['username']}';", [
					trim($this->cardno), trim($this->cardcvv), trim($this->cardname), $this->expirydate,
				]);
				return true;
			}
			query('INSERT INTO tbl_Card(Username,Card_no,Card_cvv,Card_name,Expiry_date) VALUES (?,?,?,?,?)', [
				$_SESSION['username'], trim($this->cardno), trim($this->cardcvv), trim($this->cardname), trim($this->expirydate),
			]);
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

}