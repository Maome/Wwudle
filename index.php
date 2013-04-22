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
                        <div class="hero-unit">
                            <h1>Woooooooooodle</h1>
                            <p>Yo this website is cool, we should sell some stuff on it.</p>
                        </div>
                        <h2>Textbooks</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius iaculis nisl, in placerat dolor iaculis in. Quisque turpis lectus, gravida vitae venenatis et, lacinia vel dui. Aenean tellus odio, dignissim eu eleifend id, volutpat in velit. Morbi at arcu vel felis euismod vehicula et ut risus. Aenean tempus sem posuere erat imperdiet pulvinar. Aenean ac mauris vitae eros aliquet interdum. Sed in tincidunt leo. Praesent quis justo id nisi dapibus semper sed blandit mi.</p>
                        <a class="btn btn-primary pull-right" type="button" href="buysell.php">Search Textbooks</a>
                        </br></br>
                        <h2>Reviews</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius iaculis nisl, in placerat dolor iaculis in. Quisque turpis lectus, gravida vitae venenatis et, lacinia vel dui. Aenean tellus odio, dignissim eu eleifend id, volutpat in velit. Morbi at arcu vel felis euismod vehicula et ut risus. Aenean tempus sem posuere erat imperdiet pulvinar. Aenean ac mauris vitae eros aliquet interdum. Sed in tincidunt leo. Praesent quis justo id nisi dapibus semper sed blandit mi.</p>
                        <a class="btn btn-primary pull-right" type="button" href="reviews.php">Search Reviews</a>
                        </br></br>
                        <h2>Rideshare</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius iaculis nisl, in placerat dolor iaculis in. Quisque turpis lectus, gravida vitae venenatis et, lacinia vel dui. Aenean tellus odio, dignissim eu eleifend id, volutpat in velit. Morbi at arcu vel felis euismod vehicula et ut risus. Aenean tempus sem posuere erat imperdiet pulvinar. Aenean ac mauris vitae eros aliquet interdum. Sed in tincidunt leo. Praesent quis justo id nisi dapibus semper sed blandit mi.</p>
                        <a class="btn btn-primary pull-right" type="button" href="rideshare.php">Search Rideshares</a>
                        </br></br>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

