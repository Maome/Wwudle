<?php
	// THIS FILE CONTAINS THE FUNCTIONS CALLED BY MANAGEPOSTSRIDES

	/*
	 * Deletes a rideshare (changes its status to delete) in the db
	 */
	function DeleteRideSharePost($pid, $user, $dbc){
		// Update the rideshare if the correct user is trying to remove the rideshare		
		if (isset($pid)){
			$qry = "UPDATE RideShare SET RecordStatus='3' WHERE PostID='$pid' AND UserID='$user';";
			$dbc->query($qry);
		}	
	}

	/*
	 * Updates the number of available seats in a rideshare
	 */	
	function UpdateSeatCount($pid, $user, $seatsRemaining, $dbc){
		// Only update if there is a legitamate pid		
		if(is_numeric($pid)){										
			// Update the count of open seats in this vehicle
			$qry = "SELECT SeatsRemaining FROM RideShare WHERE PostID='$pid' AND UserID='$user';";
			$result = $dbc->query($qry);
			$row = $result->fetch_assoc();
			
			// Check if it is okay to update the number of seats remaining
			if($seatsRemaining > 0){
				$qry = "UPDATE RideShare SET SeatsRemaining=SeatsRemaining-1 WHERE PostID='$pid' AND UserID='$user';";
				$result = $dbc->query($qry);				
				echo "<h3>Thank you for updating the seat count of your Rideshare</h3>";							
			}
		}		
	}

	/*
	 * Displays the rides that the user currently has posted 
	 */
	function ManageRideShareTable($dbc, $user){

		// Populate a table with the rideshares the user currently has posted
		// **** THE SERVER CLOCK IS FAST BY 7 HOURS ****
		$qry = "SELECT * FROM RideShare " .
				"WHERE RecordStatus != '3' " .
				"AND UserID='$user' " .
				"AND DepartureDate >= CURRENT_TIMESTAMP - INTERVAL 7 HOUR " .
				"ORDER BY PostID DESC;";
		$result = $dbc->query($qry);
		$row = $result->fetch_assoc();														

		if ($result->num_rows > 0) {
			$headers = array("Leaving From", "Departing", "Departure Time", "Going To", "Return Date", "Return Time", "Edit");
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
					<td>						
						<form class='form-inline' action='managepostsrides.php' method='POST'>
							<input type='hidden' name='pid' id='pid' value='" . $row["PostID"] . "'>
							<input type='hidden' name='delete' id='delete' value='true'>												
							<a href='?edit=true&pid=" . $row['PostID'] . "' role='button' class='btn btn-primary' data-toggle='modal'>Edit</a>
							<input class='btn btn-danger' type='submit' value='Delete' >
						</form>	
					</td>							
				</tr>";		
				$row = $result->fetch_assoc(); 
				$count++;
			}
			echo "</tbody></table>";									
		}
		else {
			echo "You currently have no rideshares pending";			
		}		
	}
?>