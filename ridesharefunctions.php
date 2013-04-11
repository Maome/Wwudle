<?php
	// CONTAINS THE PHP FUNCTIONS ASSOCIATED WITH THE RIDESHARE PORTION OF WESTERN LIST
	
	// The database info
	$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
	
	// Function to show the most resent ride shares posted 	
	function ShowRides($isSearch, $source, $destination)
	{
		global $dbc;
		
		$qry = "SELECT DepartureDate, SourceCity, DestCity, ReturnDate, SeatsRemaining, Price, PostID FROM RideShare WHERE DepartureDate >= CURRENT_TIMESTAMP ORDER BY PostID DESC;";
		
		// See if we are searching or homepage of rides
		if ($isSearch)
		{
			$qry = "SELECT DepartureDate, SourceCity, DestCity, ReturnDate, SeatsRemaining, Price, PostID FROM RideShare WHERE SourceCity like '$source%' AND DestCity like '$destination%' AND DepartureDate >= CURRENT_TIMESTAMP ORDER BY PostID DESC;";
		}				
		
		$result = $dbc->query($qry);		
		$row = $result->fetch_row();  
		
		echo "
			<table id='table_id' class='table table-striped' data-provides='rowlink'>
				<thead>
				<tr><th>Leaving From <i class='icon-chevron-down'></i></th><th>Departing <i class='icon-chevron-down'></i></th><th>Departure Time <i class='icon-chevron-down'></i></th><th>Going To <i class='icon-chevron-down'></i></th><th>Return Date <i class='icon-chevron-down'></i></th><th>Return Time <i class='icon-chevron-down'></i></th><th>Price <i class='icon-chevron-down'></i></th></tr>
				</thead>
				<tbody>
		";
		while($row){			            
		
			// Convert the date/time info
			$departDate = getDateFunc($row[0]);
			$departTime = getTime($row[0]);
			$returnDate = getDateFunc($row[3]);
			$returnTime = getTime($row[3]);
			
			echo "			
				<tr class='rowlink'>
					<td><a href ='rideinfo?PostID=$row[6]'> </a>$row[1]</td>
					<td>$departDate</td>
					<td>$departTime</td>
					<td>$row[2]</td>
					<td>$returnDate</td>
					<td>$returnTime</td>
					<td>$$row[5]</td>
				</tr>									
			";
			$row = $result->fetch_row();  
		}
		echo "</tbody></table>";
	}
		
	// Function to display the info about a rideshare given a PostID
	function ShowRideInfo($PostID)
	{
		global $dbc;
		
		// Get the information about this rideshare
		$sql = "SELECT DepartureDate, SourceCity, DestCity, ReturnDate, SeatsRemaining, Price, PostID FROM RideShare WHERE PostID=$PostID";
		$result = $dbc->query($sql);
		$row = $result->fetch_row();									
		
		// Convert the date 
		$departureDate = getDateFunc($row[0]);
		$departureTime = getTime($row[0]);
		
		$returnDate = getDateFunc($row[3]);
		$returnTime = getTime($row[3]);

											
		// Show the user all of the info that has been recieved 
		echo "
			<table id='table_id' class='table table-striped'>
				<thead>
					<th colspan='2'><h3>Ride Details:</h3></th>												
				</thead>
				<tbody>
					<tr>
						<td><b>Departure Date</b></td><td>$departureDate</td>
					</tr>
					<tr>
						<td><b>Departure Time</b></td><td>$departureTime</td>
					</tr>
					<tr>
						<td><b>Departure Location</b></td><td>$row[1]</td>
					</tr>
					<tr>
						<td><b>Return Date</b></td><td>$returnDate</td>
					</tr>
					<tr>
						<td><b>Return Time</b></td><td>$returnTime</td>
					</tr>
					<tr>
						<td><b>Destination Location</b></td><td>$row[2]</td>
					</tr>
					<tr>
						<td><b>Seats Remaining</b></td><td>$row[4]</td>
					</tr>												
					<tr>
						<td><b>Price</b></td><td>$$row[5]</td>
					</tr>													
				</tbody>
			</table>
			
			<form class='form-inline' action='ridesharerequest.php' method='get'>
				<input type='hidden' name='PostID' value='$PostID'>
				<button type='submit' class='btn btn-primary'>Request Ride</button>
			</form>																											
		";																										
						
	}
	
	// Function to get the date from DATETIME
	function getDateFunc($fromMYSQL){
		return date("F jS, Y", strtotime($fromMYSQL));
	}
	
	// Function to get the time from DATETIME
	function getTime($fromMYSQL){									
		return date("g:i A", strtotime($fromMYSQL));
	}

?>