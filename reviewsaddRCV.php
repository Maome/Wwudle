<?php
	require_once('init.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Western List</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    </head>
    <body>

		<!-- Navbar -->
		<?php DisplayNavbar("courses.php"); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
                    <?php ReviewNav(false) ?>
                        <div class="span6">
                       		<?php
		              				$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
		              				
		              				// Check to see if user is logged on/Valid user
										$username = PHPCAS::GetUser();
								
										// See if the user is in the Users table
										$username = $username . "@students.wwu.edu";
										$sql = "Select * from User where Email = '$username';";
										$result = $dbc->query($sql);								
										// Check if the name is in the table
										$rows = $result->num_rows;																					
								
										if ($rows == 0) {
											echo "<h2>You must log in!</h2>";
										}
										else{						
											// Set the user id
											$getData = $result->fetch_row();									
											$UserID = $getData[0];									
											// Get the post data
											$CourseDept = $_POST['courseDept'];									
											$CourseNumber = $_POST['courseNumber'];
											$Professor = $_POST['professor'];
											$Workload = $_POST['workload'];
											$LectureQuality = number_format($_POST['lectureQuality'], 2);
											$TestRelevance = number_format($_POST['testRelevance'], 2);							
											$RelevanceToProgram = number_format($_POST['relevanceToProgram'], 2);
											$Enjoyable = number_format($_POST['enjoyable'], 2);
											$BookNecessity = $_POST['bookNecessity'];			
											$Overall = number_format((($LectureQuality + $TestRelevance + $RelevanceToProgram + $Enjoyable) / 4), 2);
											$Comments = $_POST['comments'];										
																		
											// Validate the data									
											//$isValid = true;
											
											//if($isValid) {
												$sql = "INSERT INTO Review (PostDate, UserID, CourseDept, CourseNumber, Professor, Workload, LectureQuality, TestRelevance, RelevanceToProgram, Enjoyable, BookNecessity, Overall, Comments, ViewCount, ChangeSource, RecordStatus, RecordStatusDate) VALUES (CURDATE(), $UserID, '$CourseDept', '$CourseNumber', '$Professor', $Workload, $LectureQuality, $TestRelevance, $RelevanceToProgram, $Enjoyable, $BookNecessity, $Overall, '$Comments', 0, 0, 1, CURDATE());"; 
												//$dbc->setDebug(true);
												$dbc->query($sql);
											//}
											
											echo "<h3>Your information has been submitted</h3>";
										
											// Show the user all of the info that has been recieved 
											echo "
												<table id='table_id' class='table table-striped'>
													<tbody>
														<tr>
															<td><b>Course</b></td><td>$CourseDept $CourseNumber</td>
														</tr>
														<tr>
															<td><b>Professor</b></td><td>$Professor</td>
														</tr>
														<tr>
															<td><b>Workload</b></td><td>"; if($Workload == 0) echo "Light"; else if($Workload == 1) echo "Moderate"; else echo "Heavy"; echo "</td>
														</tr>
														<tr>
															<td><b>Lecture Quality</b></td><td>$LectureQuality</td>
														</tr>
														<tr>
															<td><b>Test Relevance</b></td><td>$TestRelevance</td>
														</tr>
														<tr>
															<td><b>Relevance To Program</b></td><td>$RelevanceToProgram</td>
														</tr>
														<tr>
															<td><b>Enjoyable</b></td><td>$Enjoyable</td>
														</tr>												
														<tr>
															<td><b>Book necessity</b></td><td>"; if($BookNecessity == 0) echo "Absolutely necessary"; else if($BookNecessity == 1) echo "Somewhat necessary"; else echo "Not necessary"; echo "</td>
														</tr>
														<tr>
															<td><b>Overall</b></td><td>$Overall</td>
														</tr>	
														<tr>
															<td><b>Comments</b></td><td>$Comments</td>
														</tr>												
													</tbody>
												</table>
																			
											";											
										}
		               		?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/raty/jquery.raty.js"></script>    
    <script src="bootstrap/raty/jquery.raty.min.js"></script>
</html>

