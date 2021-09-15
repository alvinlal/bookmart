<?php

include "../db/connection.php";

class SubCategory {

	private $subcatname;
	private $categoryid;

	public function __construct($subcatname, $categoryid) {
		$this->subcatname = $subcatname;
		$this->categoryid = $categoryid;
	}

	public function validateInput($isEditing = false) {
		$errors = [
			'subcatname' => '',
		];
		if (!preg_match('/^[a-zA-Z&\/ ]{1,25}$/', trim($this->subcatname))) {
			$errors['subcatname'] = "Invalid subcategory name";
		}

		if (!$errors['subcatname'] && !$isEditing) {
			$subcategoryExists = exists('SELECT Cat_id,SubCat_name FROM tbl_SubCategory WHERE Cat_id=? AND SubCat_name=?', [$this->categoryid, $this->subcatname]);

			if ($subcategoryExists) {
				$errors['subcatname'] = "sub category already exists";
			}
		}

		return $errors;
	}

	public function add() {
		query('INSERT INTO tbl_SubCategory(SubCat_name,Cat_id) VALUES(?,?)',
			[trim($this->subcatname), $this->categoryid],
		);

	}

	public function update($id) {
		query('UPDATE tbl_SubCategory SET SubCat_name=?,Cat_id=?  WHERE SubCat_id=?', [trim($this->subcatname), $this->categoryid, $id]);
	}

}

?>