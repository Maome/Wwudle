<?php
require_once('../../private_html/connect.php');
class BookListing {
	private $bookListingID;
	private $userID;
	private $bookID;
	private $conditionID;

	public function __construct($userID, $bookID, $conditionID) {
			$this->userID = $UserID;
			$this->bookID = $bookID;
			$this->conditionID = $conditionID;
	}

	public function createListing() {

	}

	public function getListing() {

	}

	public function deleteListing() {

	}

}
