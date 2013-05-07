<?php
	require_once('init.php');
	require_once('ridesharefunctions.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title><?php Woodle(); ?></title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="bootstrap/css/footer.css" rel="stylesheet">
    </head>
    <body>
		 <div id="wrap">
			<!-- Navbar -->
			<?php DisplayNavbar(basename("rideshare.php")); ?>
		     
		     <div class="container">
		         <div class="row-fluid">
					<!-- Sidebar -->
					<?php DisplaySidebar(); ?>
		             <div class="span9">
		                 <div class="row-fluid">
		                 <?php RideshareNav(true); ?>
		                     <div class="span5">

		                         <!-- MAIN CONTENT FOR RIDEINFO -->
								<?php
									// Get the post data
									$PostID = $_GET['PostID'];
									ShowRideInfo($PostID);																										   																															
								?>
							
		                     </div>
		                 </div>
		             </div>
		         </div>
		     </div>
        </div>
    	<?php DisplayFooter(); ?>
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

