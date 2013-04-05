<?php
	require_once('init.php');
	require_once('classes/book.php');
	use JasonKaz\FormBuild\Form as Form;
	use JasonKaz\FormBuild\Text as Text;
	use JasonKaz\FormBuild\Help as Help;
	use JasonKaz\FormBuild\Checkbox as Checkbox;
	use JasonKaz\FormBuild\Submit as Submit;
	use JasonKaz\FormBuild\Password as Password;
	use JasonKaz\FormBuild\Select as Select;
	use JasonKaz\FormBuild\Radio as Radio;			
	use JasonKaz\FormBuild\Button as Button;		
	use JasonKaz\FormBuild\Reset as Reset;
	use JasonKaz\FormBuild\Custom as Custom;
	use JasonKaz\FormBuild\Textarea as Textarea;
	use JasonKaz\FormBuild\Hidden as Hidden;
	use JasonKaz\FormBuild\Email as Email;
	require_once 'google-api-php-client/src/Google_Client.php';
	require_once 'google-api-php-client/src/contrib/Google_BooksService.php';
?>
<!DOCTYPE HTML>
<html lang-"en">
	<?php printHead('Western List'); ?>
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
                        <div class="span6"><h2>Sell a Textbook</h2></div>
                    </div>
                    <div class="row-fluid">
							<?php
							
								$Form=new Form;
								echo '<h4>Find a textbook by ISBN or title</h4>';
								echo $Form->init('buyselladd.php','get',array('class'=>'form-inline'))
									->group('',
										new Text(array('class'=>'input-large','name'=>'srchText','placeholder'=>'Enter ISBN or title')),
										new Submit('Search',array('class'=>'btn btn-primary'))
									)
									->render();

								$client = new Google_Client();
								$client->setDeveloperKey('AIzaSyCUXX2Wi9fKlaw2HTpgQnsFxG-0YTTIeW0');
								$client->setApplicationName("Books_Example_App");
								$service = new Google_BooksService($client);

								function postBookListing($dbc,$isbn = null,$title = null) {
									/*if (!$dbc->query($sql)) {
									  echo "Error!";
									  error_log(__FILE__ ."|" .$dbc->error ."\r\n",3,"errors/errors.log");
									}*/
									
									$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
									$book = new book($dbc,$isbn,$title);
									if (!$book->exists()) $book->createBook($isbn,null,$title,null,null);
									
									// Insert book listing
									/*$sql = "INSERT INTO BookListing
										(PostDate, UserID, BookID, BookConditionID, Price, ViewCount, ChangeSource, RecordStatus, RecordStatusDate)
										VALUES(NOW()," .$_SESSION['userID'] ."," .$bookID ."," .$_POST['condition'] ."," .$_POST['price'] .", 0, 0, 1, NOW());";
									$result = $dbc->query($sql);*/
									
									echo "
									  <div>
									    <b> Your book has been listed! </b>
									  </div>
									";
								}

								function echoSaleForm($dbc,$isbn, $title) {
									$sql = "SELECT BookConditionID, Description FROM BookCondition";
									$result = $dbc->query($sql);
									echo "<form action='buyselladd.php' method='POST'>";
									echo "Condition<br /> <select name='condition'>";
									while ($row = $result->fetch_row()) {
										echo "<option value='" .$row[0] ."'>" .$row[1] ."</option>";
									}
									echo "</select>";
									echo "<br />Price<br /><input type='text' name='price' placeholder='$' style='height:30px;'>";
									echo "<input type='hidden' name='isbn' value='" .$isbn ."' />";
									echo "<input type='hidden' name='title' value='" .$title ."' />";
									echo "<br /><input type='submit' value='Submit' style='height:30px;' />";
									echo "</form>";
								}

								function echoBookList($dbc, $results) {
								  if ($results['items'] != NULL) {
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

									  echo '<div class="span9">';
									  $thumbnailImg = ($thumbnail) ? "<a href='${preview}'><img alt='$title' src='${thumbnail}' style='float: left; margin: 12px; border:1px solid black' /></a>" : '';
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
										  echoSaleForm($dbc, $isbn, $title);
										  if (!isset($_GET['page'])) $page = 0;
										  else $page = $_GET['page'];
										  $prevPage = $page == 0? $page : $page - 1;
									  echo '</div>';
								    }
									  echo '
									  <div class="span9">
									  <div class="pagination pagination pagination-centered">
										<ul>
											<li><a href="?srchText=' .$_GET['srchText'] .'&page=' .$prevPage .'">&lt;&lt;</a></li>
											<li><a>Page ' .$page .'</a></li>
											<li><a href="?srchText=' .$_GET['srchText'] .'&page='  .($page + 1) .'">&gt;&gt;</a></li>
										</ul>
									</div>
									</div>';
								  }
								  else echo '<b>No results found</b>';
								}

							  $volumes = $service->volumes;
							  $maxResults = 20;
							  $startIndex = isset($_GET['page']) ? ($_GET['page'] * $maxResults) : 0;
							  $optParams = array('maxResults' => $maxResults, 'startIndex' => $startIndex);
							  $dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);

							  /* display a list of volumes */
							  if (isset($_GET['srchText'])) {
								 $srchText =  (is_numeric($_GET['srchText'])? 'isbn:' : 'intitle:') .$_GET['srchText'];
							  	 $results = $volumes->listVolumes($srchText, $optParams);
								 echoBookList($dbc, $results);
							  }

							  if (isset($_POST['isbn'])) {
									postBookListing($dbc, $_POST['isbn'],$_POST['title']);
							  }

							?>
					</div>
				</div>
			</div>
		</div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

