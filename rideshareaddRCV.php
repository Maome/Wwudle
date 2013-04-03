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
									$departureDate = $_POST['departureDate'];									
									$departureHour = $_POST['departureHour'];
									$departureMinute = $_POST['departureMinute'];
									$departureAMPM = $_POST['departureAMPM'];
									
									$departureLocation = $_POST['departureLocation'];
									$departureThreshold = $_POST['departureThreshold'];							
									
									$returnDate = $_POST['returnDate'];
									$returnHour = $_POST['returnHour'];
									$returnMinute = $_POST['returnMinute'];			
									$returnAMPM = $_POST['returnAMPM'];									
									
									$destinationLocation = $_POST['destinationLocation'];
									$destinationThreshold = $_POST['destinationThreshold'];								
																
									$numSeats = $_POST['numSeats'];
									$price = $_POST['price'];		
																		
									// Validate the data									
									$isValid = true;
										
									// Check to departure date
									if (strtotime($departureDate) < strtotime('now'))
									{
										// Date is before today
										$isValid = false;
										echo "Departure date must be after today";
									}
									// Check the departure threshhold
									if (!is_numeric($departureThreshold))
									{
										$isValid = false;
										echo "Please enter a valid departure threshold";
									}
									// Check to return date
									if (strtotime($returnDate) > strtotime('+3 months'))
									{
										// Date is before today
										$isValid = false;
										echo "Return date must be within 3 months";
									}
									// Check the return threshhold
									if (!is_numeric($destinationThreshold))
									{
										$isValid = false;
										echo "Please enter a valid destination threshold";
									}
									// Check the numSeats 
									if (!is_numeric($numSeats))
									{
										$isValid = false;
										echo "Please enter a valid number of seats";
									}
									// Check the return price 
									if (!is_numeric($price ))
									{
										$isValid = false;
										echo "Please enter a valid price";
									}

									
  
  									if ($isValid)
  									{
  										// Convert the departure and return dates to store 
										$departureDate = formatDate($departureDate);
										$returnDate = formatDate($returnDate);

									
										// Write the information to the database
										// NEED TO GET THE ACTUAL USERID, SOURCE/DEST LAT/LONG
										$sql = "INSERT INTO RideShare (PostDate, UserID, DepartureDate, ReturnDate, SourceLatitude, SourceLongitude, SourceCity, DestLatitude, DestLongitude, DestCity, SourceThresholdMiles, DestThresholdMiles, SeatsRemaining, MaxSeats, Price,  ViewCount, ChangeSource, RecordStatus, RecordStatusDate) VALUES (CURDATE(), 1, '$departureDate', '$returnDate', 0.0, 0.0, '$departureLocation', 0.0, 0.0, '$destinationLocation', $departureThreshold, $destinationThreshold, $numSeats, $numSeats, $price, 0, 0, 1, CURDATE());"; 
										$connection->real_query($sql);
	
										echo "<h3>Your information has been submitted</h3>";
										
										// Show the user all of the info that has been recieved 
										echo "
											<p><b>Departure Date:</b> $departureDate</p>
											<p><b>Departure Time:</b> $departureHour:$departureMinute $departureAMPM</p>
											<p><b>Departure Location:</b> $departureLocation</p>
											
											<p><b>Return Date:</b> $returnDate</p>
											<p><b>Return Time:</b> $returnHour:$returnMinute $returnAMPM</p>
											<p><b>Destination Location:</b> $destinationLocation</p>
											
											<p><b>Seats:</b> $numSeats</p>
											<p><b>Price:</b> $price</p>																			
										";											
									}
								}																   								
								
								// Function to format date information into mysql DATETIME format
								function formatDate($d){									
									//$str = $y . "/" . $m . "/" . $d . " $hour" . ":" . "$min" . ":00";	
									
									$date = date('Y-m-d H:i:s', strtotime($d));
									
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

