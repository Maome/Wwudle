<?php
	function createBookListing($dbc, $bookID, $conditionID, $price) {
		$sql = "INSERT INTO BookListing
			(PostDate, UserID, BookID, BookConditionID, Price, ViewCount, ChangeSource, RecordStatus, RecordStatusDate)
			VALUES(NOW()," .$_SESSION['userID'] ."," .$bookID ."," .$conditionID ."," .$price .", 0, 0, 1, NOW());";
		$result = $dbc->query($sql);
	}

	function displayBookListings($srch, $isCourseSearch) {
		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);

		if ($isCourseSearch) {
			$where = "WHERE COALESCE(SUBSTRING_INDEX(bl.Course,' ',1),'') LIKE '%" .$srch[0] ."%'";
			$where .= "AND COALESCE(SUBSTRING_INDEX(bl.Course,' ',-1),'') LIKE '%" .$srch[1] ."%'";
		}
		else {
			if (is_numeric($srch)) {
				$where = "WHERE b.ISBN = " .$srch[0];
			}
			else $where = "WHERE COALESCE(b.Title,'') LIKE '%" .$srch[0] ."%'";
		}
	
		$qry = "SELECT
						b.Title,
						bl.Price Price,
						bc.Description \"Condition\",
						bl.Course
					 FROM BookListing bl
					 JOIN Book b
					 ON (b.BookID = bl.BookID)
					 LEFT JOIN BookCondition bc
					 ON (bc.BookConditionID = bl.BookConditionID)"
					 .$where;
		$result = $dbc->query($qry);
		$dbc->getError();
	
		if ($result->num_rows > 0) {
			$dbc->queryToTable($qry,'booklistings');
		}
		else echo "No results found";
	}
	
	function displaySaleForm($dbc,$isbn, $title) {
		$result = $dbc->query("SELECT BookConditionID, Description FROM BookCondition");
		echo "<div class='bookForm'>";
		echo "<form action='buyselladd.php' method='POST'>";
		echo "Condition<br /> <select name='condition'>";
		while ($row = $result->fetch_row()) {
			echo "<option value='" .$row[0] ."'>" .$row[1] ."</option>";
		}
		echo "</select>";
		echo "<br />Price<br /><input type='text' name='price' placeholder='$' style='height:30px;'>";
		echo "<input type='hidden' name='isbn' value='" .$isbn ."' />";
		echo "<input type='hidden' name='title' value='" .$title ."' />";
		echo "<br /><input type='submit' value='Submit' style='height:30px;' />";
		echo "</form>";
		echo "</div>";
	}
	
	function postBookListing($dbc,$isbn = null,$title = null) {									
		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
		$book = new book($dbc,$isbn,$title,true);
		if (!$book->exists()) $book->createBook($isbn,null,$title,null,null);

		// Insert book listing
		createBookListing($dbc,$book->getBookID(),$_POST['condition'],$_POST['price']);

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
		$startIndex = isset($_GET['page']) ? ($_GET['page'] * $maxResults) : 0;
		$optParams = array('maxResults' => $maxResults, 'startIndex' => $startIndex);
		return $volumes->listVolumes($srchText, $optParams);
	}
	
	function displayBookList($dbc, $results) {
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
			echo '<div class="bookImg" >';
			$thumbnailImg = ($thumbnail) ? "<a href='${preview}'><img alt='$title' src='${thumbnail}' style='border: 1px solid black' /></a>" : ' ';
			echo '<br />' .$thumbnailImg;
			echo '</div>';
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
			//displaySaleForm($dbc, $isbn, $title);
			if (!isset($_GET['page'])) $page = 1;
			else $page = $_GET['page'];
			$prevPage = $page == 1? $page : $page - 1;
			echo '</div>';
			echo '</div>';
			echo '
			<div class="span12" style="margin: 0px;">
				<ul class="nav nav-list">
			<li class="divider"></li>
			</ul>
			</div>';
		}
		  echo '
		  <div class="span9">
		  <div class="pagination pagination pagination-centered">
			<ul>
				<li><a href="?srchText=' .$_GET['srchText'] .'&page=' .$prevPage .'">&lt;&lt;</a></li>
				<li><a>Page ' .$page .'</a></li>
				<li><a href="?srchText=' .$_GET['srchText'] .'&page='  .($page + 1) .'">&gt;&gt;</a></li>
			</ul>
		</div>
		</div>';
	  }
	  else echo '<b>No results found</b>';
	}
?>
