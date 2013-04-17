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
	
	// The data will only get passed if it has been validated client side
	// Convert the departure and return dates to store 
	$departureDate = $departureDate . " " . $departureHour . ":" . $departureMinute . ":00" .  $departureAMPM;
	$returnDate = $returnDate . " " . $returnHour . ":" . $returnMinute . ":00" .  $returnAMPM;
	$departureDate = formatDate($departureDate);
	$returnDate = formatDate($returnDate);		
	
/*	$departureDate = "2013-04-20 17:00:00";
	$returnDate ="2013-04-23 6:00:00";*/	
	
	$source = $_POST['name'];																

	// Update the information in the database
	$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
	$sql = "UPDATE RideShare SET DepartureDate='$departureDate', SourceCity='$departureLocation', ReturnDate='$returnDate', DestCity='$destinationLocation', MaxSeats='$numSeats', Price='$price' WHERE PostID='$postID';";
	//$sql = "UPDATE RideShare SET DepartureDate='2013-04-20 17:00:00', SourceCity='$source', ReturnDate='2013-04-23 6:00:00', DestCity='beeee', MaxSeats='111', Price='44' WHERE PostID='37';";
	$dbc->query($sql);		
	return $sql;
	//do_alert($sql);	
	//return $sql;
	
	// Function to format date information into mysql DATETIME format
	function formatDate($d){									
		$date = date('Y-m-d H:i:s', strtotime($d));									
		return $date;
	}

?>