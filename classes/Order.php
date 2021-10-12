<?php

include "../db/connection.php";

class Order {

	private $orderId;

	public function __construct() {

	}

	public function getOrderId() {
		return $this->orderId;
	}

}

?>