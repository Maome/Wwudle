<?php
	require_once('init.php');
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
		
		<!-- Navbar -->
        <div id="wrap">
        	<?php DisplayNavbar(basename(__FILE__)); ?>
		     <div class="container">
		         <div class="row-fluid">
					<!-- Sidebar -->
					<?php DisplaySidebar(); ?>
		             <div class="span6">
		                 <h2>About the site</h2>
		                 <p>This website was created by five Computer Science undergrads as a part of their senior project. The goal was to create a website that would be very useful to students.</p>
		                 <h4>The creators:</h4>
		                 <p><a href="http://www.linkedin.com/pub/nicholas-beichley/71/160/722">Nicholas Beichley</a></p>
		                 <p><a href="http://www.linkedin.com/pub/kyle-hiebert/6b/57/970">Kyle Hiebert</a></p>
		                 <p><a href="http://www.linkedin.com/pub/beau-ritter/70/91b/582">Beau Ritter</a></p>
		                 <p>Reilly Steele</p>
		                 <p><a href="http://www.linkedin.com/in/nicktarter1">Nick Tarter</a></p>
		                 <p>Special thanks to Professor James Hearne for advising through the process of the creation of this project and Professor Kendra Douglas for design suggestions.</p>
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
</html>
