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
		<?php DisplayNavbar(basename("rideshare.php")); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
                    <?php RideshareNav(false); ?>
                        <div class="span7">

                            <!-- MAIN CONTENT FOR RIDESHARES -->
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
									$departureDate = $_POST['departureDate'];									
									$departureHour = $_POST['departureHour'];
									$departureMinute = $_POST['departureMinute'];
									$departureAMPM = $_POST['departureAMPM'];
									
									$departureLocation = $_POST['departureLocation'];								
									
									$returnDate = $_POST['returnDate'];
									$returnHour = $_POST['returnHour'];
									$returnMinute = $_POST['returnMinute'];			
									$returnAMPM = $_POST['returnAMPM'];									
									
									$destinationLocation = $_POST['destinationLocation'];
																
									$numSeats = $_POST['numSeats'];
									$price = $_POST['price'];		
																		
									// Validate the data									
									$isValid = true;
										
									// Check to departure date									
									if (!isset($departureDate) || ($departureDate <= $today) || ($departureDate > $returnDate))
									{
										// Date is before today
										$isValid = false;
										echo "Departure date cannot be before today or the return date <br />";
									}
									// Check to return date
									if (!isset($returnDate) || ($returnDate > date('Y-m-d', strtotime("+3 months", strtotime($returnDate)))) || ($returnDate < $departureDate))
									{
										// Date is before today
										$isValid = false;
										echo "Return date must be within 3 months, and after the departure date <br />";
									}
									// Check the numSeats 
									if (!isset($numSeats) || !is_numeric($numSeats))
									{
										$isValid = false;
										echo "Please enter a valid number of seats <br />";
									}
									// Check the return price 
									if (!isset($price) || !is_numeric($price ))
									{
										$isValid = false;
										echo "Please enter a valid price <br />";
									}

									
  
  									if ($isValid)
  									{
  										// Convert the departure and return dates to store 
  										$departureDate = $departureDate . " " . $departureHour . ":" . $departureMinute . ":00" .  $departureAMPM;
  										$returnDate = $returnDate . " " . $returnHour . ":" . $returnMinute . ":00" .  $returnAMPM;
										$departureDate = formatDate($departureDate);
										$returnDate = formatDate($returnDate);																				
									
										// Write the information to the database
										// NEED TO GET THE ACTUAL USERID, SOURCE/DEST LAT/LONG
										$sql = "INSERT INTO RideShare (PostDate, UserID, DepartureDate, ReturnDate, SourceLatitude, SourceLongitude, SourceCity, DestLatitude, DestLongitude, DestCity, SeatsRemaining, MaxSeats, Price,  ViewCount, ChangeSource, RecordStatus, RecordStatusDate) VALUES (CURDATE(), $UserID, '$departureDate', '$returnDate', 0.0, 0.0, '$departureLocation', 0.0, 0.0, '$destinationLocation', $numSeats, $numSeats, $price, 0, 0, 1, CURDATE());"; 
										$dbc->query($sql);

										$departureTime = getTime($departureDate);
										$returnTime = getTime($returnDate);
										$departureDate = getDateFunc($departureDate);
										$returnDate = getDateFunc($returnDate);
										
	
										echo "<h3>Your information has been submitted</h3>";
										
										// Show the user all of the info that has been recieved 
										echo "
											<table id='table_id' class='table table-striped'>
												<tbody>
													<tr>
														<td><b>Departure Date</b></td><td>$departureDate</td>
													</tr>
													<tr>
														<td><b>Departure Time</b></td><td>$departureTime</td>
													</tr>
													<tr>
														<td><b>Departure Location</b></td><td>$departureLocation</td>
													</tr>
													<tr>
														<td><b>Return Date</b></td><td>$returnDate</td>
													</tr>
													<tr>
														<td><b>Return Time</b></td><td>$returnTime</td>
													</tr>
													<tr>
														<td><b>Destination Location</b></td><td>$destinationLocation</td>
													</tr>
													<tr>
														<td><b>Seats</b></td><td>$numSeats</td>
													</tr>												
													<tr>
														<td><b>Price</b></td><td>$$price</td>
													</tr>													
												</tbody>
											</table>
																			
										";											
									}
								}																   								
								
								// Function to format date information into mysql DATETIME format
								function formatDate($d){									
									$date = date('Y-m-d H:i:s', strtotime($d));									
									return $date;
								}
								
								// Function to get the time from DATETIME
								function getTime($fromMYSQL){									
									return date("g:i A", strtotime($fromMYSQL));
								}		
								function getDateFunc($fromMYSQL){
									return date("F jS, Y", strtotime($fromMYSQL));
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

