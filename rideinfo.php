<?php
	require_once('cassettings.php');
	require_once('includes/navbar.php');
	require_once('includes/sidebar.php');
	include_once("../../private_html/connect.php");
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Wlist</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    </head>
    <body>

       <!-- Modal -->
        <div id="loginModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-body">
                <p>Oops I'm broken..</p>
            </div>
        </div>


		<!-- Navbar -->
		<?php DisplayNavbar(basename(__FILE__)); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
                        <div class="span4">

                            <!-- MAIN CONTENT FOR RIDEINFO -->
							<?php
								// Check to see if user is logged on/Valid user
								$username = PHPCAS::GetUser();
								
								// See if the user is in the Users table
								$username = $username . "@students.wwu.edu";
								$sql = "Select * from User where Email = '$username';";
								$result = $connection->prepare($sql);
								$result->execute();
								$result->store_result();
								
								// Check if the name is in the table
								$rows = $result->num_rows;					
								
								if ($rows == 0) {
									echo "<h2>You must log in!</h2>";
								}
								else{															
									// Get the post data
									$PostID = $_GET['PostID'];
									
									// Get the information about this rideshare
			                    	$sql = "SELECT DepartureDate, SourceCity, DestCity, ReturnDate, SeatsRemaining, Price, PostID FROM RideShare WHERE PostID=$PostID";
			                    	$connection->multi_query($sql);
			                    	$result = $connection->store_result();
			                    	$row = $result->fetch_row();									
			                    	
			                    	// Convert the date 
			                    	$departureDate = getDateFunc($row[0]);
			                    	$departureTime = getTime($row[0]);
			                    	
			                    	$returnDate = getDateFunc($row[3]);
			                    	$returnTime = getTime($row[3]);

																		
									// Show the user all of the info that has been recieved 
									echo "
										<p><b>Departure Date:</b> $departureDate</p>
										<p><b>Departure Time:</b> $departureTime</p>
										<p><b>Departure Location:</b> $row[1]</p>
										
										<p><b>Return Date:</b> $returnDate</p>
										<p><b>Return Time:</b> $returnTime</p>
										<p><b>Destination Location:</b> $row[2]</p>
										
										<p><b>Seats Remaining:</b> $row[4]</p>
										<p><b>Price:</b> $$row[5]</p>																			
									";
																		
								}																   								
								
								// Function to get the date from DATETIME
								function getDateFunc($fromMYSQL){
									return date("F jS, Y", strtotime($fromMYSQL));
								}
								
								// Function to get the time from DATETIME
								function getTime($fromMYSQL){									
									return date("g:i A", strtotime($fromMYSQL));
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
</html>
