<?php
	require_once('init.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title><?php Woodle(); ?></title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="bootstrap/css/footer.css" rel="stylesheet">
    </head>
    <body>
		<div id="wrap">
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
									
									// Check if we are posting back
									if(isset($_POST['postback'])){
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
									else{
																					
										// Get the post data
										$PostID = $_GET['PostID'];
									
										$sql = "SELECT SourceCity, DestCity FROM RideShare WHERE PostID = '$PostID';";
										$result = $dbc->query($sql);
										$row = $result->fetch_row();
										$Source = $row[0];
										$Dest = $row[1];
									
										// Create a form to get the message
										echo "																												
					                         <form class='form-inline' action='ridesharerequest.php' method='post'>
					                         	<input type='hidden' name='postback' value='true'/>
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
        </div>
    	<?php DisplayFooter(); ?>
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

