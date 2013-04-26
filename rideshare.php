<?php
	require_once('init.php');
	require_once('ridesharefunctions.php');
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Western List</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-rowlink.css" rel="stylesheet">
		<link href="datatables/media/css/bootstrap-dt.css" rel="stylesheet">     
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/paging.js"></script>
		<script>
			$(document).ready(function() {
				var oTable = $('#table_id').dataTable( {
					"sPaginationType": "bootstrap"
				} );															
			} );
			
		</script>        
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
                        <!--<div class="span4">
                            <h2>Rideshare</h2>
                        </div>-->
						<?php RideshareNav(true); ?>                        
                        
                        
                        <!--<div class="span4 offset4">
                            <a class="btn btn-success" type="button" href="rideshareadd.php">Add a ride</a>
                        </div>-->
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
						ShowRides(false, null, null);
                    ?>
                </div>
            </div>
        </div>
        
    </body>
    <script src="holder/holder.js"></script>
    <!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
    <script src="bootstrap/js/bootstrap.js"></script>    
    <script src="bootstrap/js/bootstrap-rowlink.js"></script>
</html>

