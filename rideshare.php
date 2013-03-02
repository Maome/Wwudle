<?php
	require_once('cassettings.php');
	require_once('includes/navbar.php');
	require_once('includes/sidebar.php');
	include_once("../../private_html/connect.php");
?>
<html>
    <head>
        <title>Wlist</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
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
                            <h2>Rideshare</h2>
                        </div>
                        <div class="span4 offset4">
                            <a class="btn btn-success" type="button" href="rideshareadd.php">Add a ride</a>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span8 offset1">
                            <form class="form-inline" action="ridesharesearch.php" method="get">
                                <input class="input-medium" type="text" placeholder="From:">
                                <input class="input-medium" type="text" placeholder="To:">
                                <button type="submit" class="btn">Search</button>
                            </form>
                        </div>
                    </div>
                    
                    <?php
                    	// Show the most resent ride shares posted 
                    	$sql = "SELECT DepartureDate, SourceCity, DestCity, ReturnDate, SeatsRemaining, Price, PostID FROM RideShare ORDER BY PostID DESC;";
                    	$connection->multi_query($sql);
                    	$result = $connection->store_result();
                    	$row = $result->fetch_row();                    								                   
                    
                    	// Display the 10 most recent rideshare posts
                    	for($i=0; $i<5; $i++){
		                    echo "
			                    <div class='row-fluid'>	                    
			                        <div class='span6'>
			                            <div class='well well-small'>
			                                <div class='media'>                                	
			                                    <a class='pull-left' href='#'><img class='media-object' data-src='holder.js/64x64'></a>
			                                    <div class='media-body'>
			                                        <a href ='rideinfo?PostID=$row[6]'><h4 class='media-heading'>$row[1] <i class='icon-arrow-right'></i> $row[2]</h4></a>
			                                        <p><b>Depart:</b> $row[0]</p>
			                                        <p><b>Return:</b> $row[3]</p>
			                                        <p><b>Price:</b> $$row[4]</p>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                ";        
			                $row = $result->fetch_row();
			                echo "        
			                        <div class='span6'>
			                            <div class='well well-small'>
			                                <div class='media'>
			                                    <a class='pull-left' href='#'><img class='media-object' data-src='holder.js/64x64'></a>
			                                    <div class='media-body'>
			                                        <a href ='rideinfo?PostID=$row[6]'><h4 class='media-heading'>$row[1] <i class='icon-arrow-right'></i> $row[2]</h4></a>
			                                        <p><b>Depart:</b> $row[0]</p>
			                                        <p><b>Return:</b> $row[3]</p>
			                                        <p><b>Price:</b> $$row[4]</p>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
		                    ";
		                    $row = $result->fetch_row();  
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

