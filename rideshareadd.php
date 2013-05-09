<?php
	$isValid = true;
	$postback = $_POST['postback'];
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
	
	$today = date("Y-m-d H:i:s"); 
	$tempDDate = date("Y-m-d H:i:s", strtotime($departureDate));
	$tempRDate = date("Y-m-d H:i:s", strtotime($returnDate));																		
										
	// Check for the validation variables						
	// Check to departure date										
	if (isset($departureDate) && (($tempDDate < $today) || ($tempDDate > $tempRDate)))
	{
		// Date is before today
		$isValid = false;
		$dDateError = true;
		
	}
	// Check to return date
	if (isset($returnDate) && (($tempRDate > date('Y-m-d', strtotime("+3 months", strtotime($tempRDate)))) || ($tempRDate <= $tempDDate)))
	{
		// Date is before today
		$isValid = false;
		$rDateError = true;								
		
	}
	// Check the numSeats 
	if (isset($numSeats) && !is_numeric($numSeats))
	{
		$isValid = false;	
		$sError = true;
	}
	// Check the return price 
	if(isset($price) && !is_numeric($price)){
		$isValid = false;
		$pError = true;
	}	
	// Check the departure location	
	if(isset($departureLocation) && !preg_match(@"(^[\w\s]+,\s\w{2}$)", $departureLocation)){
		$isValid = false;
		$departLocError = true;		
	}
	// Check the destination location
	if(isset($destinationLocation ) && !preg_match(@"(^[\w\s]+,\s\w{2}$)", $destinationLocation)){
		$isValid = false;
		$destLocError = true;
	}																																							

	require_once('init.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Western List</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="bootstrap/css/datepicker.css" rel="stylesheet">
        <link href="bootstrap/css/footer.css" rel="stylesheet">
        <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>
        <script type="text/javascript">
		   	function initialize() {
			   	var options = {
				  types: ['(cities)'],
				  componentRestrictions: {country: "us"},				  
				};				
		      	var departInput = document.getElementById('departureLocation');
		      	var autocomplete = new google.maps.places.Autocomplete(departInput, options);
		      	
		      	var destInput = document.getElementById('destinationLocation');
		      	var autocomplete = new google.maps.places.Autocomplete(destInput, options);
		      	
		   }
		   google.maps.event.addDomListener(window, 'load', initialize);
		</script> 

	<script>
	      $(function(){
		    $("#departureLocation").popover({trigger: "focus", content: "It's so simple to create a tooltop for my website!"});
	      });
	</script>
    </head>
    <body>
		<div id="wrap">
			<!-- Navbar -->
			<?php DisplayNavbar("rideshare.php"); ?>			
		     <div class="container">
		         <div class="row-fluid">
					<!-- Sidebar -->
					<?php DisplaySidebar(); ?>
		             <div class="span9">
		                 <div class="row-fluid">
							<?php RideshareNav(false); ?>                    
		                     <div class="span9">						
		                         <!-- MAIN CONTENT FOR RIDESHARES -->
								<?php 														
									// If everything is valid, write the rideshare to the database
									if($isValid && $postback){
										$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
									
										// Get the user
										$username = PHPCAS::GetUser();			
										$username = $username . "@students.wwu.edu";
										$sql = "Select * from User where Email = '$username';";
										$result = $dbc->query($sql);									
										$getData = $result->fetch_row();									
										$UserID = $getData[0];		
																	
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
									// Else display the form
									else {							
								?>
									<form class="form-horizonal" name="addRideShare" id="addRideShare" action="rideshareadd.php" method="post">
										<input type="hidden" name="postback" value="true"/>
										<?php
										if($dDateError == true && !$isValid){ 										
											echo '<div class="control-group warning">';
											} 
										else echo '<div class="control-group ">';?> 		
										<label class="control-label" for="departureDate">Departing</label>
										<div class="controls">																				
											<input id="departureDate" name="departureDate" type="text" value="<?php if(isset($departureDate)){echo $departureDate;} else echo date('m/d/Y', strtotime("+1 days")); ?>" data-date-format="mm/dd/yyyy" class="datepicker">
											<?php 
											if($dDateError == true && !$isValid){
												echo '<span class="help-inline">Please enter a valid departing date</span>';}
											?>	
										</div>							
										</div>
										<div class="control-group">
											<label class="control-label" for="departureDate">Departure Time</label>
												 <div class="controls input-prepend">
													<?php	
														// Hour										    
														 echo "<select id='departureHour' name='departureHour' style='width:60px'>";
														 for ($h = 1; $h <= 12; $h++) {
														echo "<option value='$h'>$h</option>";
														 }
														 echo "</select> : ";											    
														 
														 // Minute
														 echo "<select id='departureMinute' name='departureMinute' style='width:60px'>";
														 for ($m = 00; $m <= 59; $m++) {
														 	// Add the leading 0
														 	if ($m < 10){
														 		$m = '0' . $m;
														 	}											    
															echo "<option value='$m'>$m</option>";
														 }
														 echo "</select>";
														 
														 // AM/PM
														echo "<select id='departureAMPM' name='departureAMPM' style='width:75px'>";
														echo "<option value='AM'>AM</option>";
														echo "<option value='PM'>PM</option>";
														 echo "</select>";
													?>
												 </div>
											</div>
											<?php
											if($departLocError == true && !$isValid){ 										
												echo '<div class="control-group warning">';
												} 
											else echo '<div class="control-group ">';?> 		
											<label class="control-label" for="departureLocation">Leaving From</label>
											<div class="controls">										
												<div class="controls">
												<input id="departureLocation" name="departureLocation" type="text"autocomplete="on" rel="popover" value="<?php if(isset($departureLocation)){echo $departureLocation;} else echo "Bellingham, WA"; ?>"/>
												<?php 
												if($departLocError == true && !$isValid){
													echo '<span class="help-inline">Please enter a valid city</span>';}
												?>
											</div>
											</div>
											</div>									
											<?php
											if($rDateError == true && !$isValid){ 										
												echo '<div class="control-group warning">';
												} 
											else echo '<div class="control-group ">';?> 		
											<label class="control-label" for="returnDate">Returning</label>
											<div class="controls">																				
												<input id="returnDate" name="returnDate" type="text" value="<?php if(isset($returnDate)){echo $returnDate;} else echo date('m/d/Y', strtotime("+2 days")); ?>" data-date-format="mm/dd/yyyy" class="datepicker">
												<?php 
												if($rDateError == true && !$isValid){
													echo '<span class="help-inline">Please enter a valid return date</span>';}
												?>	
											</div>							
											</div>																																																									
										<div class="control-group">
											<label class="control-label" for="destinationDate">Return Time</label>
												 <div class="controls input-prepend">
													<?php	
														// Hour										    
														 echo "<select id='returnHour' name='returnHour' style='width:60px'>";
														 for ($h = 1; $h <= 12; $h++) {
															echo "<option value='$h'>$h</option>";
														 }
														 echo "</select> : ";											    
														 
														 // Minute
														 echo "<select id='returnMinute' name='returnMinute' style='width:60px'>";
														 for ($m = 00; $m <= 59; $m++) {
														 	// Add the leading 0
														 	if ($m < 10){
														 		$m = '0' . $m;
														 	}
															echo "<option value='$m'>$m</option>";
														 }
														 echo "</select>";
														 
														 // AM/PM
														echo "<select id='returnAMPM' name='returnAMPM' style='width:75px'>";
														echo "<option value='AM'>AM</option>";
														echo "<option value='PM'>PM</option>";
														 echo "</select>";
													?>
												 </div>
											</div>	
											<?php
											if($destLocError == true && !$isValid){ 										
												echo '<div class="control-group warning">';
												} 
											else echo '<div class="control-group ">';?> 		
											<label class="control-label" for="destinationLocation">Going To</label>
											<div class="controls">										
												<div class="controls">
												<input id="destinationLocation" name="destinationLocation" type="text" autocomplete="on" value="<?php echo $destinationLocation; ?>"/>
												<?php 
												if($destLocError == true && !$isValid){
													echo '<span class="help-inline">Please enter a valid city</span>';}
												?>																																					
											</div>
											</div>
											</div>
											<?php
											if($sError == true && !$isValid){ 										
												echo '<div class="control-group warning">';
												} 
											else echo '<div class="control-group ">';?> 		
											<label class="control-label" for="numSeats">Number of Seats</label>
											<div class="controls">										
												<input id="numSeats" name="numSeats" type="text" placeholder="Enter number of empty seats" value="<?php echo $numSeats; ?>"/>
												<?php 
												if($sError == true && !$isValid){
													echo '<span class="help-inline">Please enter the number of empty seats in your vehicle</span>';}
												?>
											</div>
										
											<?php 
											if($pError == 1 && !$isValid){ 																				
												echo '<div class="control-group warning">';
											} 
											else echo '<div class="control-group ">';?> 		
											<label class="control-label" for="price">Price</label>
											<div class="controls">										
												<input id="price" name="price" type="text" placeholder="Enter price per person" value="<?php echo $price; ?>"/>
												<?php 
												if($pError == 1 && !$isValid){
													echo '<span class="help-inline">Please enter a valid price</span>';
													}
												
												?>
											</div>
											</div>
											<div class="control-group"> 		
											<div class="controls">
												<button type="submit" id="validate" class="button btn btn-primary" onClick="Validate()">Submit</button>										
											</div>
										</div>														
									</form>			
									<?php } 
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
         </div>
        </div>
    	<?php DisplayFooter(); ?>
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/js/bootstrap-datepicker.js"></script>
    <script>$('.datepicker').datepicker();</script>
</html>

