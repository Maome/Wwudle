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
	<?php DisplayNavbar("buysell.php"); ?>
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
                             <input class="input-xlarge" type="text" placeholder="Search by ISBN or Title" name="searchText" style="height:30px;">
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

								function postBookListing($isbn) {
									global $connection;
									// Insert book if it does not exist
									$sql = "INSERT INTO Book
											  (ISBN, ChangeSource, RecordStatus, RecordStatusDate)
											  SELECT DISTINCT " .$isbn .", 0, 1, NOW()
											  FROM Book
											  WHERE " .$isbn ." NOT IN (
													SELECT ISBN
													FROM BookListing
											  )";
									//echo $sql;
									if (!$connection->query($sql)) {
									  echo "Error!";
									  error_log(__FILE__ ."|" .$connection->error ."\r\n",3,"errors/errors.log");
									}
									
									// Get book id
									$sql = "SELECT BookID
									        FROM Book
									        WHERE ISBN = '" .$isbn ."';";
									$result = $connection->query($sql);
									$row = $result->fetch_row();
									$bookID = $row[0];
									
									// Insert book listing
									$sql = "INSERT INTO BookListing
										(PostDate, UserID, BookID, BookConditionID, Price, ViewCount, ChangeSource, RecordStatus, RecordStatusDate)
										VALUES(NOW()," .$_SESSION['userID'] ."," .$bookID ."," .$_POST['condition'] ."," .$_POST['price'] .", 0, 0, 1, NOW());";
									$result = $connection->query($sql);
									
									echo "
									  <div>
									    <b> Your book has been listed! </b>
									  </div>
									";
								}

								function echoSaleForm($isbn) {
									global $connection;
									$sql = "SELECT BookConditionID, Description FROM BookCondition";
									$result = $connection->query($sql);
									echo "<form action='buyselladd.php' method='POST'>";
									echo "Condition<br /> <select name='condition'>";
									while ($row = $result->fetch_row()) {
										echo "<option value='" .$row[0] ."'>" .$row[1] ."</option>";
									}
									echo "</select>";
									echo "<br />Price<br /><input type='text' name='price' style='height:30px;'>";
									echo "<input type='hidden' name='isbn' value='" .$isbn ."' />";
									echo "<br /><input type='submit' value='Submit' style='height:30px;' />";
									echo "</form>";
								}

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
										echo '<br />Author(s): ' .$creators;
										echo '<br />';
										$identifiers = $volumeInfo['industryIdentifiers'];
										$isbn = string;
										for($i = 0; $i < count($identifiers); $i++) {
											if ($identifiers[$i]['type'] == 'ISBN_10') echo "ISBN 10: " .$identifiers[$i]['identifier'] ."<br />";
											else if ($identifiers[$i]['type'] == 'ISBN_13') {
											  echo "ISBN 13: " .$identifiers[$i]['identifier'] ."<br />";
											  $isbn = $identifiers[$i]['identifier'];
											}
										}
										echoSaleForm($isbn);
										
									echo '</div>';
								  }
								}

							  $volumes = $service->volumes;
							  $optParams = array();

							  /* display a list of volumes */
							  if (isset($_GET['searchText'])) {
								 $searchText =  (is_numeric($_GET['searchText'])? 'isbn:' : '') .$_GET['searchText'];
							  	 $results = $volumes->listVolumes($searchText, $optParams);
								 echoBookList($results);
							  }

							  if (isset($_POST['isbn'])) {
									postBookListing($_POST['isbn']);
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

