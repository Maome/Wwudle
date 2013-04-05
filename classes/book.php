<?php
	require_once('classes/dbw.php');
	class book {
		private $dbc;
		private $keyName;
		private $keyValue;
		private $bookID;
		private $ISBN;
		private $authors;
		private $Title;
		private $edition;
		private $bookCategoryID;
		
		function book($dbc, $ISBN = null, $title = null) {
			$this->dbc = $dbc;
			if (is_null($title)) {
				$keyName = 'ISBN';
				$keyValue = $ISBN;
			}
			else {
				$keyName = 'Title';
				$keyValue = '\'' .$title .'\'';
			}
			
			$data = $dbc->query('SELECT BookID, ISBN, Authors, Title, Edition, BookCategoryID FROM Book WHERE ' .$keyName .' = ' .$keyValue);
			if ($data->num_rows == 1) {
				$row = $data->fetch_assoc();
				$this->bookID = $row['BookID'];
				$this->ISBN = $row['ISBN'];
				$this->authors = $row['Authors'];
				$this->title = $row['Title'];
				$this->edition = $row['Edition'];
				$this->bookCategoryID = $row['BookCategoryID'];
			}
		}
		
		function exists($fromDB = false) {
			return !is_null($this->bookID);
		}
		
		function createBook($ISBN,$authors, $title, $edition, $bookCategoryID) {
			$ISBN = dbw::nullIfEmpty($ISBN);
			$title = empty($title) ? 'NULL' : dbw::singleQuote($title);
			$authors = empty($authors) ? 'NULL' : dbw::singleQuote($authors);
			$edition = empty($edition) ? 'NULL' : dbw::singleQuote($edition);
			$bookCategoryID = empty($bookCategoryID) ? 'NULL' : dbw::singleQuote($bookCategoryID);
			
			if (!$this->exists()) {
				$sql = "INSERT INTO Book
					  (ISBN, Authors, Title, Edition, BookCategoryID, ChangeSource, RecordStatus, RecordStatusDate)
					  VALUES(" .$ISBN  ."," .$authors  ."," .$title  ."," .$edition  ."," .$bookCategoryID .", 0, 1, NOW())";
				$this->dbc->query($sql);
				$this->userID = $this->getBookID(true);
				return true;
			}
			else return false;
		}
		
		function getBookID($fromDB = false) {
			if ($fromDB) {
				$this->bookID = $this->dbc->queryUnique('Book','BookID',$keyName .' = ' .$keyValue);
			}
			return $this->bookID;
		}
		
		function getKeyName() { return $this->keyName; }
		function getKeyValue() { return $this->keyValue; }
		function getISBN() { return $this->ISBN; }
		function getAuthors() { return $this->authors; }
		function getTitle() { return $this->title; }
		function getEdition() { return $this->edition; }
		function getBookCategoryID() { return $this->bookCategoryID; }
	}
?>