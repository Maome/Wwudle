<?php
	require_once('init.php');
	require_once 'google-api-php-client/src/Google_Client.php';
	require_once 'google-api-php-client/src/contrib/Google_BooksService.php';
	
	use JasonKaz\FormBuild\Form as Form;
	use JasonKaz\FormBuild\Text as Text;
	use JasonKaz\FormBuild\Submit as Submit;
	use JasonKaz\FormBuild\Password as Password;
	use JasonKaz\FormBuild\Select as Select;	
	use JasonKaz\FormBuild\Reset as Reset;
	use JasonKaz\FormBuild\Custom as Custom;
	use JasonKaz\FormBuild\Textarea as Textarea;
	use JasonKaz\FormBuild\Hidden as Hidden;
	
	// Insert a book listing into the database
	function createBookListing($dbc, $bookID, $conditionID, $price, $course) {
		$sql = "INSERT INTO BookListing
			(PostDate, UserID, BookID, BookConditionID, Price, ViewCount, ChangeSource, RecordStatus, RecordStatusDate, Course)
			VALUES(NOW()," .$_SESSION['userID'] ."," .$bookID ."," .$conditionID ."," .$price .", 0, 0, 1, NOW(), " .$dbc::singleQuote($course) .");";
		$result = $dbc->query($sql);
	}

	// Display book listing based on user search
	function displayBookListings($srch, $isCourseSearch) {
		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);

		// Build SQL
		if ($isCourseSearch) {
			$where = "WHERE COALESCE(SUBSTRING_INDEX(bl.Course,' ',1),'') LIKE '%" .$srch[0] ."%'";
			$where .= "AND COALESCE(SUBSTRING_INDEX(bl.Course,' ',-1),'') LIKE '%" .$srch[1] ."%'";
		}
		else {
			if (is_numeric($srch)) {
				$where = "WHERE b.ISBN = " .$srch[0];
			}
			else {
				// Search for titles matching any word
				$tokens = explode(' ',$srch[0]);
				if (count($tokens) > 0) {
					$where = "WHERE COALESCE(b.Title,'') LIKE '%" .$tokens[0] ."%'";
					for($i = 1; $i < count($tokens); $i++) {
						$where .= " OR COALESCE(b.Title,'') LIKE '%" .$tokens[$i] ."%'";
					}
				}
			}
		}
	
		$qry = "SELECT
					CONCAT(CONCAT(CONCAT(CONCAT('<a href=\"buysellview.php?postID=',bl.PostID),'\">'),b.Title),'</a>') \"Title\",
					bl.Price Price,
					bc.Description \"Condition\",
					bl.Course
					FROM BookListing bl
					JOIN Book b
					ON (b.BookID = bl.BookID)
					LEFT JOIN BookCondition bc
					ON (bc.BookConditionID = bl.BookConditionID)"
					 .$where;
		$headers = array(
			"Title&nbsp;<i class='icon-chevron-down'>",
			"Price&nbsp;<i class='icon-chevron-down'>",
			"Description&nbsp;<i class='icon-chevron-down'>",
			"Course&nbsp;<i class='icon-chevron-down'>"
		);
		//$dbc->setDebug(true);
		$result = $dbc->query($qry);
	
		if ($result->num_rows > 0) {
			$dbc->queryToTable($qry,'bookListings',$headers);
		}
		else echo "No results found";
	}
	
	function displaySaleForm($dbc,$isbn, $title) {
		echo '<div class="bookForm">';
		$bookForm = new Form;
		echo $bookForm->init('','post',array('class'=>'form-horizontal','style'=>'margin-left: -80px; margin-top: 25px;','name'=>'bookAdd'))
		->group('Condition',
			new Select($dbc->queryPairs('SELECT BookConditionID, Description FROM BookCondition ORDER BY BookConditionID'),1, array('class'=>'input-large','name'=>'bookCondition'))
		)
		->group('Subject',
			new Select($dbc->queryPairs('SELECT Abbreviation,Description FROM Department WHERE RowOrder=1 ORDER BY RowOrder, Abbreviation'), 1, array('class'=>'input-large','name'=>'subject'))
		)
		->group('Course',
			new Text(array('class'=>'input-small','name'=>'courseNumber', 'placeholder'=>'Course #'))
		)
		->group('Price',
			new Text(array('class'=>'input-small','name'=>'price','placeholder'=>'$'))
		)
		->hidden(array('name'=>'isbn','value'=>$isbn)
		)
		->group('',
			new Submit('Submit', array('class' => 'btn btn-primary'))
		)
		->render();
		echo '</div>';
	}
	
	function displayManualSaleForm() {
		echo $bookForm->init('','post',array('class'=>'form-horizontal','style'=>'margin-left: -80px; margin-top: 25px;','name'=>'bookAddManual'))
		->group('Title',
			new Text(array('class'=>'input-large','name'=>'title'))
		)
		->group('Author(s)',
			new Text(array('class'=>'input-large','name'=>'authors'))
		)
		->group('Condition',
			new Select($dbc->queryPairs('SELECT BookConditionID, Description FROM BookCondition ORDER BY BookConditionID'),1, array('class'=>'input-large','name'=>'bookCondition'))
		)
		->group('Subject',
			new Select($dbc->queryPairs('SELECT Abbreviation,Description FROM Department WHERE RowOrder=1 ORDER BY RowOrder, Abbreviation'), 1, array('class'=>'input-large','name'=>'subject'))
		)
		->group('Course',
			new Text(array('class'=>'input-small','name'=>'courseNumber', 'placeholder'=>'Course #'))
		)
		->group('Price',
			new Text(array('class'=>'input-small','name'=>'price','placeholder'=>'$'))
		)
		->hidden(array('name'=>'isbn','value'=>$isbn)
		)
		->group('',
			new Submit('Submit', array('class' => 'btn btn-primary'))
		)
		->render();
	}
	
	function postBookListing($dbc,$isbn = null,$title = null, $authors = null) {
		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
		$book = new book($dbc,$isbn,$title);
		if (!$book->exists()) $book->createBook($isbn,$authors,$title,null,null);

		// Insert book listing
		createBookListing($dbc,$book->getBookID(),$_POST['bookCondition'],$_POST['price'], $_POST['subject'] .' ' .$_POST['courseNumber']);

		echo "
		  <div>
			<b> Your book has been listed! </b>
		  </div>
		";
	}
	
	function getBookInformation($srchText) {
		$client = new Google_Client();
		$client->setDeveloperKey('AIzaSyCUXX2Wi9fKlaw2HTpgQnsFxG-0YTTIeW0');
		$client->setApplicationName("Books_Example_App");
		$service = new Google_BooksService($client);
		$volumes = $service->volumes;
		$maxResults = 10;
		$startIndex = 0;
		$optParams = array('maxResults' => $maxResults, 'startIndex' => $startIndex);
		return $volumes->listVolumes($srchText, $optParams);
	}
	
	// Display book list based on search for book to put for sale
	function displayBookList($dbc, $isbn) {
		$results = getBookInformation('isbn:' .$isbn);
		
		if ($results['items'] != NULL) {
			foreach ($results['items'] as $result) {
				$volumeInfo = $result['volumeInfo'];
				$title = $volumeInfo['title'];
				if (isset($volumeInfo['imageLinks']['thumbnail'])) {
					$thumbnail = $volumeInfo['imageLinks']['thumbnail'];
				} 
				else $thumbnail = null;

				if (isset($volumeInfo['authors'])) {
					$creators = implode(" / ", $volumeInfo['authors']);
				}

				echo '<div class="span9">';
				echo '<div class="bookInfo">';
				echo '<br /><b>' .$title .'</b>';
				echo '<br />Author(s): ' .$creators;
				echo '<br />';
				$identifiers = $volumeInfo['industryIdentifiers'];
				$isbn = string;
				for($i = 0; $i < count($identifiers); $i++) {
					if ($identifiers[$i]['type'] == 'ISBN_10') echo "ISBN 10: " .$identifiers[$i]['identifier'] ."<br />";
					else if ($identifiers[$i]['type'] == 'ISBN_13') {
						echo "ISBN 13: " .$identifiers[$i]['identifier'] ."<br />";
						$isbn = $identifiers[$i]['identifier'];
					}
				}
				echo '<div class="bookImg" >';
				$thumbnailImg = ($thumbnail) ? "<a href='${preview}'><img alt='$title' src='${thumbnail}' style='border: 1px solid black; height: 300px; width: auto;' /></a>" : ' ';
				echo '<br />' .$thumbnailImg;
				echo '</div>';
				echo '</div>';

				displaySaleForm($dbc, $isbn, $title);
			}
		}
		else {
			$book = new book($dbc,$isbn,$title);

			// TODO Handle previous manual entries for books
			if ($book->exists()) {

			}
			else	echo '<b>No results found</b>';
		}
	}
?>
