<?php
// Modal for the rideshare
	
	echo '
		<div id="edit' . $count . '" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">Edit Rideshare</h3>
			</div>
			<div class="modal-body">											
			
				<form class="form-horizontal" name="EditRideshareAjax" id="EditRideshareAjax" action="managepostsrides.php" method="POST">	
					<input type="hidden" name="PostID" id="PostID' . $count . '" value="' . $row['PostID'] . '">
					<input type="hidden" name="Edit" id="Edit" value="true">
					<div class="control-group">
						<label class="control-label" for="departureDate">Departure Date</label>
						<div class="controls input-prepend">
							<input id="departureDate' . $count . '" name="departureDate" type="text" value="' . $departDate . '" data-date-format="mm/dd/yyyy" class="datepicker">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="departureDate">Departure Time</label>
						<div class="controls input-prepend">
									
							// Hour										    
							<select id="departureHour' . $count . '" name="departureHour" style="width:60px"> ';
							for ($h = 1; $h <= 12; $h++) {
								if($h == GetHour($row['DepartureDate'])){
									echo "<option value='$h' selected='selected'>$h</option>";
								}
								else{
									echo "<option value='$h'>$h</option>";
								}
							}
							echo "</select> : ";											    
							
							// Minute
							echo "<select id='departureMinute" . $count . "' name='departureMinute' style='width:60px'>";
							for ($m = 00; $m <= 59; $m++) {
								// Add the leading 0
								if ($m < 10){
									$m = '0' . $m;
								}											    
								if ($m == GetMinute($row['DepartureDate'])){
									echo "<option value='$m' selected='selected'>$m</option>";
								}
								else{
									echo "<option value='$m'>$m</option>";
								}
							}
							echo "</select>";
							
							// AM/PM
							echo "<select id='departureAMPM" . $count . "' name='departureAMPM' style='width:75px'>";
							if (GetAMPM($row['DepartureDate']) == "AM"){
								echo "<option value='AM' selected='selected'>AM</option>";
								echo "<option value='PM'>PM</option>";
							}
							else{
								echo "<option value='AM'>AM</option>";
								echo "<option value='PM' selected='selected'>PM</option>";
							}	
							echo "</select>";
							echo '
						</div>
					</div>
					<div class="control-group">    
					<label class="control-label" for="departureLocation">Departure Location</label>
						<div class="controls">
							<input id="departureLocation' . $count . '" name="departureLocation" type="text" value="' . $row['SourceCity'] . '" data-validaty="required">
						</div>
					</div>
																										
					<div class="control-group"> 		
					<label class="control-label" for="returnDate">Return Date</label>
						<div class="controls input-prepend">
							<input id="returnDate' . $count . '" name="returnDate" type="text" value="' . $returnDate . '" data-date-format="mm/dd/yyyy"class="datepicker">                                            
						</div>    							
					</div>
					<div class="control-group">
						<label class="control-label" for="destinationDate">Return Time</label>
						<div class="controls input-prepend">															
							// Hour										    
							<select id="returnHour' . $count . '" name="returnHour" style="width:60px">';
							for ($h = 1; $h <= 12; $h++) {
								if($h == GetHour($row['ReturnDate'])){
									echo "<option value='$h' selected='selected'>$h</option>";
								}
								else{
									echo "<option value='$h'>$h</option>";
								}
							}
							echo "</select> : ";											    
							
							// Minute
							echo "<select id='returnMinute" . $count . "' name='returnMinute' style='width:60px' >";
							for ($m = 00; $m <= 59; $m++) {
								// Add the leading 0
								if ($m < 10){
									$m = '0' . $m;
								}
								if ($m == GetMinute($row['ReturnDate'])){
									echo "<option value='$m' selected='selected'>$m</option>";
								}
								else{
									echo "<option value='$m'>$m</option>";
								}
							}
							echo "</select>";
							
							// AM/PM
							echo "<select id='returnAMPM" . $count . "' name='returnAMPM' style='width:75px'>";
							if (GetAMPM($row['ReturnDate']) == "AM"){
								echo "<option value='AM' selected='selected'>AM</option>";
								echo "<option value='PM'>PM</option>";
							}
							else{
								echo "<option value='AM'>AM</option>";
								echo "<option value='PM' selected='selected'>PM</option>";
							}							
							echo "</select>";
							echo '
						</div>
					</div>									
					<div class="control-group"> 		
						<label class="control-label" for="destinationLocation">Destination Location</label>
						<div class="controls">
							<input id="destinationLocation' . $count . '" name="destinationLocation" type="text" value="' . $row['DestCity'] . '">
						</div>
					</div>
					<div class="control-group"> 								
						<label class="control-label" for="numSeats">Total Number of Seats</label>
						<div class="controls">
							<input id="numSeats' . $count . '" name="numSeats" type="text" value="' . $row['MaxSeats'] . '">
						</div>
					</div>
					<div class="control-group"> 								
						<label class="control-label" for="seatsRemaining">Seats Remaining</label>
						<div class="controls">						
							<input id="seatsRemaining' . $count . '" name="seatsRemaining" type="text" value="' . $row['SeatsRemaining'] . '">
						</div>
					</div>					
					<div class="control-group"> 		
						<label class="control-label" for="price">Price</label>
						<div class="controls">
							<input id="price' . $count . '" name="price" type="text" value="' . $row['Price'] . '">
						</div>
					</div>																																											
			</div>
			<div class="modal-footer">												
				<input class="btn btn-success" type="submit" value="Save changes">
				<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>				
			</div>
		</div>
		</form>
	';
	
	function GetHour($d){		
		return date("g", strtotime($d));		
	}
	
	function GetMinute($d){
		return date("i", strtotime($d));		
	}
	
	function GetAMPM($d){
		return date("A", strtotime($d));
	}
?>