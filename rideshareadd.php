<?php
	require_once('init.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Western List</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="bootstrap/css/datepicker.css" rel="stylesheet">
	<link href="bootstrap/validaty/jquery.validaty.css" rel="stylesheet">
    </head>
    <body>

		<!-- Navbar -->
		<?php DisplayNavbar("rideshare.php"); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
						<?php RideshareNav(false); ?>                    
                        <div class="span4">

                            <!-- MAIN CONTENT FOR RIDESHARES -->
							<!-- <h2>Rideshare</h2>	-->													
							<form class="form-horizontal" name="addRideShare" id="addRideShare" action="rideshareaddRCV.php" method="post">																				
								<div class="control-group">
									<label class="control-label" for="departureDate">Departing</label>
									    <div class="controls input-prepend">
                                            <input id="departureDate" name="departureDate" type="text" value="<?php echo date('m/d/Y'); ?>" data-date-format="mm/dd/yyyy" class="datepicker">
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
									<label class="control-label" for="departureLocation">Leaving From</label>
										<div class="controls">
											<input id="departureLocation" name="departureLocation" type="text" value="Bellingham" data-validaty="required" data-source='
											["Seattle", "Tacoma", "Spokane", "Bellevue", "Olympia", "Everett", "Vancouver", "Renton", "Bellingham", "Redmond", "Kirkland", "Puyallup", "Federal Way", "Kent", "Lynnwood", "Bremerton", "Bothell", "Yakima", "Issaquah", "Kennewick", "Auburn", "Marysville", "Lakewood", "Edmonds", "Wenatchee", "Gig Harbor", "Tri-Cities", "Pasco", "Woodinville", "Richland", "Mercer Island", "Anacortes", "Shoreline", "Port Angeles", "Tukwila", "Lacey", "Burien", "Forks", "Port Townsend", "Mount Vernon", "Walla Walla", "Sammamish", "Leavenworth", "Port Orchard", "Poulsbo", "Fort Lewis", "Ellensburg", "Sequim", "Spokane Valley", "Mukilteo"]'
											data-items="4" data-provide="typeahead" style="margin: 0 auto;"></input>
											<!--<input id="departureLocation" name="departureLocation" type="text" data-validaty="required">-->
										</div>
									</div>																		
									
									<div class="control-group"> 		
									<label class="control-label" for="returnDate">Returning</label>
									    <div class="controls input-prepend">
                                            <input id="returnDate" name="returnDate" type="text" value="<?php echo date('m/d/Y'); ?>" data-date-format="mm/dd/yyyy"class="datepicker">                                            
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
									<label class="control-label" for="destinationLocation">Going To</label>
									<div class="controls">
										<input id="destinationLocation" name="destinationLocation" type="text" data-validaty="required" data-source='
											["Seattle", "Tacoma", "Spokane", "Bellevue", "Olympia", "Everett", "Vancouver", "Renton", "Bellingham", "Redmond", "Kirkland", "Puyallup", "Federal Way", "Kent", "Lynnwood", "Bremerton", "Bothell", "Yakima", "Issaquah", "Kennewick", "Auburn", "Marysville", "Lakewood", "Edmonds", "Wenatchee", "Gig Harbor", "Tri-Cities", "Pasco", "Woodinville", "Richland", "Mercer Island", "Anacortes", "Shoreline", "Port Angeles", "Tukwila", "Lacey", "Burien", "Forks", "Port Townsend", "Mount Vernon", "Walla Walla", "Sammamish", "Leavenworth", "Port Orchard", "Poulsbo", "Fort Lewis", "Ellensburg", "Sequim", "Spokane Valley", "Mukilteo"]'
											data-items="4" data-provide="typeahead" style="margin: 0 auto;"></input>
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
										<button type="submit" class="button btn btn-primary">Submit
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
    <script src="bootstrap/validaty/jquery.validaty.js"></script>
    <script src="bootstrap/validaty/jquery.validaty.min.js"></script>
    <script src="bootstrap/validaty/jquery.validaty.validators.js"></script>
    <script>
	$(document).ready(function(){
		
		$('.form').validaty();
		      $('.button').on('click', function() {
        $(this).parent('form').validaty('validate');
      });
	)};
    </script>
</html>

