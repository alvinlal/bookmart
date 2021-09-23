<?php

include "../db/connection.php";
include "../storage/s3.php";

class Item {

	private $title;
	private $authorid;
	private $subcategoryid;
	private $publisherid;
	private $isbn;
	private $price;
	private $noofpages;
	private $language;
	private $description;
	private $coverimage;

	public function __construct($title, $authorid, $subcategoryid, $publisherid, $isbn, $price, $noofpages, $language, $description, $coverimage) {
		$this->title = $title;
		$this->authorid = $authorid;
		$this->subcategoryid = $subcategoryid;
		$this->publisherid = $publisherid;
		$this->isbn = $isbn;
		$this->price = $price;
		$this->noofpages = $noofpages;
		$this->language = $language;
		$this->description = $description;
		$this->coverimage = $coverimage;

	}

	public function validateInput($isEditing = false) {
		$errors = [
			'title' => '',
			'isbn' => '',
			'price' => '',
			'noofpages' => '',
			'language' => '',
			'description' => '',
			'coverimage' => '',
		];
		if (!preg_match('/^[a-zA-Z0-9&\'"\/: ]{1,100}$/', trim($this->title))) {
			$errors['title'] = "Invalid title";
		}

		if (!$errors['title'] && !$isEditing) {
			$titleExists = exists('SELECT I_status FROM tbl_Item WHERE I_title=?', [$this->title]);
			if ($titleExists) {
				$errors['title'] = "title already exists";
				return $errors;
			}
		}

		if (!preg_match('/^[0-9]{10,13}$/', trim($this->isbn))) {
			$errors['isbn'] = "Invalid isbn";
		}
		if (!preg_match('/^[0-9.]{1,11}$/', trim($this->price))) {
			$errors['price'] = "Invalid price";
		}

		if (!preg_match('/^[0-9]+$/', trim($this->noofpages))) {
			$errors['noofpages'] = "Invalid no of pages";
		}
		if (!preg_match('/^[a-zA-Z]{1,10}$/', trim($this->language))) {
			$errors['language'] = "Invalid language";
		}
		if (strlen(trim($this->description)) < 20) {
			$errors['description'] = "Description must be atleast 20 characters";
		}
		if (!$isEditing && $this->coverimage['name'] == '') {
			$errors['coverimage'] = "Please select a file";
		}

		$ext = pathinfo($this->coverimage['name'], PATHINFO_EXTENSION);

		if (!$isEditing && !$errors['coverimage'] && $ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'webp') {
			$errors['coverimage'] = "Image type must be jpg,jpeg,png or webp";
		}
		if (!$isEditing && !$errors['coverimage'] && $this->coverimage['size'] > 5242880) {
			$errors['coverimage'] = "File must be less than 5mb";
		}

		return $errors;
	}

	public function add() {
		global $s3;
		$extension = pathinfo($this->coverimage['name'], PATHINFO_EXTENSION);
		$uploadName = bin2hex(random_bytes(10)) . "." . $extension;

		if (getenv('ENV') == "production") {
			$s3->putObject([
				'Bucket' => 'bookmart-site',
				'Key' => 'covers/' . $uploadName,
				'SourceFile' => $this->coverimage['tmp_name'],
				'StorageClass' => 'REDUCED_REDUNDANCY',
			]);
		} else {
			$s3->putObject([
				'Bucket' => 'bookmart-site',
				'Key' => 'covers/' . $uploadName,
				'SourceFile' => $this->coverimage['tmp_name'],
				'StorageClass' => 'REDUCED_REDUNDANCY',
			]);

			move_uploaded_file($this->coverimage['tmp_name'], getenv('ROOT_DIR') . '/public/images/covers/' . $uploadName);
		}
		date_default_timezone_set("Asia/Kolkata");
		query("INSERT INTO tbl_Item (I_title, Author_id,Publisher_id,SubCat_id, I_isbn, I_price, I_no_of_pages, I_language, I_date_added, I_description, I_cover_image) VALUES (?,?,?,?,?,?,?,?,?,?,?)", [trim($this->title), $this->authorid, $this->publisherid, $this->subcategoryid, $this->isbn, $this->price, $this->noofpages, trim($this->language), date("Y/m/d"), trim($this->description), $uploadName]);
	}

	public function update($id) {
		if ($this->coverimage['name'] != '') {
			global $s3;

			$row = selectOne('SELECT I_cover_image FROM tbl_Item WHERE Item_id=?', [$id]);
			$uploadName = $row['I_cover_image'];

			if (getenv('ENV') == "production") {
				$s3->putObject([
					'Bucket' => 'bookmart-site',
					'Key' => 'covers/' . $uploadName,
					'SourceFile' => $this->coverimage['tmp_name'],
					'StorageClass' => 'REDUCED_REDUNDANCY',
				]);
			} else {
				$s3->putObject([
					'Bucket' => 'bookmart-site',
					'Key' => 'covers/' . $uploadName,
					'SourceFile' => $this->coverimage['tmp_name'],
					'StorageClass' => 'REDUCED_REDUNDANCY',
				]);

				move_uploaded_file($this->coverimage['tmp_name'], getenv('ROOT_DIR') . '/public/images/covers/' . $uploadName);
			}
			query("UPDATE tbl_Item SET I_title=?,Author_id=?,Publisher_id=?,SubCat_id=?,I_isbn=?,I_description=?,I_price=?,I_no_of_pages=?,I_language=? WHERE Item_id=?", [trim($this->title), $this->authorid, $this->publisherid, $this->subcategoryid, $this->isbn, trim($this->description), $this->price, $this->noofpages, $this->language, $id]);
		} else {
			query("UPDATE tbl_Item SET I_title=?,Author_id=?,Publisher_id=?,SubCat_id=?,I_isbn=?,I_description=?,I_price=?,I_no_of_pages=?,I_language=? WHERE Item_id=?", [trim($this->title), $this->authorid, $this->publisherid, $this->subcategoryid, $this->isbn, trim($this->description), $this->price, $this->noofpages, $this->language, $id]);
		}

	}

}

?>