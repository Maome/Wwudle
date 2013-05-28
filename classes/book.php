<?php
	require_once('classes/dbw.php');
	class book {
		private $dbc;
		private $keyName;
		private $keyValue;
		private $bookID;
		private $isbn;
		private $authors;
		private $Title;
		private $edition;
		private $bookCategoryID;
		private $userID;
		
		function book($dbc, $isbn = null, $title = null) {
			$this->dbc = $dbc;
			if (!is_null($isbn)) {
				$this->keyName = 'isbn';
				$this->keyValue = $isbn;
			}
			else {
				$this->keyName = 'Title';
				$this->keyValue = '\'' .$title .'\'';
			}
			
			$data = $dbc->query('
				SELECT BookID, ISBN, Authors, Title, Edition, BookCategoryID, UserID
				FROM Book 
				WHERE RecordStatus <> 3
				AND ' .$this->keyName .' = ' .$this->keyValue
			);
			if ($data->num_rows == 1) {
				$row = $data->fetch_assoc();
				$this->bookID = $row['BookID'];
				$this->isbn = $row['isbn'];
				$this->authors = $row['Authors'];
				$this->title = $row['Title'];
				$this->edition = $row['Edition'];
				$this->bookCategoryID = $row['BookCategoryID'];
				$this->userID = $row['UserID'];
			}
		}
		
		function exists($fromDB = false) {
			return !is_null($this->bookID);
		}
		
		function createBook($isbn, $authors, $title, $edition, $bookCategoryID, $userID = NULL) {
			$isbn = dbw::nullIfEmpty($isbn);
			$title = empty($title) ? 'NULL' : dbw::singleQuote($title);
			$authors = empty($authors) ? 'NULL' : dbw::singleQuote($authors);
			$edition = empty($edition) ? 'NULL' : dbw::singleQuote($edition);
			$bookCategoryID = empty($bookCategoryID) ? 'NULL' : dbw::singleQuote($bookCategoryID);
			$userID = is_null($userID) ? 'NULL' : $userID;
			
			if (!$this->exists()) {
				$sql = "INSERT INTO Book
					  (ISBN, Authors, Title, Edition, BookCategoryID, UserID, ChangeSource, RecordStatus, RecordStatusDate)
					  VALUES(" .$isbn  ."," .$authors  ."," .$title  ."," .$edition  ."," .$bookCategoryID ."," .$userID .", 0, 1, NOW())";
				$this->dbc->query($sql);
				$this->userID = $this->getBookID(true);
				return true;
			}
			else return false;
		}
		
		function getBookID($fromDB = false) {
			if ($fromDB) {
				$this->bookID = $this->dbc->queryUnique('Book','BookID',$this->keyName .' = ' .$this->keyValue);
			}
			return $this->bookID;
		}
		
		function getKeyName() { return $this->keyName; }
		function getKeyValue() { return $this->keyValue; }
		function getisbn() { return $this->isbn; }
		function getAuthors() { return $this->authors; }
		function getTitle() { return $this->title; }
		function getEdition() { return $this->edition; }
		function getBookCategoryID() { return $this->bookCategoryID; }
	}
?>
