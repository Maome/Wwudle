<?php
	// CONTAINS THE PHP FUNCTIONS ASSOCIATED WITH THE RIDESHARE PORTION OF WESTERN LIST
	
	// The database info
	$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
	
	// Function to show the most resent ride shares posted 	
	function ShowRides($isSearch, $source, $destination, $departureDate, $returnDate, $maxPrice)
	{
		global $dbc;
		
		// **** THE SERVER CLOCK IS FAST BY 7 HOURS ****
		$qry = "SELECT DepartureDate, SourceCity, DestCity, ReturnDate, SeatsRemaining, Price, PostID, MaxSeats FROM RideShare WHERE RecordStatus != '3' AND DepartureDate >= CURRENT_TIMESTAMP - INTERVAL 7 HOUR ORDER BY PostID DESC;";
		
		// See if we are searching or homepage of rides
		if ($isSearch)
		{					
			// validate the input
			if(!is_numeric($maxPrice)){
				$maxPrice = PHP_INT_MAX;
			}	
			if(!preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $departureDate)){
				$departureDate = '';
			}
			else {
				$departureDate = formatDate($departureDate);
			}
			if(!preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/", $returnDate)){
				$returnDate= '';
			}
			else {
				$returnDate= formatDate($returnDate);
			}		
			
			// Get a list of possible ending cities that could pass by the desitination
			$destCities = cityOnPath($source, $destination);			
			
			// **** THE SERVER CLOCK IS FAST BY 7 HOURS ****
			$qry = "SELECT DepartureDate, SourceCity, DestCity, ReturnDate, SeatsRemaining, Price, PostID, MaxSeats " .
					"FROM RideShare " . 
					"WHERE RecordStatus != '3' " .
					"AND SourceCity like '$source%' " . 
					"AND (DestCity like $destCities)" .					
					"AND DepartureDate like '$departureDate%' " .					
					"AND ReturnDate like '$returnDate%' " .										
					"AND Price <= '$maxPrice' " .
					"AND DepartureDate >= CURRENT_TIMESTAMP - INTERVAL 7 HOUR " .
					"ORDER BY PostID DESC;";
		}				
		
		$result = $dbc->query($qry);		
		$row = $result->fetch_row();  
		
		echo "
			<table id='table_id' class='table table-striped' data-provides='rowlink'>
				<thead>
				<tr class='rowlink'>
					<th>Leaving From <i class='icon-chevron-down'></i></th>
					<th>Departing <i class='icon-chevron-down'></i></th>
					<th>Departure Time <i class='icon-chevron-down'></i></th>
					<th>Going To <i class='icon-chevron-down'></i></th>
					<th>Return Date <i class='icon-chevron-down'></i></th>
					<th>Return Time <i class='icon-chevron-down'></i></th>
					<th>Price <i class='icon-chevron-down'></i></th></tr>

				</tr>
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
				<tr id='$row[6]' class='rowlink'>
					<td>$row[1]</td>
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
		
		// Add a view
		$dbc->query("Update RideShare Set ViewCount=ViewCount+1 Where PostID='$PostID';");
		
		// Get the information about this rideshare
		$sql = "SELECT DepartureDate, SourceCity, DestCity, ReturnDate, SeatsRemaining, MaxSeats, Price, PostID, ViewCount FROM RideShare WHERE PostID=$PostID";
		$result = $dbc->query($sql);
		$row = $result->fetch_assoc();									
		
		// Convert the date 
		$departureDate = getDateFunc($row['DepartureDate']);
		$departureTime = getTime($row['DepartureDate']);
		
		$returnDate = getDateFunc($row['ReturnDate']);
		$returnTime = getTime($row['ReturnDate']);

