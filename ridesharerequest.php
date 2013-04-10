<?php
	require_once('cassettings.php');
	require_once('includes/navbar.php');
	require_once('includes/sidebar.php');
	include_once("../../private_html/connect.php");
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
                        <div class="span6">

                            <!-- MAIN CONTENT FOR RIDEINFO -->
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
									// Get the post data
									$PostID = $_GET['PostID'];
									
									// Get the email for the person who posted the ride
									//$sql = "SELECT Email FROM User WHERE UserID = '$PostID';";
									//$result = $dbc->query($sql);
									//$row = $result->fetch_row();
									//$PostEmail = $row[0];
									
									$sql = "SELECT SourceCity, DestCity FROM RideShare WHERE PostID = '$PostID';";
									$result = $dbc->query($sql);
									$row = $result->fetch_row();
									$Source = $row[0];
									$Dest = $row[1];
									
									// Create a form to get the message
									echo "																												
			                            <form class='form-inline' action='ridesharerequestRCV.php' method='post'>
			                            	<div class='control-group'>
				                             	<label class='control-label' for='Subject'>Subject</label>
												<input class='field span12' type='text' name='Subject' id='Subject' value='Rideshare request from $Source to $Dest'> <br /><br />
												<label class='control-label' for='MessageBody'>Message</label>
				                            	<textarea class='field span12' rows='10' placeholder='Type your message here' name='MessageBody' id='MessageBody'></textarea><br /><br />
				                            	<input type='hidden' name='PostID' value='$PostID'>
				                                <button type='submit' class='btn btn-primary'>Request Ride</button>
			                                </div>
			                            </form>																				
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
</html>

