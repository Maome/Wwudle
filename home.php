<?php
	require_once('cassettings.php');
	require_once('includes/navbar.php');
	require_once('includes/sidebar.php');
	include_once("../../private_html/connect.php");
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
		<div id="wrap">
			<!-- Navbar -->
			<?php DisplayNavbar(basename(__FILE__)); ?>
		     <div class="container">
		         <div class="row-fluid">
					<!-- Sidebar -->
					<?php DisplaySidebar(); ?>
		             <div class="span9">
		                 <div class="row-fluid">						 
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
		interval: 7500
	    });
	  $('.carousel').carousel();
          $('.carousel').carousel('cycle');				 
         })
   </script>  
</html>

