<?php
	require_once('init.php');
	//require_once('ridesharefunctions.php');	
	//include("../../private_html/connect.php");
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
	$postID = $_POST['PostID'];	
	
	$delete = $_POST['delete'];
	
	$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
	
	if(isset($delete)){
		$sql = "DELETE FROM RideShare WHERE PostID='$postID';";
		$dbc->query($sql);
	}
	else{
	
		// The data will only get passed if it has been validated client side
		// Convert the departure and return dates to store 
		$departureDate = $departureDate . " " . $departureHour . ":" . $departureMinute . ":00" .  $departureAMPM;
		$returnDate = $returnDate . " " . $returnHour . ":" . $returnMinute . ":00" .  $returnAMPM;
		$departureDate = formatDate($departureDate);
		$returnDate = formatDate($returnDate);					
		
		$source = $_POST['name'];																
	
		// Update the information in the database		
		$sql = "UPDATE RideShare SET DepartureDate='$departureDate', SourceCity='$departureLocation', ReturnDate='$returnDate', DestCity='$destinationLocation', MaxSeats='$numSeats', Price='$price' WHERE PostID='$postID';";
		$dbc->query($sql);		
		return $sql;
	}
	
	// Function to format date information into mysql DATETIME format
	function formatDate($d){									
		$date = date('Y-m-d H:i:s', strtotime($d));									
		return $date;
	}

?>