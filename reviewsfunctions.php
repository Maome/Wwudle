<?php
	require_once('classes/dbw.php');
	// CONTAINS THE PHP FUNCTIONS ASSOCIATED WITH THE REVIEWS PORTION OF WESTERN LIST
	
	// Function to show reviews posted 	
	function ShowReviews($qry, $isCourse, $isProf)
	{
		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);

		$result = $dbc->query($qry);		
		$row = $result->fetch_row();  
		
		if ($row) {
			if(!$isCourse) {
				$prof = $row[2];
				$profqry = "SELECT AVG(Overall) FROM Review WHERE Professor = '$prof'";
				$profresult = $dbc->query($profqry);
				$profrow = $profresult->fetch_row();
			
				if($profrow) {
					echo "<h3>". $row[2] ."</h3><p><b>Average overall rating: ". number_format($profrow[0], 2) ." out of 5</b></p><br />";
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
						<!--<th>Workload <i class='icon-chevron-down'></i></th>
						<th>Lecture Quality <i class='icon-chevron-down'></i></th>
						<th>Test Relevance <i class='icon-chevron-down'></i></th>
						<th>Relevance To Program <i class='icon-chevron-down'></i></th>
						<th>Enjoyable <i class='icon-chevron-down'></i></th>
						<th>Book Necessity <i class='icon-chevron-down'></i></th>-->
						<th>Overall <i class='icon-chevron-down'></i></th></tr>

					</tr>
					</thead>
					<tbody>
			";
			while($row){			            
				$workload = GetWorkload($row[3]);
				$booknec = GetBookNecessity($row[8]);	
				echo "			
					<tr id='$row[11]' class='rowlink'>
						<td>$row[2]</td>
						<td>$row[0] $row[1]</td>
						<!--<td>". $workload ."</td>
						<td>$row[4]</td>
						<td>$row[5]</td>
						<td>$row[6]</td>
						<td>$row[7]</td>
						<td>". $booknec ."</td>-->
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
		
	// Function to display the info about a review given a PostID
	function ShowReviewInfo($PostID)
	{
		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
		
		// Get the information about this review
		$sql = "SELECT CourseDept, CourseNumber, Professor, Workload, LectureQuality, TestRelevance, RelevanceToProgram, Enjoyable, BookNecessity, Comments, Overall, PostID FROM Review WHERE PostID = $PostID;";
		$result = $dbc->query($sql);
		$row = $result->fetch_row();
		echo "<h4>Review Details</h4>";
		echo "
			<table id='table_id' class='table table-striped'>
				<tbody>
					<tr>
						<td><b>Course</b></td><td>". $row[0] ." ". $row[1] ."</td>
					</tr>
					<tr>
						<td><b>Professor</b></td><td>". $row[2] ."</td>
					</tr>
					<tr>
						<td><b>Workload</b></td><td>"; if($row[3] == 0) echo "Light"; else if($row[3] == 1) echo "Moderate"; else echo "Heavy"; echo "</td>
					</tr>
					<tr>
						<td><b>Lecture Quality</b></td><td>". $row[4] ."</td>
					</tr>
					<tr>
						<td><b>Test Relevance</b></td><td>". $row[5] ."</td>
					</tr>
					<tr>
						<td><b>Relevance To Program</b></td><td>". $row[6] ."</td>
					</tr>
					<tr>
						<td><b>Enjoyable</b></td><td>". $row[7] ."</td>
					</tr>												
					<tr>
						<td><b>Book necessity</b></td><td>"; if($row[8] == 0) echo "Absolutely necessary"; else if($row[8] == 1) echo "Somewhat necessary"; else echo "Not necessary"; echo "</td>
					</tr>
					<tr>
						<td><b>Overall</b></td><td>". $row[10] ."</td>
					</tr>	
					<tr>
						<td><b>Comments</b></td><td>". $row[9] ."</td>
					</tr>												
				</tbody>
			</table>";	
	}
	
	function ManageReviewTable($dbc, $user){

		// Populate a table with the reviews the user currently has posted
		// **** THE SERVER CLOCK IS FAST BY 7 HOURS ****
		$qry = "SELECT * FROM Review " .
				"WHERE RecordStatus != '3' " .
				"AND UserID='$user' " .
				"ORDER BY PostID DESC;";
		$result = $dbc->query($qry);
		$row = $result->fetch_assoc();														

		if ($result->num_rows > 0) {
			$headers = array("Professor", "Course", "Edit");
			echo "<table class='table table-striped'>";
			// Display header
			echo "<thead>";
				foreach ($headers as $i) echo "<th>" .$i ."</th>";
			echo "</thead><tbody>";
	
			// Display rows
			while($row){			            																						
				echo "<tr>
					<td>" . $row['Professor'] . "</td>
					<td>" . $row['CourseDept'] . ' ' . $row['CourseNumber'] . "</td>
					<td>			
						<form class='form-inline' action='managepostsreviews.php' method='POST'>
							<input type='hidden' name='pid' id='pid' value='" . $row["PostID"] . "'>
							<input type='hidden' name='delete' id='delete' value='true'>												
							<a href='?edit=true&pid=" . $row['PostID'] . "' role='button' class='btn btn-primary' data-toggle='modal'>Edit</a>
							<input class='btn btn-danger' type='submit' value='Delete' >
						</form>	
					</td>							
				</tr>";		
				$row = $result->fetch_assoc(); 
				$count++;
			}
			echo "</tbody></table>";									
		}
		else {
			echo "You currently have no reviews pending";			
		}		
	}
	
	function DeleteReviewPost($pid, $user, $dbc){
		// Update the rideshare if the correct user is trying to remove the rideshare		
		if (isset($pid)){
			$qry = "UPDATE Review SET RecordStatus='3' WHERE PostID='$pid' AND UserID='$user';";
			$dbc->query($qry);
		}	
	}
	
	//
	function getSubmitErrors() {
		$courseNumber = $_POST['courseNumber'];
		$errorResults = array();
		
		if (
			isset($courseNumber) && 
			!empty($courseNumber) && (
				strlen($courseNumber) < 3 ||
				strlen($courseNumber) > 4 ||
				!is_numeric(substr($courseNumber,1,3)) ||
				(strlen($courseNumber) == 4 && is_numeric($courseNumber[3]))
			)
		) {
			array_push($errorResults,'courseNumber');
		}
		
		return $errorResults;
	}
?>
