<?php
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
							<h2>Your information has been submitted</h2>
							<?php
								// Get the post data
								$departureMonth = $_POST['departureMonth'];
								$departureDay = $_POST['departureDay'];															
								$departureYear = $_POST['departureYear'];
								$departureLocation = $_POST['departureLocation'];
								$departureThreshold = $_POST['departureThreshold'];
								
								$returnMonth = $_POST['returnMonth'];
								$returnDay = $_POST['returnDay'];															
								$returnYear = $_POST['returnYear'];
								
								$destinationLocation = $_POST['destinationLocation'];
								$destinationThreshold = $_POST['destinationThreshold'];								
															
								$numSeats = $_POST['numSeats'];
								$price = $_POST['price'];		
								
								// Convert the departure and return dates to store 
								$departureDate = formatDate($departureMonth, $departureDay, $departureYear);
								$returnDate = formatDate($returnMonth, $returnDay, $returnYear);
								
								// Write the information to the database
								// NEED TO GET THE ACTUAL POSTID, USERID, SOURCE/DEST LAT/LONG
								$sql = "INSERT INTO RideShare VALUES ('1', CURDATE(), 'username', '$departureDate', '$returnDate', '0.0', '0.0', '0.0', '0.0', '$departureThreshold', '$destinationThreshold', '$numSeats', '$numSeats', '$price', '0', '0', '1', CURDATE());";
								echo $sql;
								$connection->real_query($sql);																   								
								
								// Function to format date information into mysql DATETIME format
								function formatDate($m, $d, $y){
									$str = $y . "/" . $m . "/" . $d . " 00:00:00";	
									
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

