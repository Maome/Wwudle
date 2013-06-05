<?php
	require_once('init.php');
	require_once('classes/utils.php');
	require_once('buysellfunctions.php');
	use JasonKaz\FormBuild\Form as Form;
	use JasonKaz\FormBuild\Text as Text;
	use JasonKaz\FormBuild\Submit as Submit;
	use JasonKaz\FormBuild\Select as Select;	
	use JasonKaz\FormBuild\Custom as Custom;
	use JasonKaz\FormBuild\Hidden as Hidden;
	use JasonKaz\FormBuild\Validation as Validation;
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title><?php Woodle(); ?></title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		  <link href="bootstrap/css/datepicker.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		  <link href="bootstrap/css/bootstrap-modal.css" rel="stylesheet">
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
							<?php
								ManagePostsNav(false, true);
								$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
								
								// Unset edit flag if user decided to cancel editing
								if (isset($_POST['submit']) && $_POST['submit'] == 'Cancel') {
									unset($_POST['edit']);
								}

								// Populate a table with the rideshares the user currently has posted
								$qry = "
									SELECT bl.PostID, b.ISBN, b.Title, bl.Price,
										CASE WHEN bl.CourseDept IS NULL THEN 'Unknown' ELSE CONCAT(CONCAT(bl.CourseDept, ' '), bl.CourseNumber) END Course
									FROM Book b 
									JOIN BookListing bl 
									ON (b.BookID=bl.BookID) 
									WHERE bl.UserID=" .$_SESSION['userID'] ." AND b.RecordStatus <> 3 AND bl.RecordStatus <> 3 
									ORDER BY PostID DESC;";
								$updateQry = "
									UPDATE BookListing SET
									RecordStatus = 2, 
									RecordStatusDate = NOW(),
									CourseDept = " .dbw::singleQuote($_POST['subject']) .",
									CourseNumber = " .dbw::singleQuote(strtoupper($_POST['courseNumber'])) .",
									Price = " .dbw::zeroIfEmpty($_POST['price']) ."
									WHERE PostID = " .$_POST['edit'];
								$dbc->queryToEditableTable($qry,'BookListing','PostID','bookPosts','managepostsbooks.php','editFunction', $updateQry);

								function editFunction($dbc, $id, $updateQuery) {
									$qry = 'SELECT b.Title,
										bl.BookConditionID, bl.Price, bl.CourseDept, bl.CourseNumber
									FROM BookListing bl
									JOIN Book b
									ON (b.BookID = bl.BookID)
									WHERE bl.RecordStatus <> 3 
									AND b.RecordStatus <> 3
									AND bl.PostID = ' .$id;
									$row = $dbc->querySingleRow($qry, true);
									$bookConditions = $dbc->queryPairs('SELECT BookConditionID, Description FROM BookCondition ORDER BY BookConditionID');
									$subjects = $dbc->queryPairs("
										SELECT 
											CASE WHEN Abbreviation = 'ALL' THEN 'NULL' ELSE Abbreviation END Abbreviation,
											CASE WHEN Abbreviation = 'ALL' THEN 'Choose a Subject' ELSE Description END Description 
										FROM Department 
										ORDER BY RowOrder, Abbreviation
									");
									
									$submitErrors = utils::getNonMatches(
											(isset($_POST['price']) ? array('/^(?=.)[0-9]{0,4}(\.[0-9]{2})?$/',$_POST['price'],'price') : ''),
											(!empty($_POST['courseNumber']) && $_POST['subject'] == 'NULL' ? array('/^((?!NULL).)*$/',$_POST['subject'],'subject') : ''),
											(!empty($_POST['courseNumber']) ? array('/^[1-6][0-9]{2}[A-Za-z]{0,1}$/',$_POST['courseNumber'],'courseNumber') : '')
									);
									
									if (empty($submitErrors) && isset($_POST['edit'])) {
                    $dbc->query($updateQuery);
										echo "<div><b>Your listing has been updated! <i class='icon-thumbs-up'></i></b></div><br />";
									}
									else {
										$invalidPrice = in_array('price',$submitErrors);
										$invalidCourseNumber = in_array('courseNumber',$submitErrors);
										$invalidSubject = in_array('subject',$submitErrors);
										$selectedBookCondition = (isset($_POST['bookCondition']) ? $_POST['bookCondition'] : $row['BookConditionID']);
										$selectedSubject = (isset($_POST['subject']) ? $_POST['subject'] : $row['CourseDept']);
										$inputCourseNumber = (isset($_POST['courseNumber']) && !$invalidCourseNumber ? $_POST['courseNumber'] : $row['CourseNumber']);
										$inputPrice = (isset($_POST['price']) && !$invalidPrice ? $_POST['price'] : $row['Price']);
										
										echo "<h3>Textbook Post for " .$row['Title'] ."</h3>";
										$bookForm = new Form;
										echo $bookForm->init('managepostsbooks.php?edit=' .$_GET['edit'],'post',array('class'=>'form-horizontal','style'=>'margin-left: -80px; margin-top: 25px;','name'=>'bookAdd'))
										->group('Condition',
											new Select($bookConditions, (int)$selectedBookCondition, array('class'=>'input-large','name'=>'bookCondition'))
										)
										->group('Subject',
											new Select($subjects, $selectedSubject, array('class'=>'input-large','name'=>'subject')),
											new Validation($invalidSubject,'Please choose a valid subject')
										)
										->group('Course',
											new Text(array('class'=>'input-small','name'=>'courseNumber', 'placeholder'=>'Course #','value'=>$inputCourseNumber)),
											new Validation($invalidCourseNumber, 'Please enter a valid course number')
										)
										->group('Price',
											new Text(array('class'=>'input-small','name'=>'price','placeholder'=>'$','value'=>$inputPrice)),
											new Validation($invalidPrice, 'Please enter a valid price')
										)
										->group('',
											new Hidden(array('name'=>'edit','value'=>$id)),
											new Submit('Submit', array('class'=>'btn btn-primary','name'=>'submit')),
											new Custom('<a href="managepostsbooks.php" class="btn btn-danger">Cancel</a>')											
										)
										->render();
									}
							}
						?>
                </div>
            </div>
		     </div>
		     <div id="push"></div>
        </div>
    	<?php DisplayFooter(); ?>
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
	 <script src="bootstrap/js/bootstrap-modal.js"></script>
	 <script src="bootstrap/js/bootstrap-modalmanager.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

