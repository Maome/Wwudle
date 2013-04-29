<?php
	require_once('classes/dbw.php');
	// CONTAINS THE PHP FUNCTIONS ASSOCIATED WITH THE REVIEWS PORTION OF WESTERN LIST
	
	// The database info
	
	// Function to show the most resent ride shares posted 	
	function ShowReviews($data, $courseNum, $isCourse)
	{
		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG,true);
		if (!$isCourse) {
			$qry = "SELECT CourseDept, CourseNumber, Professor, Workload, LectureQuality, TestRelevance, RelevanceToProgram, Enjoyable, BookNecessity, Comments, Overall, PostID FROM Review WHERE Professor = '$data' ORDER BY PostID DESC;";	
		}
		else {
			$qry = "SELECT CourseDept, CourseNumber, Professor, Workload, LectureQuality, TestRelevance, RelevanceToProgram, Enjoyable, BookNecessity, Comments, Overall, PostID FROM Review WHERE CourseDept = '$data' AND CourseNumber = '$courseNum' ORDER BY PostID DESC;";	
		}
		//$dbc->queryToTable($qry, 'profReviews');
		
		$result = $dbc->query($qry);		
		$row = $result->fetch_row();  
		
		if ($row) {
			if(!$isCourse) {
				$prof = $row[2];
				$profqry = "SELECT AVG(Overall) FROM Review WHERE Professor = '$prof'";
				$profresult = $dbc->query($profqry);
				$profrow = $profresult->fetch_row();
			
				if($profrow) {
					echo "<h4>". $row[2] ."</h4><p>Average overall rating: ". number_format($profrow[0], 2) ." out of 5</p><br />";
				}
				else {
					echo "<h6>Not yet rated</h6>";
				} 
			}
			echo "
				<table id='table_id' class='table table-striped' data-provides='rowlink'>
					<thead>
					<tr>
						<th>Professor <i class='icon-chevron-down'></i></th>
						<th>Course <i class='icon-chevron-down'></i></th>
						<th>Workload <i class='icon-chevron-down'></i></th>
						<th>Lecture Quality <i class='icon-chevron-down'></i></th>
						<th>Test Relevance <i class='icon-chevron-down'></i></th>
						<th>Relevance To Program <i class='icon-chevron-down'></i></th>
						<th>Enjoyable <i class='icon-chevron-down'></i></th>
						<th>Book Necessity <i class='icon-chevron-down'></i></th>
						<th>Overall <i class='icon-chevron-down'></i></th></tr>

					</tr>
					</thead>
					<tbody>
			";
			while($row){			            
				$workload = GetWorkload($row[3]);
				$booknec = GetBookNecessity($row[8]);	
				echo "			
					<tr class='rowlink'>
						<td><a href='reviewinfo?PostID=$row[11]'> </a>$row[2]</td>
						<td>$row[0] $row[1]</td>
						<td>". $workload ."</td>
						<td>$row[4]</td>
						<td>$row[5]</td>
						<td>$row[6]</td>
						<td>$row[7]</td>
						<td>". $booknec ."</td>
						<td>$row[10]</td>

					</tr>									
				";
				$row = $result->fetch_row();  
			}
			echo "</tbody></table>";
		}
		else {
			echo "No reviews found.";
		}
	}
	
	function GetWorkload($value)
	{
		if ($value == 0) {
			return 'Light';
		}
		else if ($value == 1) {
			return 'Moderate';
		}
		else {
			return 'Heavy';
		}
	}
	
	function GetBookNecessity($value)
	{
		if($value == 0) {
			return 'Absolutely necessary';
		}
		else if($value == 1) {
			return 'Somewhat necessary';
		}
		else {
			return 'Not necessary';
		}
	}
		
	// Function to display the info about a rideshare given a PostID
	function ShowReviewInfo($PostID)
	{
		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
		
		// Get the information about this rideshare
		$sql = "SELECT CourseDept, CourseNumber, Professor, Workload, LectureQuality, TestRelevance, RelevanceToProgram, Enjoyable, BookNecessity, Comments, Overall, PostID FROM Review WHERE PostID = $PostID;";
		$result = $dbc->query($sql);
		$row = $result->fetch_row();		
								
	}
?>
