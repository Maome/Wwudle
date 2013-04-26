<?php
	require_once('init.php');
	require_once('reviewsfunctions.php');	
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Western List</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="bootstrap/css/datepicker.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-modal.css" rel="stylesheet">
		<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js'></script>
		<script>
		
		$(document).ready(function(){
			$("#EditReviewAjax").submit(function(){
				// Stop the from from submiting normally
				event.preventDefault();			
				
				// get the values from the elements on the page
				var values = $(this).serialize();
				
				// Send the data using post 
				$.ajax({
					type: "POST",
					url: "updatereview.php",
					data: values,
					success: function(msg){											
						location.reload();
					},
					error:function(){
						alert("An error has occured, please try again");
					}
				});
			});
		});			

	</script>
    </head>
    <body>
		
		<!-- Navbar -->
		<?php DisplayNavbar(basename(__FILE__)); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
					<?php
							ManagePostsNav(false, false);
							
							$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
							
							// Get the UserID
							$email = phpcas::GetUser() . "@students.wwu.edu";
							
							// Display all of the current rides that the user has posted 
							$qry = "SELECT UserID FROM User WHERE Email='$email';";
							$result = $dbc->query($qry);
							$row = $result->fetch_assoc();
							$UserID = $row['UserID'];

							// Populate a table with the rideshares the user currently has posted
							$qry = "SELECT * FROM Review WHERE UserID='$UserID';";
							$result = $dbc->query($qry);
							$row = $result->fetch_assoc();														

							if ($result->num_rows > 0) {
								$headers = array("Professor", "Course", "Workload", "Lecture Quality", "Test Relevance", "Relevance To Program", "Enjoyable", "Book Necessity", "Edit", "Delete");
								echo "<table class='table table-striped'>";
									// Display header
									echo "<thead>";
										foreach ($headers as $i) echo "<th>" .$i ."</th>";
									echo "</thead><tbody>";
									
									$count = 0;
									
									// Display rows
									while($row){	
										$workload = GetWorkload($row['Workload']);
										$booknec = GetBookNecessity($row['BookNecessity']);		            																			
										
										echo "<tr>
											<td>" . $row['Professor'] . "</td>
											<td>" . $row['CourseDept']. " " . $row['CourseNumber'] . "</td>
											<td>" . $workload . "</td>
											<td>" . $row['LectureQuality'] . "</td>
											<td>" . $row['TestRelevance'] . "</td>
											<td>" . $row['RelevanceToProgram'] . "</td>
											<td>" . $row['Enjoyable'] . "</td>
											<td>" . $booknec . "</td>
											<td><a href='#edit" . $count . "' role='button' class='btn btn-primary' data-toggle='modal'>Edit</a></td>
											<td><a href='#delete". $count ."' role='button' class='btn btn-danger' data-toggle='modal'>Delete</a></td>
										</tr>";		

										// Create a modal to edit the rideshare
										//include('reviewmodal.php');
										
										$row = $result->fetch_assoc(); 
										$count++;
									}
									echo "</tbody></table>";									
							}
							else echo "You currently have no reviews posted";																																	
						?>					
                </div>
            </div>
        </div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
	<script src="bootstrap/js/bootstrap-modal.js"></script>
	<script src="bootstrap/js/bootstrap-modalmanager.js"></script>
</html>

