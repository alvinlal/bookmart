<?php

include "../db/connection.php";

class Author {

	private $authorname;

	public function __construct($authorname) {
		$this->authorname = $authorname;
	}

	public function validateInput($isEditing = false) {
		$errors = [
			'authorname' => '',
		];

		if (!preg_match('/^[a-zA-Z ]{1,30}$/', trim($this->authorname))) {
			$errors['authorname'] = "Invalid author name";
		}

		if (!$errors['authorname'] && !$isEditing) {
			$categoryExists = exists('SELECT Author_id FROM tbl_Author WHERE A_name=?', [$this->authorname]);

			if ($categoryExists) {
				$errors['authorname'] = "Author already exists";
			}
		}

		return $errors;
	}

	public function add() {
		query('INSERT INTO tbl_Author(A_name) VALUES(?)',
			[strtolower($this->authorname)]
		);
	}

	public function update($id) {
		query('UPDATE tbl_Author SET A_name=?  WHERE Author_id=?', [strtolower($this->authorname), $id]);
	}

}

?>