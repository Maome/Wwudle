    <?php
            require_once('includes/sidebar.php');
            require_once('includes/footer.php');
    ?>
    <!DOCTYPE HTML>
    <html lang-"en">
        <head>
            <title>Woodle</title>
            <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
            <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
            <link href="bootstrap/css/footer.css" rel="stylesheet">
        </head>
        <body>
                    <div id="wrap">
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
                                            <div class="row-fluid">
                                           	 <h4>To post or view and rides, reviews or rideshares, you must <a href="home.php">log in</a>.</h4>
                                         	  </div>
                          <div id="myCarousel" class="carousel slide" data-pause="hover"> 
    								<ol class="carousel-indicators">
											<li class="active" data-slide-to="0" data-target="#myCarousel"></li>
											<li class="" data-slide-to="1" data-target="#myCarousel"></li>
											<li class="" data-slide-to="2" data-target="#myCarousel"></li>
											<li class="" data-slide-to="3" data-target="#myCarousel"></li>
    									</ol>
    							<!-- Carousel items -->
    								<div class="carousel-inner" >
    									<div class="active item">
    										<img alt="" src="images/wwudle.jpg"></img>
    										<div class="carousel-caption" data>
    												<h4 style="color:#00aae9; text-shadow: 1px 1px 1px #000, 1px 1px 1px black;">Wwudle</h2>
    												<p>Rides, Reviews, and Textbook Exchange<p>    										
    										</div>    									
    									</div>
    									<div class="item">
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
                      </div>
            <?php DisplayFooter(); ?>
        </body>
        <script src="holder/holder.js"></script>
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
