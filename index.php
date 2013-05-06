<?php
	require_once('includes/sidebar.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Woodle</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">        
    </head>
    <body>
		
		<!-- Navbar -->
		<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-responsive-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<a class="brand" href="home.php" style="font-size: 26px">Woodle</a>
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav" style = "font-size: 16px">
								<li class='active'><a href="home.php">Home</a></li>
								<li><a href="reviews.php">Reviews</a></li>
								<li><a href="rideshare.php">Rideshare</a></li>
								<li><a href="buysell.php">Textbooks</a></li>
								<li><a href="about.php">About</a></li>
							</ul>
							</div>
							<div class="pull-right">';
								<div class="btn-group">
								<a href="home.php" role="button" class="btn btn-primary btn-medium">Log In</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="bottompadding">
			</div>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
                        <div class="hero-unit" style="background-image:url('images/coolwwu.png');">
                            <h1 style="color:#00aae9; text-shadow: 1px 1px 1px #000, 1px 1px 1px black;">Woooooooooodle</h1>                            
                            <p style="color:#00aae9; text-shadow: 1px 1px 1px #000, 1px 1px 1px black;">Rides, Reviews, and Textbook Exchange.</p>
                        </div>
                        <div class="row-fluid">
                        	<h4>To post or view and rides, reviews or rideshares, you must <a href="home.php">log in</a>.</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

