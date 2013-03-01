<?php
	require_once('cassettings.php');
	require_once('includes/navbar.php');
	require_once('includes/sidebar.php');
	include_once("../../private_html/connect.php");
?>
<html>
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

                            <!-- MAIN CONTENT FOR RIDESHARES -->
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
									$departureMonth = $_POST['departureMonth'];
									$departureDay = $_POST['departureDay'];															
									$departureYear = $_POST['departureYear'];
									
									$departureHour = $_POST['departureHour'];
									$departureMinute = $_POST['departureMinute'];
									$departureAMPM = $_POST['departureAMPM'];
									
									$departureLocation = $_POST['departureLocation'];
									$departureThreshold = $_POST['departureThreshold'];
									
									$returnMonth = $_POST['returnMonth'];
									$returnDay = $_POST['returnDay'];															
									$returnYear = $_POST['returnYear'];
									
									$returnHour = $_POST['returnHour'];
									$returnMinute = $_POST['returnMinute'];															
									$returnAMPM = $_POST['returnAMPM'];
									
									
									$destinationLocation = $_POST['destinationLocation'];
									$destinationThreshold = $_POST['destinationThreshold'];								
																
									$numSeats = $_POST['numSeats'];
									$price = $_POST['price'];		
									
									// Convert the departure and return dates to store 
									$departureDate = formatDate($departureMonth, $departureDay, $departureYear, $departureHour, $departureMinute, $departureAMPM);
									$returnDate = formatDate($returnMonth, $returnDay, $returnYear, $returnHour, $returnMinute, $returnAMPM);
									
									// Write the information to the database
									// NEED TO GET THE ACTUAL USERID, SOURCE/DEST LAT/LONG
									$sql = "INSERT INTO RideShare (PostDate, UserID, DepartureDate, ReturnDate, SourceLatitude, SourceLongitude, DestLatitude, DestLongitude, SourceThresholdMiles, DestThresholdMiles, SeatsRemaining, MaxSeats, Price,  ViewCount, ChangeSource, RecordStatus, RecordStatusDate) VALUES (CURDATE(), 1, '$departureDate', '$returnDate', 0.0, 0.0, 0.0, 0.0, $departureThreshold, $destinationThreshold, $numSeats, $numSeats, $price, 0, 0, 1, CURDATE());"; 
	
									//echo $sql;
									$connection->real_query($sql);

									echo "<h2>Your information has been submitted</h2>";									
								}																   								
								
								// Function to format date information into mysql DATETIME format
								function formatDate($m, $d, $y, $hour, $min, $ampm){
								
									// if the time is PM, we have to convert to the 24 hour format
									if ($ampm == 'PM'){
										$hour = 12 + $hour;
									}
									
									$str = $y . "/" . $m . "/" . $d . " $hour" . ":" . "$min" . ":00";	
									
									$date = date('Y-m-d H:i:s', strtotime($str));
									
									return $date;
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

