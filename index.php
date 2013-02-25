<?php
	require_once('cassettings.php');
	require_once('includes/navbar.php');
	require_once('includes/sidebar.php');
	include_once("../../../private_html/connect.php");
?>
<html>
    <head>
        <title>Wlist</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    </head>
    <body>

       <!-- Modal -->
        <div id="loginModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-body">
                <p>Oops I'm broken..</p>
            </div>
        </div>
		
		<!-- Navbar -->
		<?php DisplayNavbar(basename(__FILE__)); ?>
        
        <div class="container">
            <div class="row">
                <div class="hero-unit">
                    <h1>Welcome</h1>
                    <p><a href="login.php" role="button" class="btn btn-primary btn-large">Log In</a></p>
                </div>
            </div>
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
                        <h2>Recently Added</h2>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="well well-small">
                                <div class="media">
                                    <a class="pull-left" href="#"><img class="media-object" data-src="holder.js/64x64"></a>
                                    <div class="media-body">
                                        <h4 class="media-heading">Heading</h4>
                                        <p>A product description in project management...</p>
                                    </div>
                                </div>
                            </div>
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

