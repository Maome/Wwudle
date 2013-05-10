<?php
	require_once('includes/sidebar.php');
	require_once('includes/footer.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Woodle</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<<<<<<< HEAD
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">   
=======
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="bootstrap/css/footer.css" rel="stylesheet"> 
>>>>>>> 2192a1cd09fd197d60a2a49a53d67e708b964812
    </head>
    <body>
		<div id="wrap">
		<!-- Navbar -->
<<<<<<< HEAD
		<?php DisplayNavbar(basename(__FILE__)); ?>
        
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
                        <!-- h2>Textbook Exchange</h2>
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
                        </br></br>																																																	-->
                        
                        <div id="myCarousel" class="carousel slide" data-pause="hover"> 
    								<ol class="carousel-indicators">
											<li class="active" data-slide-to="0" data-target="#myCarousel"></li>
											<li class="" data-slide-to="1" data-target="#myCarousel"></li>
											<li class="" data-slide-to="2" data-target="#myCarousel"></li>
    									</ol>
    							<!-- Carousel items -->
    								<div class="carousel-inner">
    									<div class="active item">
    										<a href="rideshare.php"><img alt="" src="images/rideshare.jpg"></img></a>
    										<div class="carousel-caption" data>
    												<h4 style="color:#00aae9; text-shadow: 1px 1px 1px #000, 1px 1px 1px black;">Rideshare</h2>
    												<p>Look for or offer rides to other Western students.<p>    										
    										</div>
    									</div>
    									<div class="item">
    										<a href="reviews.php"><img alt="" src="images/reviews.jpg"></img></a>
    										<div class="carousel-caption">
    												<h4 style="color:#00aae9; text-shadow: 1px 1px 1px #000, 1px 1px 1px black;">Reviews</h2>
    												<p>Post a review on Western professors to help others decide which professor suits their learning style.<p>    	    										
    										</div>
    									</div>
    									<div class="item">
    										<a href="buysell.php"><img alt="" src="images/exchange.jpg"></img></a>
    										<div class="carousel-caption">
													<h4 style="color:#00aae9; text-shadow: 1px 1px 1px #000, 1px 1px 1px black;">Textbook Exchange</h2>
    												<p>Buy and sell used textbooks with other Western students.<p>										
    										</div>
    									</div>
    								</div>
    							<!-- Carousel nav -->
    								<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
    								<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
    							</div>
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
        
=======
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
		  </div>
        <?php DisplayFooter(); ?>
>>>>>>> 2192a1cd09fd197d60a2a49a53d67e708b964812
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/js/bootstrap-carousel.js"></script>

    
    <script type="text/javascript">
        $(document).ready(function() {
				 $('.carousel').carousel({
				 	interval: 4500
				 });
				 $('.carousel').carousel();
		  		 $('.carousel').carousel('cycle');				 
		  })
   </script>  
</html>

