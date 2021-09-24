<?php

include "../db/connection.php";

class Purchase {

	private $vendorid;
	private $date;
	private $items;

	public function __construct($items, $vendorid = '', $date = '') {
		$this->vendorid = $vendorid;
		$this->date = $date;
		$this->items = $items;
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