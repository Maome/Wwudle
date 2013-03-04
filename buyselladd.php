<?php
	require_once('cassettings.php');
	require_once('includes/navbar.php');
	require_once('includes/sidebar.php');
	include_once("../../private_html/connect.php");
?>
<!DOCTYPE HTML>
<html lang-"en">
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
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
                        <div class="span4">
                            <h2>Sell a Book</h2>
                        </div>
                    </div>
                </div>
                 <div class="row-fluid">
							<!-- Search box for book lookup -->
                     <div class="span6 offset1"w>				
                         <form class="form-inline" id="bookLookup" action="buyselladd.php">
                             <input class="input-xlarge" type="text" placeholder="Enter 10 - 13 digit ISBN" name="searchText" style="height:30px;">
                             <button type="submit" class="btn">Search</button>
                         </form>
                     </div>
							<?php
								require_once 'src/Google_Client.php';
								require_once 'src/contrib/Google_BooksService.php';

								$client = new Google_Client();
								$client->setDeveloperKey('AIzaSyCUXX2Wi9fKlaw2HTpgQnsFxG-0YTTIeW0');
								$client->setApplicationName("Books_Example_App");
								$service = new Google_BooksService($client);

								function echoBookList($results) {
								  foreach ($results['items'] as $result) {
									 $volumeInfo = $result['volumeInfo'];
									 $title = $volumeInfo['title'];
									 if (isset($volumeInfo['imageLinks']['thumbnail'])) {
										$thumbnail = $volumeInfo['imageLinks']['thumbnail'];
									 } else {
										$thumbnail = null;
									 }
									 if (isset($volumeInfo['authors'])) {
										$creators = implode(" / ", $volumeInfo['authors']);
									 }

									 echo '<div class="span6">';
									 $thumbnailImg = ($thumbnail) ? "<a href='${preview}'><img alt='$title' src='${thumbnail}' style='border:1px solid black' /></a>" : '';
										echo '<br />' .$thumbnailImg;
										echo '<br /><b>' .$title .'</b>';
										echo '<br />' .$creators;
									echo '</div>';
								  }
								}

							  $volumes = $service->volumes;
							  $optParams = array();

							  /* display a list of volumes */
							  if (isset($_GET['searchText'])) {
								 $searchText =  'isbn:' .$_GET['searchText'];
							  	 $results = $volumes->listVolumes($searchText, $optParams);
								 echoBookList($results);
							  }

							?>
                 </div>
            </div>
        </div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

