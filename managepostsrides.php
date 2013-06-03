<?php
	require_once('init.php');
	require_once('ridesharefunctions.php');	
	require_once('managepostsridesfunctions.php');
	use JasonKaz\FormBuild\Form as Form;
	use JasonKaz\FormBuild\Text as Text;
	use JasonKaz\FormBuild\Help as Help;
	use JasonKaz\FormBuild\Checkbox as Checkbox;
	use JasonKaz\FormBuild\Submit as Submit;
	use JasonKaz\FormBuild\Password as Password;
	use JasonKaz\FormBuild\Select as Select;
	use JasonKaz\FormBuild\Radio as Radio;			
	use JasonKaz\FormBuild\Button as Button;		
	use JasonKaz\FormBuild\Reset as Reset;
	use JasonKaz\FormBuild\Custom as Custom;
	use JasonKaz\FormBuild\Textarea as Textarea;
	use JasonKaz\FormBuild\Hidden as Hidden;
	use JasonKaz\FormBuild\Email as Email;		
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
		<title><?php Woodle(); ?></title>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="bootstrap/css/datepicker.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-modal.css" rel="stylesheet">
		<link href="bootstrap/css/footer.css" rel="stylesheet">		
		<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js'></script>
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
    </head>
    <body>
		<div id="wrap">
			<!-- Navbar -->
			<?php DisplayNavbar(basename(__FILE__)); ?>
		     
		     <div class="container">
		         <div class="row-fluid">
					<!-- Sidebar -->
					<?php DisplaySidebar(); ?>
		             <div class="span9">
						<?php							
							ManagePostsNav(true, false);
													
							$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
							$user = new user($dbc, phpcas::GetUser());								
							// Get the user information
							$email = $user->getEmail();
							$UserID = $user->getUserID();
																				
							/* 
							 * Check to see if the user is deleting a post
							 */
							if(isset($_POST['delete'])){
								DeleteRideSharePost($_POST['pid'], $UserID, $dbc);							
							}

							/*
							 *Check to see if they are updating the seat count
							 */
							if(isset($_GET['updateSeats']) && isset($_GET['pid'])){
								UpdateSeatCount($_GET['pid'], $UserID, $row['SeatsRemaining'], $dbc);
							}								
						
							/*
							 * Check to see if the user is editing a post
							 */
							if(isset($_GET['edit']) && isset($_GET['pid'])){	
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
								$seatsRemaining = $_POST['seatsRemaining'];
								$price = $_POST['price'];
								$postID = $_POST['PostID'];	

								$isValid = true;							

								// Validate the Post data
								$today = date("Y-m-d H:i:s"); 
								$tempDDate = date("Y-m-d H:i:s", strtotime($departureDate));
								$tempRDate = date("Y-m-d H:i:s", strtotime($returnDate));	

								$errorResults = array();									
																	
								// Check for the validation variables						
								// Check to departure date										
								if (isset($departureDate) && (($tempDDate < $today) || ($tempDDate > $tempRDate)))
								{
									// Date is before today
									 $isValid = false;									
									array_push($errorResults,'departDateError');
								}
								// Check to return date
								if (isset($returnDate) && (($tempRDate > date('Y-m-d', strtotime("+3 months", strtotime($tempRDate)))) || ($tempRDate <= $tempDDate)))
								{
									// Date is before today
									 $isValid = false;														
									array_push($errorResults,'returnDateError');
									
								}
								// Check the numSeats 
								if (isset($numSeats) && !is_numeric($numSeats))
								{
									$isValid = false;	
									array_push($errorResults,'seatError');
								}
								// Check the numSeats 
								if (isset($seatsRemaining) && (!is_numeric($seatsRemaining)) || $seatsRemaining > $numSeats)
								{
									$isValid = false;	
									array_push($errorResults,'seatsRemianingError');
								}	
								// Check the return price 
								if(isset($price) && !is_numeric($price)){
									$isValid = false;
									array_push($errorResults,'priceError');
								}	
								// Check the departure location	
								if(isset($departureLocation) && !preg_match(@"(^[\w\s]+,\s\w{2}$)", $departureLocation)){
									$isValid = false;	
									array_push($errorResults,'departLocError');
								}
								// Check the destination location
								if(isset($destinationLocation ) && !preg_match(@"(^[\w\s]+,\s\w{2}$)", $destinationLocation)){
									$isValid = false;
									array_push($errorResults,'destLocError');
								}									


								// Check if valid and posting back
								if(isset($_POST['postback']) && $isValid){									
									// Write the information to the database 
									// Convert the departure and return dates to store 
									$departureDate = $departureDate . " " . $departureHour . ":" . $departureMinute . ":00" .  $departureAMPM;
									$returnDate = $returnDate . " " . $returnHour . ":" . $returnMinute . ":00" .  $returnAMPM;									
									$departureDate = date('Y-m-d H:i:s', strtotime($departureDate));									
									$returnDate = date('Y-m-d H:i:s', strtotime($returnDate));										
  
									// Update the information in the database		
									$sql = "UPDATE RideShare " .
											"SET RecordStatus='2', " .
											"DepartureDate='$departureDate', " .
											"SourceCity='$departureLocation', " .
											"ReturnDate='$returnDate', " .
											"DestCity='$destinationLocation', " .
											"MaxSeats='$numSeats', " .
											"SeatsRemaining='$seatsRemaining', " .
											"Price='$price' WHERE PostID='$postID' AND UserID='$UserID';";
									$dbc->query($sql);

									// Display the table with the updated data
									ManageRideShareTable($dbc, $UserID);
								}
								// Show the form with the rideshare data in it
								else{
									// Get the information about the rideshare from the db
									$pid = $_GET['pid'];
									$qry = "Select * from RideShare where PostID='$pid'";
									$result = $dbc->query($qry);
									$row = $result->fetch_assoc();
									// The basic form the edit a rideshare 
									$editRideShareForm=new Form;								
									for($i=1; $i<=12; $i++){
										if ($i < 10){
											$i = '0' . (string)$i;
										}
										$hours[$i] = $i;
									}								
									for($i=0; $i<60; $i++){
										if ($i < 10){
											$i = '0' . (string)$i;
										}									
										$minutes[$i] = (string)$i;
									}		
									$AMPM = array("AM"=>"AM", "PM"=>"PM");
									// Get the default values to set
									if (!isset($_POST['departureDate'])) {										
										$departureDate = date('m/d/Y', strtotime($row['DepartureDate']));
										(string)$departureHour = GetHour($row['DepartureDate']);
										(string)$departureMinute = GetMinute($row['DepartureDate']);
										$departureAMPM = GetAMPM($row['DepartureDate']);
									}			
									if (!isset($_POST['returnDate'])) {
										$returnDate = date('m/d/Y', strtotime($row['ReturnDate']));
										(string)$returnHour = GetHour($row['ReturnDate']);
										(string)$returnMinute = GetMinute($row['ReturnDate']);																			
										$returnAMPM = GetAMPM($row['ReturnDate']);
									}								
									if(!isset($_POST['departureLocation'])){
										$departureLocation = $row['SourceCity'];
									}
									if(!isset($_POST['destinationLocation'])){
										$destinationLocation = $row['DestCity'];
									}	
									if(!isset($_POST['numSeats'])){
										$numSeats = $row['MaxSeats'];
									}
									if(!isset($_POST['seatsRemaining'])){
										$seatsRemaining = $row['SeatsRemaining'];
									}	
									if(!isset($_POST['price'])){
										$price = $row['Price'];
									}																													
									echo $editRideShareForm->init('managepostsrides.php?edit=true&pid=' . $pid,'post',array('class'=>'form-horizontal', 'name'=>'editRideShareForm', 'id'=>'editRideShareForm'))
										->group('Departing',										
											new Text(array('class'=>'datepicker input-medium','name'=>'departureDate', 'id'=>'departureDate', 'data-date-format'=>'mm/dd/yyyy', 'value'=>$departureDate)),
											new Custom(in_array('departDateError',$errorResults) ? '<span class="help-inline"><p class="text-warning">Please enter a valid date</p></span>' : '')
										)
										->group('Departing Time',
											new Select($hours, $departureHour, array('class'=>'input-mini','name'=>'departureHour', 'id'=>'departureHour')),
											new Select($minutes, $departureMinute, array('class'=>'input-mini','name'=>'departureMinute', 'id'=>'departureMinute')),
											new Select($AMPM, $departureAMPM, array('class'=>'input-mini','name'=>'departureAMPM', 'id'=>'departureAMPM'))
										)
										->group('Leaving From', 
											new Text(array('class'=>'input-medium','name'=>'departureLocation', 'id'=>'departureLocation', 'value'=>$departureLocation)),
											new Custom(in_array('departLocError',$errorResults) ? '<span class="help-inline"><p class="text-warning">City must be in format City, ST</p></span>' : '')
										)
										->group('Returning',
											new Text(array('class'=>'datepicker input-medium','name'=>'returnDate', 'id'=>'returnDate', 'data-date-format'=>"mm/dd/yyyy", 'value'=>$returnDate)),
											new Custom(in_array('returnDateError',$errorResults) ? '<span class="help-inline"><p class="text-warning">Please enter a valid date</p></span>' : '')
										)
										->group('Return Time',
											new Select($hours, $returnHour, array('class'=>'input-mini','name'=>'returnHour', 'id'=>'returnHour')),
											new Select($minutes, $returnMinute, array('class'=>'input-mini','name'=>'returnMinute', 'id'=>'returnMinute')),
											new Select($AMPM, $returnAMPM, array('class'=>'input-mini','name'=>'returnAMPM', 'id'=>'returnAMPM'))
										)
										->group('Going To', 
											new Text(array('class'=>'input-medium','name'=>'destinationLocation', 'id'=>'destinationLocation', 'value'=>$destinationLocation)),
											new Custom(in_array('destLocError',$errorResults) ? '<span class="help-inline"><p class="text-warning">City must be in format City, ST</p></span>' : '')
										)
										->group('Number of Seats', 
											new Text(array('class'=>'input-medium','name'=>'numSeats', 'id'=>'numSeats', 'value'=>$numSeats)),
											new Custom(in_array('seatError',$errorResults) ? '<span class="help-inline"><p class="text-warning">Please enter a valid number</p></span>' : '')
										)
										->group('Remaining Seats', 
											new Text(array('class'=>'input-medium','name'=>'seatsRemaining', 'id'=>'seatsRemaining', 'value'=>$seatsRemaining)),
											new Custom(in_array('seatsRemianingError',$errorResults) ? '<span class="help-inline"><p class="text-warning">Please enter a valid number</p></span>' : '')
										)									
										->group('Price', 
											new Text(array('class'=>'input-medium','name'=>'price', 'id'=>'price', 'value'=>$price)),
											new Custom(in_array('priceError',$errorResults) ? '<span class="help-inline"><p class="text-warning">Please enter a valid price</p></span>' : '')
										)										
										->group('',
											new Submit('Submit', array('class' => 'btn btn-primary')),
											new Custom('<a href="managepostsrides.php" class="btn btn-danger">Cancel</a>')
										)
										->group('', 
											new Hidden(array('name'=>'PostID', 'id'=>'PostID', 'value'=>$pid))
										)																											
										->group('', 
											new Hidden(array('name'=>'postback', 'id'=>'postback', 'value'=>'true'))
										)											
										->render();	
								}								
							}

							/*
							 * The user is not editing, display the table to the user
							 */										
							else{					
								//DisplayEditRideShare($dbc, $UserID);
								ManageRideShareTable($dbc, $UserID);
							}
							function GetHour($d){		
								return date("h", strtotime($d));		
							}
							
							function GetMinute($d){
								return date("i", strtotime($d));		
							}
							
							function GetAMPM($d){
								return date("A", strtotime($d));
							}																																					
						?>					
		             </div>
		         </div>
		     </div>
		     <div id="push"></div>
        </div>
    	<?php DisplayFooter(); ?>
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
	<script src="bootstrap/js/bootstrap-modal.js"></script>
	<script src="bootstrap/js/bootstrap-modalmanager.js"></script>
	<script src="bootstrap/js/bootstrap-datepicker.js"></script>
    <script>$('.datepicker').datepicker();</script>
</html>

