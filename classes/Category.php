<?php

include "../db/connection.php";

class Category {

	private $catname;

	public function __construct($catname) {
		$this->catname = $catname;
	}

	public function validateInput() {
		global $pdo;
		$errors = [
			'catname' => '',
		];

		if (!preg_match('/^[a-zA-Z&\/ ]{1,25}$/', trim($this->catname))) {
			$errors['catname'] = "Invalid category name";
		}

		if (!$errors['catname']) {
			$categoryExists = exists('SELECT Cat_id FROM tbl_Category WHERE Cat_name=?', [$this->catname]);

			if ($categoryExists) {
				$errors['catname'] = "Category already exists";
			}
		}

		return $errors;
	}

	public function add() {
		query('INSERT INTO tbl_Category(Cat_name) VALUES(?)',
			[$this->catname]
		);
	}

	public function update($id) {
		query('UPDATE tbl_Category SET Cat_name=?  WHERE Cat_id=?', [$this->catname, $id]);
	}

}

?>