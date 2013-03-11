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
        <link href="bootstrap/css/datepicker.css" rel="stylesheet">
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
							<h2>Rideshare</h2>
							<form class="form-horizontal" name="addRideShare" action="rideshareaddRCV.php" method="post">
								<div class="control-group">
									<label class="control-label" for="departureDate">Departure Date</label>
									    <div class="controls input-prepend">
                                            <input id="departdate" type="text" value="02-16-2012" data-date-format="mm-dd-yyyy"class="datepicker">
									    	<!--<span class="add-on">Month</span>-->

                                            <?php  /*
											    $months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
											    echo "<select id='departureMonth' name='departureMonth' style='width:115px'>";
											    for ($month = 1; $month <= 12; $month++) {
												echo "<option value='$month'>$months[$month]</option>";
											    }
											    echo "</select>";
											?>
									    	<span class="add-on">Day</span>
											<?php
											    echo "<select id='departureDay' name='departureDay' style='width:60px'>";
											    for ($day = 1; $day <= 31; $day++) {
												echo "<option value='$day'>$day</option>";
											    }
											    echo "</select>";
											?>
									    	<span class="add-on">Year</span>
											<?php
											    echo "<select id='departureYear' name='departureYear' style='width:75px'>";
											    for ($year = 2013; $year <= 2015; $year++) {
												echo "<option value='$year'>$year</option>";
											    }
											    echo "</select>";
                                             */ ?>
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
									<div class="control-group">    
									<label class="control-label" for="departureLocation">Departure Location</label>
										<div class="controls">
											<input id="departureLocation" name="departureLocation" type="text">
										</div>
									</div>
									<div class="control-group"> 
									<label class="control-label" for="departureThreshold">Departure Threshold</label>
										<div class="controls">
											<input id="departureThreshold" name="departureThreshold" type="text">
										</div>
									</div>
									<div class="control-group"> 		
									<label class="control-label" for="returnDate">Return Date</label>
									    <div class="controls input-prepend">
                                            <input id="returndate" type="text" value="02-16-2012" data-date-format="mm-dd-yyyy"class="datepicker">
									    	<!--<span class="add-on">Month</span>-->
										<?php/*
										    $months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
										    echo "<select id='returnMonth' name='returnMonth' style='width:115px'>";
										    for ($month = 1; $month <= 12; $month++) {
											echo "<option value='$month'>$months[$month]</option>";
										    }
										    echo "</select>";
										?>
									    	<span class="add-on">Day</span>
										<?php
										    echo "<select id='returnDay' name='returnDay' style='width:60px'>";
										    for ($day = 1; $day <= 31; $day++) {
											echo "<option value='$day'>$day</option>";
										    }
										    echo "</select>";
										?>
									    	<span class="add-on">Year</span>
										<?php
										    echo "<select id='returnYear' name='returnYear' style='width:75px'>";
										    for ($year = 2013; $year <= 2015; $year++) {
											echo "<option value='$year'>$year</option>";
										    }
										    echo "</select>";
                                         */?>
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
									<div class="control-group"> 		
									<label class="control-label" for="destinationLocation">Destination Location</label>
									<div class="controls">
										<input id="destinationLocation" name="destinationLocation" type="text">
									</div>
									</div>
									<div class="control-group"> 		
									<label class="control-label" for="destinationThreshold">Destination Threshold</label>
									<div class="controls">
										<input id="destinationThreshold" name="destinationThreshold" type="text">
									</div>
									</div>
									<div class="control-group"> 								
									<label class="control-label" for="numSeats">Number of Seats</label>
									<div class="controls">
										<input id="numSeats" name="numSeats" type="text">
									</div>
									</div>
									<div class="control-group"> 		
									<label class="control-label" for="price">Price</label>
									<div class="controls">
										<input id="price" name="price" type="text">
									</div>
									</div>
									<div class="control-group"> 		
									<div class="controls">
										<button class="btn" type="submit">Submit
										</button></div>
								</div>
							</form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/js/bootstrap-datepicker.js"></script>
                                            <script>$('.datepicker').datepicker();</script>

</html>

