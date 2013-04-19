<?php
	function createBookListing($dbc, $bookID, $conditionID, $price) {
		$dbc->setDebug(true);
		echo 'Hello!';
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
						b.ISBN,
						b.Title,
						bl.Price Price,
						bc.Description
					 FROM BookListing bl
					 JOIN Book b
					 ON (b.BookID = bl.BookID)
					 LEFT JOIN BookCondition bc
					 ON (bc.BookConditionID = bl.BookConditionID)"
					 .$where;
		$result = $dbc->query($qry);
	
		if ($result->num_rows > 0) {
			/*$fields = array("ISBN","Title","Price","Description");
			echo "<table class='table table-striped'>";
				// Display header
				echo "<thead>";
					foreach ($fields as $i) echo "<th>" .$i ."</th>";
				echo "</thead><tbody>";
			
				// Display rows
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
						foreach ($fields as $i){
							echo "<td>" .$row[$i] ."</td>";
						}
					echo "</tr>";
				}
			echo "</tbody></table>";*/
			$dbc->queryToTable($qry,'booklistings');
		}
		else echo "No results found";
	} 
?>
