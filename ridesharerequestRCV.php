<?php
	require_once('init.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title><?php Woodle(); ?></title>
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
                    <?php RideshareNav(true); ?>
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
									$PostID = $_POST['PostID'];
									$Subject = $_POST['Subject'];
									$MessageBody = $_POST['MessageBody'];
									
									// Get the email for the person who posted the ride
									$sql = "SELECT Email FROM User INNER JOIN RideShare ON User.UserID=RideShare.UserID WHERE RideShare.PostID='$PostID';";
									$result = $dbc->query($sql);
									$row = $result->fetch_row();
									$PostEmail = $row[0];
									
									// Constuct the email message
									$headers = 'From: ' . $username . "\r\n" .
									    'Reply-To: ' . $username . "\r\n" .
									    'X-Mailer: PHP/' . phpversion();									
						            mail($PostEmail,$Subject,$MessageBody,$headers);	
						            
									echo "<h2>Your email has been sent</h2>";																
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

