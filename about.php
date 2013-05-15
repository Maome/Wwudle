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
		                 <p>This website was created by five Computer Science undergrads as a part of their senior project. Our goal was to create a website that would be very useful to students.</p>
		                 <h4>The creators:</h4>
		                 <p>Nicholas Beichley</p>
		                 <p>Kyle Hiebert</p>
		                 <p>Beau Ritter</p>
		                 <p>Reilly Steele</p>
		                 <p>Nick Tarter</p>
		                 <p>Special thanks to Professor James Hearne for advising us through the process of the creation of this project and Professor Kendra Douglas for design suggestions.</p>
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
