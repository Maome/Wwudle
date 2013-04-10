<?php
	require_once('init.php');
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
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Western List</title>
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
                        <div class="span6"><h2>Textbooks for Sale</h2></div>
						<div class="span4"><a class="btn btn-success" type="button" href="buyselladd.php">Sell an item</a></div>
                    </div>
                    <div class="row-fluid">
						<?php
						$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
						
						echo '<h4>Find a textbook by ISBN or title</h4>';
						$FormA=new Form;
						echo $FormA->init('','get',array('class'=>'form-inline'))
							->group('',
								new Text(array('class'=>'input-large','name'=>'srchText','placeholder'=>'Enter ISBN or title')),
								new Submit('Search',array('class'=>'btn btn-primary'))
							)
							->render();
						
						echo '<b>OR</b>';
						
						$FormB=new Form;
						echo '<h4>Find a textbook by course</h4>';
						echo $FormB->init('','get',array('class'=>'form-inline'))
							->group('',
								new Select($dbc->queryPairs('SELECT Abbreviation,Description FROM Department ORDER BY RowOrder,Abbreviation'),1, array('class'=>'input-large','name'=>'srchDept')),
								new Text(array('class'=>'input-medium','name'=>'srchCourse', 'placeholder'=>'Enter course number')),
								new Submit('Search',array('class'=>'btn btn-primary'))
							)
							->render();
							
						?>
                    </div>
					<div class="row-fluid">
						<?php
						
							function displayBookListings($srch, $isCourseSearch) {
								$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
								
								if ($isCourseSearch) $where = "WHERE COALESCE(bl.Course,'') LIKE '%" .$srch ."%'";
								else {
									if (is_numeric($srch)) {
										$where = "WHERE b.ISBN = " .$srch;
									}
									else $where = "WHERE COALESCE(b.Title,'') LIKE '%" .$srch ."%'";
								}
								
								$qry = "SELECT
												bl.PostID,
												b.ISBN,
												b.Title,
												bl.Price Price, 
												bc.Description
											 FROM BookListing bl
											 JOIN Book b
											 ON (b.BookID = bl.BookID)
											 LEFT JOIN BookCondition bc
											 ON (bc.BookConditionID = bl.BookConditionID)" 
											 .$where;
								$result = $dbc->query($qry);
								
								if ($result->num_rows > 0) {
									$fields = array("ISBN","Title","Price","Description");
									echo "<table class='table'>";
										// Display header
										echo "<tr>";
											foreach ($fields as $i) echo "<td>" .$i ."</td>";
										echo "</tr>";
										
										// Display rows
										while ($row = $result->fetch_assoc()) {
											echo "<tr>";
												foreach ($fields as $i){
													echo "<td>" .$row[$i] ."</td>";
												}
											echo "</tr>";
										}
									echo "</table>";
								}
								else echo "No results found";
							}
							
							if (isset($_GET['srchText'])) {
								displayBookListings($_GET['srchText'],0);
							}
							else if (isset($_GET['srchCourse']) || isset($_GET['srchDept'])) {
								$dept = trim($_GET['srchDept'] == 'ALL' ? '' : $_GET['srchDept']) .' ';
								displayBookListings(trim($dept .' ' .$_GET['srchCourse']),1);
							}
							else if (isset($_POST['postID'])) {
								echo "An email has been sent to the seller on your behalf.";
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

