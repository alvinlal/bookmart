<?php
include_once './db/connection.php';

class Review {
	private $content;
	private $username;
	private $itemId;

	public function __construct($content, $username, $id) {
		$this->username = $username;
		$this->itemId = $id;
		$this->content = $content;
	}

	public function validateInput() {
		$errors = [
			'content' => '',
		];

		if (strlen(trim($this->content)) < 4) {
			$errors['content'] = "Review should be atleast 4 characters !";
		}

		return $errors;

	}

	public function add() {
		query('INSERT INTO tbl_Review(Item_id,Username,R_content,R_date) VALUES(?,?,?,?)',
			[$this->itemId, $this->username, trim($this->content), date("Y/m/d")]
		);
	}

}

?>