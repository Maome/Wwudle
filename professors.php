<?php
	require_once('init.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title><?php Woodle(); ?></title>
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
                    <?php ProfessorReviewNav(true); ?>
                        <!--<div class="span6">
                            <h2>Professor Reviews</h2>
                        </div>
                        <div class="span4 offset2">
                            <a class="btn btn-success" type="button" href="professorsadd.php">Review a professor</a>
                        </div>-->
                    </div>
                    <div class="row-fluid">
                        <div class="span6 offset1">
                            <form class="form-inline">
                                <input class="input-medium" type="text" placeholder="professor">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
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

