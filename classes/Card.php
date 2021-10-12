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

	public function validateDetails($isEditing = false) {
		$errors = [
			'cardno' => '',
			'cardname' => '',
			'cardcvv' => '',
			'expirydate' => '',
		];

		if (!preg_match('/^[0-9]{16,16}$/', trim($this->cardno))) {
			$errors['cardno'] = "Invalid card number";
		}
		if (!$isEditing) {
			$alreadyExists = selectOne("SELECT Card_no FROM tbl_Card WHERE Username=? AND Card_no=? AND Card_status='active'", [Session::getSession('username'), $this->cardno]);

			if ($alreadyExists) {
				$errors['cardno'] = "Card already exists";
			}
		}

		if (!preg_match('/^[a-zA-Z ]{1,60}$/', trim($this->cardname))) {
			$errors['cardname'] = "Invalid name";
		}
		if (!preg_match('/^[0-9]{3,3}$/', trim($this->cardcvv))) {
			$errors['cardcvv'] = "Invalid cvv";
		}

		if (!preg_match('/^[0-9]{2,2}\/[0-9]{4,4}$/', trim($this->expirydate))) {
			$errors['expirydate'] = "Date format should be MM/YYYY";
			return $errors;

		}
		$month = explode("/", $this->expirydate)[0];
		$year = explode("/", $this->expirydate)[1];

		if ($month == 00 || $month > 12) {
			$errors['expirydate'] = "Invalid expiry date";
		}

		$expires = \DateTime::createFromFormat('mY', $month . $year);
		$now = new \DateTime();

		if ($expires < $now) {
			$errors['expirydate'] = "Invalid expiry date";
		}

		return $errors;
	}

	public function update($id) {
		try {

			query("UPDATE tbl_Card SET Card_no=?,Card_cvv=?,Card_name=?,Expiry_date=? WHERE Card_id=?';", [
				trim($this->cardno), trim($this->cardcvv), trim($this->cardname), $this->expirydate, $id,
			]);
			return true;

		} catch (PDOException $e) {
			return false;
		}
	}

	public function add() {
		try {
			query('INSERT INTO tbl_Card(Username,Card_no,Card_cvv,Card_name,Expiry_date) VALUES (?,?,?,?,?)', [
				$_SESSION['username'], trim($this->cardno), trim($this->cardcvv), trim($this->cardname), trim($this->expirydate),
			]);
		} catch (PDOException $e) {
			return false;
		}
	}

}