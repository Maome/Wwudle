<?php
	require_once('init.php');
	require_once('ridesharefunctions.php');
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
		<?php DisplayNavbar(basename(__FILE__)); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
						<?php
							ManagePostsNav(true);
							
							$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
							
							// Get the UserID
							$email = phpcas::GetUser() . "@students.wwu.edu";
							
							// Display all of the current rides that the user has posted 
							$qry = "SELECT UserID FROM User WHERE Email='$email';";
							$result = $dbc->query($qry);
							$row = $result->fetch_assoc();
							$UserID = $row['UserID'];

							// Populate a table with the rideshares the user currently has posted
							$qry = "SELECT * FROM RideShare WHERE UserID='$UserID' AND DepartureDate >= CURRENT_TIMESTAMP ORDER BY PostID DESC;";
							$result = $dbc->query($qry);
							$row = $result->fetch_assoc();														

							if ($result->num_rows > 0) {
								$headers = array("Leaving From", "Departing", "Departure Time", "Going To", "Return Date", "Return Time", "Price");
								echo "<table class='table table-striped'>";
									// Display header
									echo "<thead>";
										foreach ($headers as $i) echo "<th>" .$i ."</th>";
									echo "</thead><tbody>";
									
									// Display rows
									while($row){			            
									
										// Convert the date/time info
										$departDate = getDateFunc($row['DepartureDate']);
										$departTime = getTime($row['DepartureDate']);
										$returnDate = getDateFunc($row['ReturnDate']);
										$returnTime = getTime($row['ReturnDate']);																				
										
										echo "<tr>
											<td>" . $row['SourceCity'] . "</td>
											<td>" . $departDate . "</td>
											<td>" . $departTime . "</td>
											<td>" . $row['DestCity'] . "</td>
											<td>" . $returnDate . "</td>
											<td>" . $returnTime . "</td>
											<td>$" . $row['Price'] . "</td>							
										</tr>";																			
										
										$row = $result->fetch_assoc(); 
									}
									echo "</tbody></table>";
							}
							else echo "You currently have no rideshares pending";																																	
						?>
                </div>
            </div>
        </div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