//echo "";
											
		// Show the user all of the info that has been recieved 
		echo "
			<table id='table_id' class='table table-striped'>
				<thead>
					<th colspan='2'><h3>Ride Details: " . $row['ViewCount'] . " Views</h3></th>																	
				</thead>
				<tbody>
					<tr>
						<td><b>Departure Date</b></td><td>$departureDate</td>
					</tr>
					<tr>
						<td><b>Departure Time</b></td><td>$departureTime</td>
					</tr>
					<tr>
						<td><b>Departure Location</b></td><td>" . $row['SourceCity'] . "</td>
					</tr>
					<tr>
						<td><b>Return Date</b></td><td>$returnDate</td>
					</tr>
					<tr>
						<td><b>Return Time</b></td><td>$returnTime</td>
					</tr>
					<tr>
						<td><b>Destination Location</b></td><td>" . $row['DestCity'] . "</td>
					</tr>
					<tr>
						<td><b>Seats Remaining</b></td><td>" . $row['SeatsRemaining'] . "/" .$row['MaxSeats'] . "</td>
					</tr>												
					<tr>
						<td><b>Price</b></td><td>$" . $row['Price'] . "</td>
					</tr>													
				</tbody>
			</table>						
			<form class='form-inline' action='ridesharerequest.php' method='get'>
				<input type='hidden' name='PostID' value='$PostID'>
				<button type='submit' class='btn btn-primary'>Request Ride</button>				
			</form>		
		";																										
						
	}
	
	// Function to format date information into mysql DATETIME format
	function formatDate($d){									
		$date = date('Y-m-d', strtotime($d));									
		return $date;
	}
	
	
	// Function to get the date from DATETIME
	function getDateFunc($fromMYSQL){
		return date("F jS, Y", strtotime($fromMYSQL));
	}
	
	// Function to get the time from DATETIME
	function getTime($fromMYSQL){									
		return date("g:i A", strtotime($fromMYSQL));
	}
	
	// Function to tell if a city is along a path
	function cityOnPath($start, $end){
		// Array with all the cities along the i5
		$i5Cities = array(
			1 => "Blaine, WA",
			2 => "Birch Bay, WA",
			3 => "Custer, WA",
			4 => "Ferndale, WA",
			5 => "Bellingham, WA",
			6 => "Burlington, WA",
			7 => "Mt Vernon, WA",
			8 => "Conway, WA",
			9 => "Arlington, WA",
			10 => "Marysville, WA",
			11 => "Everett, WA",
			12 => "Mukilteo, WA",
			13 => "Mill Creek, WA",
			14 => "Lynnwood, WA",
			15 => "Mountlake Terrace, WA",
			16 => "Shoreline, WA",
			17 => "Seattle, WA",
			18 => "Skyway, WA",
			19 => "Tukwila, WA",
			20 => "Seatac, WA",
			21 => "Des Moines, WA",
			22 => "Federal Way, WA",
			23 => "Milton, WA",
			24 => "Fife, WA",
			25 => "Tacoma, WA",
			26 => "Lakewoood, WA",
			27 => "DuPont, WA",
			28 => "Lacey, WA",
			29 => "Olympia, WA",
			30 => "Tumwater, WA",
			31 => "Fords Prairie, WA",
			32 => "Centralia, WA",
			33 => "Chehalis, WA",
			34 => "Napavine, WA",
			35 => "Winlock, WA",
			36 => "Toledo, WA",
			37 => "Vader, WA",
			38 => "Castle Rock, WA",
			39 => "Kelso, WA",
			40 => "Longview, WA",
			41 => "Kalama, WA",
			42 => "Woodland, WA",
			43 => "La Center, WA",
			44 => "Ridgefield, WA",
			45 => "Salmon Creek, WA",
			46 => "Hazel Dell, WA",
			47 => "Minnehaha, WA",
			48 => "Vancouver, WA",
			49 => "Portland, OR",
		);
		
		
		// String to hold possible cities
		$citiesList = "'" . $end . "%' ";
		
	
		// Check if the cities are along the path
		if(in_array($start, $i5Cities) && in_array($end, $i5Cities)){
			// decide if traveling north to south or not
			$startKey = array_search($start, $i5Cities);
			$endKey = array_search($end, $i5Cities);
						
			// Travelling southwards
			if($startKey < $endKey){				
				// create string of possible places
				for($i=$endKey+1; $i<=count($i5Cities); $i++){
					$citiesList .= "OR DestCity like '" . $i5Cities[$i] . "%' ";
				}
			}
			// Traveling nothwards
			else{
				// create string of possible places
				for($i=$endKey-1; $i>0; $i--){
					$citiesList .= "OR DestCity like '" . $i5Cities[$i] . "%' ";
				}
			
			}
		}
		return $citiesList;
				
	}

?>


