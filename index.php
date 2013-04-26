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
                        <div class="hero-unit" style="background-image:url('images/coolwwu.png');">
                            <h1>Woooooooooodle</h1>                            
                            <p>Rides, Reviews, and Textbook Exchange.</p>
                        </div>
                        <h2>Textbooks</h2>
                        <p>Have an old textbook that you don't need anymore? Or maybe you're trying to find an alternative route to save money from the high costs of books? Well look no further, here on woodle you can buy and sell old textbooks with other Western Students in a nice, easy fashion that will avoid the hassel of the bookstore or shopping online, all while saving money in the process! Easily search for books posted by ISBN or title and send off a quick easy email to the seller. Easy, right?!</p>
                        <a class="btn btn-primary pull-right" type="button" href="buysell.php">Search Textbooks</a>
                        </br></br>
                        <h2>Reviews</h2>
                        <p>Need to take a class but have options on what professors to take and want to take the one best suited for your learning style? Or maybe you just have those professors you absolutely loved learning from and want to get the word out about how amazing they are. Here with reviews, you can easily search through professors by department, course number, or simply their name, and get the information you'd like to have before registering. Reviews are simple enough to fill out, using a star ratings scale to show what a professors strengths and weaknesses are in the eyes of the students. Now, share your experiences and help out your fellow Vikings!</p>
                        <a class="btn btn-primary pull-right" type="button" href="reviews.php">Search Reviews</a>
                        </br></br>
                        <h2>Rideshare</h2>
                        <p>Cost of transportation isn't cheap these days, but we all have to do it. So why not find a ride with another Western student and save all a bunch of money, all while going green in the process by carpooling! Rideshare makes that all easier to do, by giving Western students the ability to post rides they are offering to their destinations, along with the price they're asking for and how many seats they have available. From there, students can actively search the listings and get into quick contact via email with the driver. So save some money and maybe make a new friend in the process.</p>
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

