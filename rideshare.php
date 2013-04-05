<?php
	require_once('cassettings.php');
	require_once('includes/navbar.php');
	require_once('includes/sidebar.php');
	include_once("../../private_html/connect.php");
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Western List</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    </head>
    <body>

		<!-- Navbar -->
		<?php DisplayNavbar(basename(__FILE__)); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
                        <div class="span4">
                            <h2>Rideshare</h2>
                        </div>
                        <div class="span4 offset4">
                            <a class="btn btn-success" type="button" href="rideshareadd.php">Add a ride</a>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span8 offset1">
                            <form class="form-inline" action="ridesharesearch.php" method="get">
                                <input class="input-medium" type="text" placeholder="From:" name="from">
                                <input class="input-medium" type="text" placeholder="To:" name="to">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
                    
                    <?php
                    	// Show the most resent ride shares posted 
                    	$sql = "SELECT DepartureDate, SourceCity, DestCity, ReturnDate, SeatsRemaining, Price, PostID FROM RideShare ORDER BY PostID DESC;";
                    	$connection->multi_query($sql);
                    	$result = $connection->store_result();
                    	$row = $result->fetch_row();  
						
						echo "
							<table class='table'>
								<tr><th>Departure City</th><th>Departure Date</th><th>Departure Time</th><th>Destination City</th><th>Return Date</th><th>Return Time</th><th>Price</th></tr>						
						";
                    	// Display the 10 most recent rideshare posts
                    	for($i=0; $i<10; $i++){
			                if ($row == NULL){ 
			                	break;
			                }
                    	
                    		// Convert the date/time info
                    		$departDate = getDateFunc($row[0]);
                    		$departTime = getTime($row[0]);
                    		$returnDate = getDateFunc($row[3]);
                    		$returnTime = getTime($row[3]);
							
							echo "
								<tr>
									<td><a href ='rideinfo?PostID=$row[6]'><h4 class='media-heading'>$row[1]</a></td>
									<td>$departDate</td>
									<td>$departTime</td>
									<td><a href ='rideinfo?PostID=$row[6]'><h4 class='media-heading'>$row[2]</a></td>
									<td>$returnDate</td>
									<td>$returnTime</td>
									<td>$$row[5]</td>
								</tr>																
							";
                    		
		                    // echo "
			                    // <div class='row-fluid'>	                    
			                        // <div class='span6'>
			                            // <div class='well well-small'>
			                                // <div class='media'>                                	
			                                    // <a class='pull-left' href='#'><img class='media-object' data-src='holder.js/64x64'></a>
			                                    // <div class='media-body'>
			                                        // <a href ='rideinfo?PostID=$row[6]'><h4 class='media-heading'>$row[1] <i class='icon-arrow-right'></i> $row[2]</h4></a>
			                                        // <p><b>Depart:</b> $departTime on $departDate</p>
			                                        // <p><b>Return:</b> $returnTime on $returnDate</p>
			                                        // <p><b>Price:</b> $$row[5]</p>
			                                    // </div>
			                                // </div>
			                            // </div>
			                        // </div>
			                // ";        
			                
			                // // Get the next row 
			                // $row = $result->fetch_row();
			                // if ($row == NULL){
			                	// break;
			                // }			                			                
                    		// // Convert the date/time info
                    		// $departDate = getDateFunc($row[0]);
                    		// $departTime = getTime($row[0]);
                    		// $returnDate = getDateFunc($row[3]);
                    		// $returnTime = getTime($row[3]);
			                
			                // echo "        
			                        // <div class='span6'>
			                            // <div class='well well-small'>
			                                // <div class='media'>
			                                    // <a class='pull-left' href='#'><img class='media-object' data-src='holder.js/64x64'></a>
			                                    // <div class='media-body'>
			                                        // <a href ='rideinfo?PostID=$row[6]'><h4 class='media-heading'>$row[1] <i class='icon-arrow-right'></i> $row[2]</h4></a>
			                                        // <p><b>Depart:</b> $departTime on $departDate</p>
			                                        // <p><b>Return:</b> $returnTime on $returnDate</p>
			                                        // <p><b>Price:</b> $$row[5]</p>
			                                    // </div>
			                                // </div>
			                            // </div>
			                        // </div>
			                    // </div>
		                    // ";
		                    $row = $result->fetch_row();  
	                    }
						echo "</table>";
	                    
                		// Function to get the date from DATETIME
						function getDateFunc($fromMYSQL){
							return date("F jS, Y", strtotime($fromMYSQL));
						}
						
						// Function to get the time from DATETIME
						function getTime($fromMYSQL){									
							return date("g:i A", strtotime($fromMYSQL));
						}

                    ?>
                    <!--
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

